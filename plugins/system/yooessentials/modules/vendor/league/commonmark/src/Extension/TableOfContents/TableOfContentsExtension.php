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

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\ConfigurableEnvironmentInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Event\DocumentParsedEvent;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\ExtensionInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\Node\TableOfContentsPlaceholder;
final class TableOfContentsExtension implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\ExtensionInterface
{
    public function register(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\ConfigurableEnvironmentInterface $environment) : void
    {
        $environment->addEventListener(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Event\DocumentParsedEvent::class, [new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\TableOfContentsBuilder(), 'onDocumentParsed'], -150);
        if ($environment->getConfig('table_of_contents/position') === \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\TableOfContentsBuilder::POSITION_PLACEHOLDER) {
            $environment->addBlockParser(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\TableOfContentsPlaceholderParser(), 200);
            // If a placeholder cannot be replaced with a TOC element this renderer will ensure the parser won't error out
            $environment->addBlockRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\Node\TableOfContentsPlaceholder::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\TableOfContentsPlaceholderRenderer());
        }
    }
}
