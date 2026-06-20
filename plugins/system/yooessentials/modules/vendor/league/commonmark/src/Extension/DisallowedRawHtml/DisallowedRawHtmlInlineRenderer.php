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

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\ElementRendererInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\AbstractInline;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Renderer\InlineRendererInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationAwareInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationInterface;
final class DisallowedRawHtmlInlineRenderer implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Renderer\InlineRendererInterface, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationAwareInterface
{
    /** @var InlineRendererInterface */
    private $htmlInlineRenderer;
    public function __construct(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Renderer\InlineRendererInterface $htmlBlockRenderer)
    {
        $this->htmlInlineRenderer = $htmlBlockRenderer;
    }
    public function render(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\AbstractInline $inline, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\ElementRendererInterface $htmlRenderer)
    {
        $rendered = $this->htmlInlineRenderer->render($inline, $htmlRenderer);
        if ($rendered === '') {
            return '';
        }
        // Match these types of tags: <title> </title> <title x="sdf"> <title/> <title />
        return \preg_replace('/<(\\/?(?:title|textarea|style|xmp|iframe|noembed|noframes|script|plaintext)[ \\/>])/i', '&lt;$1', $rendered);
    }
    public function setConfiguration(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationInterface $configuration)
    {
        if ($this->htmlInlineRenderer instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationAwareInterface) {
            $this->htmlInlineRenderer->setConfiguration($configuration);
        }
    }
}
