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
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Renderer;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\ListItem;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Paragraph;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\ElementRendererInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TaskList\TaskListItemMarker;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\HtmlElement;
final class ListItemRenderer implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Renderer\BlockRendererInterface
{
    /**
     * @param ListItem                 $block
     * @param ElementRendererInterface $htmlRenderer
     * @param bool                     $inTightList
     *
     * @return string
     */
    public function render(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock $block, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\ElementRendererInterface $htmlRenderer, bool $inTightList = \false)
    {
        if (!$block instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\ListItem) {
            throw new \InvalidArgumentException('Incompatible block type: ' . \get_class($block));
        }
        $contents = $htmlRenderer->renderBlocks($block->children(), $inTightList);
        if (\substr($contents, 0, 1) === '<' && !$this->startsTaskListItem($block)) {
            $contents = "\n" . $contents;
        }
        if (\substr($contents, -1, 1) === '>') {
            $contents .= "\n";
        }
        $attrs = $block->getData('attributes', []);
        $li = new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\HtmlElement('li', $attrs, $contents);
        return $li;
    }
    private function startsTaskListItem(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\ListItem $block) : bool
    {
        $firstChild = $block->firstChild();
        return $firstChild instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Paragraph && $firstChild->firstChild() instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TaskList\TaskListItemMarker;
    }
}
