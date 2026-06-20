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

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Node\Node;
final class TableRow extends \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock
{
    public function canContain(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock $block) : bool
    {
        return $block instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Table\TableCell;
    }
    public function isCode() : bool
    {
        return \false;
    }
    public function matchesNextLine(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor $cursor) : bool
    {
        return \false;
    }
    /**
     * @return AbstractBlock[]
     */
    public function children() : iterable
    {
        return \array_filter((array) parent::children(), static function (\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Node\Node $child) : bool {
            return $child instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock;
        });
    }
}
