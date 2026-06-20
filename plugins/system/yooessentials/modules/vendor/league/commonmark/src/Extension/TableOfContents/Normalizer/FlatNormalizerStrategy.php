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
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\Node\TableOfContents;
final class FlatNormalizerStrategy implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\Normalizer\NormalizerStrategyInterface
{
    /** @var TableOfContents */
    private $toc;
    public function __construct(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\Node\TableOfContents $toc)
    {
        $this->toc = $toc;
    }
    public function addItem(int $level, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\ListItem $listItemToAdd) : void
    {
        $this->toc->appendChild($listItemToAdd);
    }
}
// Trigger autoload without causing a deprecated error
\class_exists(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\Node\TableOfContents::class);
