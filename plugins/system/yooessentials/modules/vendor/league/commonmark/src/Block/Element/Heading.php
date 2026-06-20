<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * Original code based on the CommonMark JS reference parser (https://bitly.com/commonmark-js)
 *  - (c) John MacFarlane
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\ContextInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor;
class Heading extends \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractStringContainerBlock implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\InlineContainerInterface
{
    /**
     * @var int
     */
    protected $level;
    /**
     * @param int             $level
     * @param string|string[] $contents
     */
    public function __construct(int $level, $contents)
    {
        parent::__construct();
        $this->level = $level;
        if (!\is_array($contents)) {
            $contents = [$contents];
        }
        foreach ($contents as $line) {
            $this->addLine($line);
        }
    }
    /**
     * @return int
     */
    public function getLevel() : int
    {
        return $this->level;
    }
    public function finalize(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\ContextInterface $context, int $endLineNumber)
    {
        parent::finalize($context, $endLineNumber);
        $this->finalStringContents = \implode("\n", $this->strings->toArray());
    }
    public function canContain(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock $block) : bool
    {
        return \false;
    }
    public function isCode() : bool
    {
        return \false;
    }
    public function matchesNextLine(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor $cursor) : bool
    {
        return \false;
    }
    public function handleRemainingContents(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\ContextInterface $context, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor $cursor)
    {
        // nothing to do; contents were already added via the constructor.
    }
}
