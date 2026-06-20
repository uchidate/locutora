<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * Original code based on the CommonMark JS reference parser (http://bitly.com/commonmark-js)
 *  - (c) John MacFarlane
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\SmartPunct;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\ElementRendererInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\HtmlElement;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\AbstractInline;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Renderer\InlineRendererInterface;
final class QuoteRenderer implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Renderer\InlineRendererInterface
{
    /**
     * @param Quote                    $inline
     * @param ElementRendererInterface $htmlRenderer
     *
     * @return HtmlElement|string|null
     */
    public function render(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\AbstractInline $inline, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\ElementRendererInterface $htmlRenderer)
    {
        if (!$inline instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\SmartPunct\Quote) {
            throw new \InvalidArgumentException(\sprintf('Expected an instance of "%s", got "%s" instead', \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\SmartPunct\Quote::class, \get_class($inline)));
        }
        // Handles unpaired quotes which remain after processing delimiters
        if ($inline->getContent() === \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\SmartPunct\Quote::SINGLE_QUOTE) {
            // Render as an apostrophe
            return \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\SmartPunct\Quote::SINGLE_QUOTE_CLOSER;
        } elseif ($inline->getContent() === \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\SmartPunct\Quote::DOUBLE_QUOTE) {
            // Render as an opening quote
            return \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\SmartPunct\Quote::DOUBLE_QUOTE_OPENER;
        }
        return $inline->getContent();
    }
}
