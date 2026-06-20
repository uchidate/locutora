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
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Event;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Document;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Event\DocumentParsedEvent;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Node\Footnote;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Node\FootnoteBackref;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Node\FootnoteContainer;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Reference\Reference;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationAwareInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationInterface;
final class GatherFootnotesListener implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationAwareInterface
{
    /** @var ConfigurationInterface */
    private $config;
    public function onDocumentParsed(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Event\DocumentParsedEvent $event) : void
    {
        $document = $event->getDocument();
        $walker = $document->walker();
        $footnotes = [];
        while ($event = $walker->next()) {
            if (!$event->isEntering()) {
                continue;
            }
            $node = $event->getNode();
            if (!$node instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Node\Footnote) {
                continue;
            }
            // Look for existing reference with footnote label
            $ref = $document->getReferenceMap()->getReference($node->getReference()->getLabel());
            if ($ref !== null) {
                // Use numeric title to get footnotes order
                $footnotes[\intval($ref->getTitle())] = $node;
            } else {
                // Footnote call is missing, append footnote at the end
                $footnotes[\INF] = $node;
            }
            /*
             * Look for all footnote refs pointing to this footnote
             * and create each footnote backrefs.
             */
            $backrefs = $document->getData('#' . $this->config->get('footnote/footnote_id_prefix', 'fn:') . $node->getReference()->getDestination(), []);
            /** @var Reference $backref */
            foreach ($backrefs as $backref) {
                $node->addBackref(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Node\FootnoteBackref(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Reference\Reference($backref->getLabel(), '#' . $this->config->get('footnote/ref_id_prefix', 'fnref:') . $backref->getLabel(), $backref->getTitle())));
            }
        }
        // Only add a footnote container if there are any
        if (\count($footnotes) === 0) {
            return;
        }
        $container = $this->getFootnotesContainer($document);
        \ksort($footnotes);
        foreach ($footnotes as $footnote) {
            $container->appendChild($footnote);
        }
    }
    private function getFootnotesContainer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Document $document) : \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Node\FootnoteContainer
    {
        $footnoteContainer = new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Node\FootnoteContainer();
        $document->appendChild($footnoteContainer);
        return $footnoteContainer;
    }
    public function setConfiguration(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationInterface $config) : void
    {
        $this->config = $config;
    }
}
