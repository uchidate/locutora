<?php

declare (strict_types=1);
/*
 * This is part of the league/commonmark package.
 *
 * (c) Martin Hasoň <martin.hason@gmail.com>
 * (c) Webuni s.r.o. <info@webuni.cz>
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Table;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Document;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Paragraph;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Parser\BlockParserInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Context;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\ContextInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\EnvironmentAwareInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\EnvironmentInterface;
final class TableParser implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Parser\BlockParserInterface, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\EnvironmentAwareInterface
{
    /**
     * @var EnvironmentInterface
     */
    private $environment;
    public function parse(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\ContextInterface $context, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor $cursor) : bool
    {
        $container = $context->getContainer();
        if (!$container instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Paragraph) {
            return \false;
        }
        $lines = $container->getStrings();
        if (\count($lines) === 0) {
            return \false;
        }
        $lastLine = \array_pop($lines);
        if (\strpos($lastLine, '|') === \false) {
            return \false;
        }
        $oldState = $cursor->saveState();
        $cursor->advanceToNextNonSpaceOrTab();
        $columns = $this->parseColumns($cursor);
        if (empty($columns)) {
            $cursor->restoreState($oldState);
            return \false;
        }
        $head = $this->parseRow(\trim((string) $lastLine), $columns, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Table\TableCell::TYPE_HEAD);
        if (null === $head) {
            $cursor->restoreState($oldState);
            return \false;
        }
        $table = new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Table\Table(function (\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor $cursor, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Table\Table $table) use($columns) : bool {
            // The next line cannot be a new block start
            // This is a bit inefficient, but it's the only feasible way to check
            // given the current v1 API.
            if (self::isANewBlock($this->environment, $cursor->getLine())) {
                return \false;
            }
            $row = $this->parseRow(\trim($cursor->getLine()), $columns);
            if (null === $row) {
                return \false;
            }
            $table->getBody()->appendChild($row);
            return \true;
        });
        $table->getHead()->appendChild($head);
        if (\count($lines) >= 1) {
            $paragraph = new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Paragraph();
            foreach ($lines as $line) {
                $paragraph->addLine($line);
            }
            $context->replaceContainerBlock($paragraph);
            $context->addBlock($table);
        } else {
            $context->replaceContainerBlock($table);
        }
        return \true;
    }
    /**
     * @param string             $line
     * @param array<int, string> $columns
     * @param string             $type
     *
     * @return TableRow|null
     */
    private function parseRow(string $line, array $columns, string $type = \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Table\TableCell::TYPE_BODY) : ?\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Table\TableRow
    {
        $cells = $this->split(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor(\trim($line)));
        if (empty($cells)) {
            return null;
        }
        // The header row must match the delimiter row in the number of cells
        if ($type === \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Table\TableCell::TYPE_HEAD && \count($cells) !== \count($columns)) {
            return null;
        }
        $i = 0;
        $row = new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Table\TableRow();
        foreach ($cells as $i => $cell) {
            if (!\array_key_exists($i, $columns)) {
                return $row;
            }
            $row->appendChild(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Table\TableCell(\trim($cell), $type, $columns[$i]));
        }
        for ($j = \count($columns) - 1; $j > $i; --$j) {
            $row->appendChild(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Table\TableCell('', $type, null));
        }
        return $row;
    }
    /**
     * @param Cursor $cursor
     *
     * @return array<int, string>
     */
    private function split(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor $cursor) : array
    {
        if ($cursor->getCharacter() === '|') {
            $cursor->advanceBy(1);
        }
        $cells = [];
        $sb = '';
        while (!$cursor->isAtEnd()) {
            switch ($c = $cursor->getCharacter()) {
                case '\\':
                    if ($cursor->peek() === '|') {
                        // Pipe is special for table parsing. An escaped pipe doesn't result in a new cell, but is
                        // passed down to inline parsing as an unescaped pipe. Note that that applies even for the `\|`
                        // in an input like `\\|` - in other words, table parsing doesn't support escaping backslashes.
                        $sb .= '|';
                        $cursor->advanceBy(1);
                    } else {
                        // Preserve backslash before other characters or at end of line.
                        $sb .= '\\';
                    }
                    break;
                case '|':
                    $cells[] = $sb;
                    $sb = '';
                    break;
                default:
                    $sb .= $c;
            }
            $cursor->advanceBy(1);
        }
        if ($sb !== '') {
            $cells[] = $sb;
        }
        return $cells;
    }
    /**
     * @param Cursor $cursor
     *
     * @return array<int, string>
     */
    private function parseColumns(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor $cursor) : array
    {
        $columns = [];
        $pipes = 0;
        $valid = \false;
        while (!$cursor->isAtEnd()) {
            switch ($c = $cursor->getCharacter()) {
                case '|':
                    $cursor->advanceBy(1);
                    $pipes++;
                    if ($pipes > 1) {
                        // More than one adjacent pipe not allowed
                        return [];
                    }
                    // Need at least one pipe, even for a one-column table
                    $valid = \true;
                    break;
                case '-':
                case ':':
                    if ($pipes === 0 && !empty($columns)) {
                        // Need a pipe after the first column (first column doesn't need to start with one)
                        return [];
                    }
                    $left = \false;
                    $right = \false;
                    if ($c === ':') {
                        $left = \true;
                        $cursor->advanceBy(1);
                    }
                    if ($cursor->match('/^-+/') === null) {
                        // Need at least one dash
                        return [];
                    }
                    if ($cursor->getCharacter() === ':') {
                        $right = \true;
                        $cursor->advanceBy(1);
                    }
                    $columns[] = $this->getAlignment($left, $right);
                    // Next, need another pipe
                    $pipes = 0;
                    break;
                case ' ':
                case "\t":
                    // White space is allowed between pipes and columns
                    $cursor->advanceToNextNonSpaceOrTab();
                    break;
                default:
                    // Any other character is invalid
                    return [];
            }
        }
        if (!$valid) {
            return [];
        }
        return $columns;
    }
    private static function getAlignment(bool $left, bool $right) : ?string
    {
        if ($left && $right) {
            return \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Table\TableCell::ALIGN_CENTER;
        } elseif ($left) {
            return \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Table\TableCell::ALIGN_LEFT;
        } elseif ($right) {
            return \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Table\TableCell::ALIGN_RIGHT;
        }
        return null;
    }
    public function setEnvironment(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\EnvironmentInterface $environment)
    {
        $this->environment = $environment;
    }
    private static function isANewBlock(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\EnvironmentInterface $environment, string $line) : bool
    {
        $context = new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Context(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Document(), $environment);
        $context->setNextLine($line);
        $cursor = new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor($line);
        /** @var BlockParserInterface $parser */
        foreach ($environment->getBlockParsers() as $parser) {
            if ($parser->parse($context, $cursor)) {
                return \true;
            }
        }
        return \false;
    }
}
