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
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\ThematicBreak;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\ElementRendererInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\HtmlElement;
final class ThematicBreakRenderer implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Renderer\BlockRendererInterface
{
    /**
     * @param ThematicBreak            $block
     * @param ElementRendererInterface $htmlRenderer
     * @param bool                     $inTightList
     *
     * @return HtmlElement
     */
    public function render(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock $block, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\ElementRendererInterface $htmlRenderer, bool $inTightList = \false)
    {
        if (!$block instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\ThematicBreak) {
            throw new \InvalidArgumentException('Incompatible block type: ' . \get_class($block));
        }
        $attrs = $block->getData('attributes', []);
        return new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\HtmlElement('hr', $attrs, '', \true);
    }
}
