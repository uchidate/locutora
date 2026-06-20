<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\DisallowedRawHtml;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\HtmlBlock;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Renderer\HtmlBlockRenderer;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\ConfigurableEnvironmentInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\ExtensionInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\HtmlInline;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Renderer\HtmlInlineRenderer;
final class DisallowedRawHtmlExtension implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\ExtensionInterface
{
    public function register(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\ConfigurableEnvironmentInterface $environment)
    {
        $environment->addBlockRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\HtmlBlock::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\DisallowedRawHtml\DisallowedRawHtmlBlockRenderer(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Renderer\HtmlBlockRenderer()), 50);
        $environment->addInlineRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\HtmlInline::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\DisallowedRawHtml\DisallowedRawHtmlInlineRenderer(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Renderer\HtmlInlineRenderer()), 50);
    }
}
