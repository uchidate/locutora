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

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Renderer\BlockRendererInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\ElementRendererInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationAwareInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationInterface;
final class DisallowedRawHtmlBlockRenderer implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Renderer\BlockRendererInterface, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationAwareInterface
{
    /** @var BlockRendererInterface */
    private $htmlBlockRenderer;
    public function __construct(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Renderer\BlockRendererInterface $htmlBlockRenderer)
    {
        $this->htmlBlockRenderer = $htmlBlockRenderer;
    }
    public function render(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock $block, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\ElementRendererInterface $htmlRenderer, bool $inTightList = \false)
    {
        $rendered = $this->htmlBlockRenderer->render($block, $htmlRenderer, $inTightList);
        if ($rendered === '') {
            return '';
        }
        // Match these types of tags: <title> </title> <title x="sdf"> <title/> <title />
        return \preg_replace('/<(\\/?(?:title|textarea|style|xmp|iframe|noembed|noframes|script|plaintext)[ \\/>])/i', '&lt;$1', $rendered);
    }
    public function setConfiguration(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationInterface $configuration)
    {
        if ($this->htmlBlockRenderer instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationAwareInterface) {
            $this->htmlBlockRenderer->setConfiguration($configuration);
        }
    }
}
