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
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\EnvironmentInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\AbstractInline;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\HtmlInline;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationAwareInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationInterface;
final class HtmlInlineRenderer implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Renderer\InlineRendererInterface, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationAwareInterface
{
    /**
     * @var ConfigurationInterface
     */
    protected $config;
    /**
     * @param HtmlInline               $inline
     * @param ElementRendererInterface $htmlRenderer
     *
     * @return string
     */
    public function render(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\AbstractInline $inline, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\ElementRendererInterface $htmlRenderer)
    {
        if (!$inline instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\HtmlInline) {
            throw new \InvalidArgumentException('Incompatible inline type: ' . \get_class($inline));
        }
        if ($this->config->get('html_input') === \ZOOlanders\YOOessentials\Vendor\League\CommonMark\EnvironmentInterface::HTML_INPUT_STRIP) {
            return '';
        }
        if ($this->config->get('html_input') === \ZOOlanders\YOOessentials\Vendor\League\CommonMark\EnvironmentInterface::HTML_INPUT_ESCAPE) {
            return \htmlspecialchars($inline->getContent(), \ENT_NOQUOTES);
        }
        return $inline->getContent();
    }
    public function setConfiguration(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationInterface $configuration)
    {
        $this->config = $configuration;
    }
}
