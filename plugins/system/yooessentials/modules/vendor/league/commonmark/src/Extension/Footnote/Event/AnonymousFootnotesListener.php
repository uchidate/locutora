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

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Paragraph;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Event\DocumentParsedEvent;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Node\Footnote;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Node\FootnoteBackref;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Node\FootnoteRef;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\Text;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Reference\Reference;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationAwareInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationInterface;
final class AnonymousFootnotesListener implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationAwareInterface
{
    /** @var ConfigurationInterface */
    private $config;
    public function onDocumentParsed(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Event\DocumentParsedEvent $event) : void
    {
        $document = $event->getDocument();
        $walker = $document->walker();
        while ($event = $walker->next()) {
            $node = $event->getNode();
            if ($node instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Node\FootnoteRef && $event->isEntering() && null !== ($text = $node->getContent())) {
                // Anonymous footnote needs to create a footnote from its content
                $existingReference = $node->getReference();
                $reference = new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Reference\Reference($existingReference->getLabel(), '#' . $this->config->get('footnote/ref_id_prefix', 'fnref:') . $existingReference->getLabel(), $existingReference->getTitle());
                $footnote = new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Node\Footnote($reference);
                $footnote->addBackref(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Node\FootnoteBackref($reference));
                $paragraph = new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Paragraph();
                $paragraph->appendChild(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\Text($text));
                $footnote->appendChild($paragraph);
                $document->appendChild($footnote);
            }
        }
    }
    public function setConfiguration(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationInterface $config) : void
    {
        $this->config = $config;
    }
}
