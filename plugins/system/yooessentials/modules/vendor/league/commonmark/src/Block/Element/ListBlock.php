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
/**
 * @method children() AbstractBlock[]
 */
class ListBlock extends \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock
{
    const TYPE_BULLET = 'bullet';
    const TYPE_ORDERED = 'ordered';
    /**
     * @deprecated This constant is deprecated in league/commonmark 1.4 and will be removed in 2.0; use TYPE_BULLET instead
     */
    const TYPE_UNORDERED = self::TYPE_BULLET;
    /**
     * @var bool
     */
    protected $tight = \false;
    /**
     * @var ListData
     */
    protected $listData;
    public function __construct(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\ListData $listData)
    {
        $this->listData = $listData;
    }
    /**
     * @return ListData
     */
    public function getListData() : \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\ListData
    {
        return $this->listData;
    }
    public function endsWithBlankLine() : bool
    {
        if ($this->lastLineBlank) {
            return \true;
        }
        if ($this->hasChildren()) {
            return $this->lastChild() instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock && $this->lastChild()->endsWithBlankLine();
        }
        return \false;
    }
    public function canContain(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock $block) : bool
    {
        return $block instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\ListItem;
    }
    public function isCode() : bool
    {
        return \false;
    }
    public function matchesNextLine(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor $cursor) : bool
    {
        return \true;
    }
    public function finalize(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\ContextInterface $context, int $endLineNumber)
    {
        parent::finalize($context, $endLineNumber);
        $this->tight = \true;
        // tight by default
        foreach ($this->children() as $item) {
            if (!$item instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock) {
                continue;
            }
            // check for non-final list item ending with blank line:
            if ($item->endsWithBlankLine() && $item !== $this->lastChild()) {
                $this->tight = \false;
                break;
            }
            // Recurse into children of list item, to see if there are
            // spaces between any of them:
            foreach ($item->children() as $subItem) {
                if ($subItem instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock && $subItem->endsWithBlankLine() && ($item !== $this->lastChild() || $subItem !== $item->lastChild())) {
                    $this->tight = \false;
                    break;
                }
            }
        }
    }
    public function isTight() : bool
    {
        return $this->tight;
    }
    public function setTight(bool $tight) : self
    {
        $this->tight = $tight;
        return $this;
    }
}
