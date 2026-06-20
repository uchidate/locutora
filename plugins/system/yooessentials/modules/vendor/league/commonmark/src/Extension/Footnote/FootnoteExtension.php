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
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\ConfigurableEnvironmentInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Event\DocumentParsedEvent;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\ExtensionInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Event\AnonymousFootnotesListener;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Event\GatherFootnotesListener;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Event\NumberFootnotesListener;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Node\Footnote;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Node\FootnoteBackref;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Node\FootnoteContainer;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Node\FootnoteRef;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Parser\AnonymousFootnoteRefParser;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Parser\FootnoteParser;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Parser\FootnoteRefParser;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Renderer\FootnoteBackrefRenderer;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Renderer\FootnoteContainerRenderer;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Renderer\FootnoteRefRenderer;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Renderer\FootnoteRenderer;
final class FootnoteExtension implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\ExtensionInterface
{
    public function register(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\ConfigurableEnvironmentInterface $environment)
    {
        $environment->addBlockParser(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Parser\FootnoteParser(), 51);
        $environment->addInlineParser(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Parser\AnonymousFootnoteRefParser(), 35);
        $environment->addInlineParser(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Parser\FootnoteRefParser(), 51);
        $environment->addBlockRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Node\FootnoteContainer::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Renderer\FootnoteContainerRenderer());
        $environment->addBlockRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Node\Footnote::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Renderer\FootnoteRenderer());
        $environment->addInlineRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Node\FootnoteRef::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Renderer\FootnoteRefRenderer());
        $environment->addInlineRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Node\FootnoteBackref::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Renderer\FootnoteBackrefRenderer());
        $environment->addEventListener(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Event\DocumentParsedEvent::class, [new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Event\AnonymousFootnotesListener(), 'onDocumentParsed']);
        $environment->addEventListener(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Event\DocumentParsedEvent::class, [new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Event\NumberFootnotesListener(), 'onDocumentParsed']);
        $environment->addEventListener(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Event\DocumentParsedEvent::class, [new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Event\GatherFootnotesListener(), 'onDocumentParsed']);
    }
}
