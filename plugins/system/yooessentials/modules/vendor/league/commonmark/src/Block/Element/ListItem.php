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

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor;
/**
 * @method children() AbstractBlock[]
 */
class ListItem extends \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock
{
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
    public function canContain(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock $block) : bool
    {
        return \true;
    }
    public function isCode() : bool
    {
        return \false;
    }
    public function matchesNextLine(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor $cursor) : bool
    {
        if ($cursor->isBlank()) {
            if ($this->firstChild === null) {
                return \false;
            }
            $cursor->advanceToNextNonSpaceOrTab();
        } elseif ($cursor->getIndent() >= $this->listData->markerOffset + $this->listData->padding) {
            $cursor->advanceBy($this->listData->markerOffset + $this->listData->padding, \true);
        } else {
            return \false;
        }
        return \true;
    }
    public function shouldLastLineBeBlank(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor $cursor, int $currentLineNumber) : bool
    {
        return $cursor->isBlank() && $this->startLine < $currentLineNumber;
    }
}
