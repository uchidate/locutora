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
class Paragraph extends \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractStringContainerBlock implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\InlineContainerInterface
{
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
        if ($cursor->isBlank()) {
            $this->lastLineBlank = \true;
            return \false;
        }
        return \true;
    }
    public function finalize(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\ContextInterface $context, int $endLineNumber)
    {
        parent::finalize($context, $endLineNumber);
        $this->finalStringContents = \preg_replace('/^  */m', '', \implode("\n", $this->getStrings()));
        // Short-circuit
        if ($this->finalStringContents === '' || $this->finalStringContents[0] !== '[') {
            return;
        }
        $cursor = new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor($this->finalStringContents);
        $referenceFound = $this->parseReferences($context, $cursor);
        $this->finalStringContents = $cursor->getRemainder();
        if ($referenceFound && $cursor->isAtEnd()) {
            $this->detach();
        }
    }
    /**
     * @param ContextInterface $context
     * @param Cursor           $cursor
     *
     * @return bool
     */
    protected function parseReferences(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\ContextInterface $context, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor $cursor)
    {
        $referenceFound = \false;
        while ($cursor->getCharacter() === '[' && $context->getReferenceParser()->parse($cursor)) {
            $this->finalStringContents = $cursor->getRemainder();
            $referenceFound = \true;
        }
        return $referenceFound;
    }
    public function handleRemainingContents(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\ContextInterface $context, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor $cursor)
    {
        $cursor->advanceToNextNonSpaceOrTab();
        /** @var self $tip */
        $tip = $context->getTip();
        $tip->addLine($cursor->getRemainder());
    }
    /**
     * @return string[]
     */
    public function getStrings() : array
    {
        return $this->strings->toArray();
    }
}
