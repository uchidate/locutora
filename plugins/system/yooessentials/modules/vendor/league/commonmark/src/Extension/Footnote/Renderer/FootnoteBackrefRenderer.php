<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 * (c) Rezo Zero / Ambroise Maupate
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare (strict_types=1);
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Renderer;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\ElementRendererInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Node\FootnoteBackref;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\HtmlElement;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\AbstractInline;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Renderer\InlineRendererInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationAwareInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationInterface;
final class FootnoteBackrefRenderer implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Renderer\InlineRendererInterface, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationAwareInterface
{
    /** @var ConfigurationInterface */
    private $config;
    public function render(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\AbstractInline $inline, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\ElementRendererInterface $htmlRenderer)
    {
        if (!$inline instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Node\FootnoteBackref) {
            throw new \InvalidArgumentException('Incompatible inline type: ' . \get_class($inline));
        }
        $attrs = $inline->getData('attributes', []);
        $attrs['class'] = $attrs['class'] ?? $this->config->get('footnote/backref_class', 'footnote-backref');
        $attrs['rev'] = 'footnote';
        $attrs['href'] = \mb_strtolower($inline->getReference()->getDestination());
        $attrs['role'] = 'doc-backlink';
        return '&nbsp;' . new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\HtmlElement('a', $attrs, '&#8617;', \true);
    }
    public function setConfiguration(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationInterface $configuration)
    {
        $this->config = $configuration;
    }
}
