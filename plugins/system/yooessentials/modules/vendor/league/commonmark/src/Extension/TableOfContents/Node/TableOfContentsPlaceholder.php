<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\Node;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor;
final class TableOfContentsPlaceholder extends \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock
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
        return \false;
    }
}
