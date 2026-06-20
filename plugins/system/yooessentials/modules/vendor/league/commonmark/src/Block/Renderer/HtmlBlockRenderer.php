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
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\HtmlBlock;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\ElementRendererInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\EnvironmentInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationAwareInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationInterface;
final class HtmlBlockRenderer implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Renderer\BlockRendererInterface, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationAwareInterface
{
    /**
     * @var ConfigurationInterface
     */
    protected $config;
    /**
     * @param HtmlBlock                $block
     * @param ElementRendererInterface $htmlRenderer
     * @param bool                     $inTightList
     *
     * @return string
     */
    public function render(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock $block, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\ElementRendererInterface $htmlRenderer, bool $inTightList = \false)
    {
        if (!$block instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\HtmlBlock) {
            throw new \InvalidArgumentException('Incompatible block type: ' . \get_class($block));
        }
        if ($this->config->get('html_input') === \ZOOlanders\YOOessentials\Vendor\League\CommonMark\EnvironmentInterface::HTML_INPUT_STRIP) {
            return '';
        }
        if ($this->config->get('html_input') === \ZOOlanders\YOOessentials\Vendor\League\CommonMark\EnvironmentInterface::HTML_INPUT_ESCAPE) {
            return \htmlspecialchars($block->getStringContent(), \ENT_NOQUOTES);
        }
        return $block->getStringContent();
    }
    public function setConfiguration(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationInterface $configuration)
    {
        $this->config = $configuration;
    }
}
