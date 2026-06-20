<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Document;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Heading;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Event\DocumentParsedEvent;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Exception\InvalidOptionException;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\HeadingPermalink\HeadingPermalink;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\Node\TableOfContents;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\Node\TableOfContentsPlaceholder;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationAwareInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationInterface;
final class TableOfContentsBuilder implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationAwareInterface
{
    /**
     * @deprecated Use TableOfContentsGenerator::STYLE_BULLET instead
     */
    public const STYLE_BULLET = \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\TableOfContentsGenerator::STYLE_BULLET;
    /**
     * @deprecated Use TableOfContentsGenerator::STYLE_ORDERED instead
     */
    public const STYLE_ORDERED = \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\TableOfContentsGenerator::STYLE_ORDERED;
    /**
     * @deprecated Use TableOfContentsGenerator::NORMALIZE_DISABLED instead
     */
    public const NORMALIZE_DISABLED = \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\TableOfContentsGenerator::NORMALIZE_DISABLED;
    /**
     * @deprecated Use TableOfContentsGenerator::NORMALIZE_RELATIVE instead
     */
    public const NORMALIZE_RELATIVE = \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\TableOfContentsGenerator::NORMALIZE_RELATIVE;
    /**
     * @deprecated Use TableOfContentsGenerator::NORMALIZE_FLAT instead
     */
    public const NORMALIZE_FLAT = \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\TableOfContentsGenerator::NORMALIZE_FLAT;
    public const POSITION_TOP = 'top';
    public const POSITION_BEFORE_HEADINGS = 'before-headings';
    public const POSITION_PLACEHOLDER = 'placeholder';
    /** @var ConfigurationInterface */
    private $config;
    public function onDocumentParsed(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Event\DocumentParsedEvent $event) : void
    {
        $document = $event->getDocument();
        $generator = new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\TableOfContentsGenerator($this->config->get('table_of_contents/style', \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\TableOfContentsGenerator::STYLE_BULLET), $this->config->get('table_of_contents/normalize', \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\TableOfContentsGenerator::NORMALIZE_RELATIVE), (int) $this->config->get('table_of_contents/min_heading_level', 1), (int) $this->config->get('table_of_contents/max_heading_level', 6));
        $toc = $generator->generate($document);
        if ($toc === null) {
            // No linkable headers exist, so no TOC could be generated
            return;
        }
        // Add custom CSS class(es), if defined
        $class = $this->config->get('table_of_contents/html_class', 'table-of-contents');
        if (!empty($class)) {
            $toc->data['attributes']['class'] = $class;
        }
        // Add the TOC to the Document
        $position = $this->config->get('table_of_contents/position', self::POSITION_TOP);
        if ($position === self::POSITION_TOP) {
            $document->prependChild($toc);
        } elseif ($position === self::POSITION_BEFORE_HEADINGS) {
            $this->insertBeforeFirstLinkedHeading($document, $toc);
        } elseif ($position === self::POSITION_PLACEHOLDER) {
            $this->replacePlaceholders($document, $toc);
        } else {
            throw new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Exception\InvalidOptionException(\sprintf('Invalid config option "%s" for "table_of_contents/position"', $position));
        }
    }
    private function insertBeforeFirstLinkedHeading(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Document $document, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\Node\TableOfContents $toc) : void
    {
        $walker = $document->walker();
        while ($event = $walker->next()) {
            if ($event->isEntering() && ($node = $event->getNode()) instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\HeadingPermalink\HeadingPermalink && ($parent = $node->parent()) instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Heading) {
                $parent->insertBefore($toc);
                return;
            }
        }
    }
    private function replacePlaceholders(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Document $document, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\Node\TableOfContents $toc) : void
    {
        $walker = $document->walker();
        while ($event = $walker->next()) {
            // Add the block once we find a placeholder (and we're about to leave it)
            if (!$event->getNode() instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\Node\TableOfContentsPlaceholder) {
                continue;
            }
            if ($event->isEntering()) {
                continue;
            }
            $event->getNode()->replaceWith(clone $toc);
        }
    }
    public function setConfiguration(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationInterface $config)
    {
        $this->config = $config;
    }
}
