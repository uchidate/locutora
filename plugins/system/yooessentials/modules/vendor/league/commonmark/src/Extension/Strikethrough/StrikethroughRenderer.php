<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com> and uAfrica.com (http://uafrica.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Strikethrough;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\ElementRendererInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\HtmlElement;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\AbstractInline;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Renderer\InlineRendererInterface;
final class StrikethroughRenderer implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Renderer\InlineRendererInterface
{
    public function render(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\AbstractInline $inline, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\ElementRendererInterface $htmlRenderer)
    {
        if (!$inline instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Strikethrough\Strikethrough) {
            throw new \InvalidArgumentException('Incompatible inline type: ' . \get_class($inline));
        }
        return new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\HtmlElement('del', $inline->getData('attributes', []), $htmlRenderer->renderInlines($inline->children()));
    }
}
