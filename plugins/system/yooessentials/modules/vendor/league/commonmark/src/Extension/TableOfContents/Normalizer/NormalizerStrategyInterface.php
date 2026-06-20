<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\Normalizer;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\ListItem;
interface NormalizerStrategyInterface
{
    public function addItem(int $level, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\ListItem $listItemToAdd) : void;
}
