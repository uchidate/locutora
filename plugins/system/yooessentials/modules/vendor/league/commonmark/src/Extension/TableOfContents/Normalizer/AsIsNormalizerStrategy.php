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

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\ListBlock;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\ListItem;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\Node\TableOfContents;
final class AsIsNormalizerStrategy implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\Normalizer\NormalizerStrategyInterface
{
    /** @var ListBlock */
    private $parentListBlock;
    /** @var int */
    private $parentLevel = 1;
    /** @var ListItem|null */
    private $lastListItem;
    public function __construct(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\Node\TableOfContents $toc)
    {
        $this->parentListBlock = $toc;
    }
    public function addItem(int $level, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\ListItem $listItemToAdd) : void
    {
        while ($level > $this->parentLevel) {
            // Descend downwards, creating new ListBlocks if needed, until we reach the correct depth
            if ($this->lastListItem === null) {
                $this->lastListItem = new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\ListItem($this->parentListBlock->getListData());
                $this->parentListBlock->appendChild($this->lastListItem);
            }
            $newListBlock = new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\ListBlock($this->parentListBlock->getListData());
            $newListBlock->setStartLine($listItemToAdd->getStartLine());
            $newListBlock->setEndLine($listItemToAdd->getEndLine());
            $this->lastListItem->appendChild($newListBlock);
            $this->parentListBlock = $newListBlock;
            $this->lastListItem = null;
            $this->parentLevel++;
        }
        while ($level < $this->parentLevel) {
            // Search upwards for the previous parent list block
            while (\true) {
                $this->parentListBlock = $this->parentListBlock->parent();
                if ($this->parentListBlock instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\ListBlock) {
                    break;
                }
            }
            $this->parentLevel--;
        }
        $this->parentListBlock->appendChild($listItemToAdd);
        $this->lastListItem = $listItemToAdd;
    }
}
// Trigger autoload without causing a deprecated error
\class_exists(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\Node\TableOfContents::class);
