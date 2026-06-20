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
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Renderer;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\ElementRendererInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\HtmlElement;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\AbstractInline;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\Image;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationAwareInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\RegexHelper;
final class ImageRenderer implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Renderer\InlineRendererInterface, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationAwareInterface
{
    /**
     * @var ConfigurationInterface
     */
    protected $config;
    /**
     * @param Image                    $inline
     * @param ElementRendererInterface $htmlRenderer
     *
     * @return HtmlElement
     */
    public function render(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\AbstractInline $inline, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\ElementRendererInterface $htmlRenderer)
    {
        if (!$inline instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\Image) {
            throw new \InvalidArgumentException('Incompatible inline type: ' . \get_class($inline));
        }
        $attrs = $inline->getData('attributes', []);
        $forbidUnsafeLinks = !$this->config->get('allow_unsafe_links');
        if ($forbidUnsafeLinks && \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\RegexHelper::isLinkPotentiallyUnsafe($inline->getUrl())) {
            $attrs['src'] = '';
        } else {
            $attrs['src'] = $inline->getUrl();
        }
        $alt = $htmlRenderer->renderInlines($inline->children());
        $alt = \preg_replace('/\\<[^>]*alt="([^"]*)"[^>]*\\>/', '$1', $alt);
        $attrs['alt'] = \preg_replace('/\\<[^>]*\\>/', '', $alt);
        if (isset($inline->data['title'])) {
            $attrs['title'] = $inline->data['title'];
        }
        return new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\HtmlElement('img', $attrs, '', \true);
    }
    public function setConfiguration(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationInterface $configuration)
    {
        $this->config = $configuration;
    }
}
