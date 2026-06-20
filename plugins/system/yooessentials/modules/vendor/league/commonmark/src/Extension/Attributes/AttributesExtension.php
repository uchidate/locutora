<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 * (c) 2015 Martin Hasoň <martin.hason@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare (strict_types=1);
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Attributes;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\ConfigurableEnvironmentInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Event\DocumentParsedEvent;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Attributes\Event\AttributesListener;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Attributes\Parser\AttributesBlockParser;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Attributes\Parser\AttributesInlineParser;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\ExtensionInterface;
final class AttributesExtension implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\ExtensionInterface
{
    public function register(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\ConfigurableEnvironmentInterface $environment)
    {
        $environment->addBlockParser(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Attributes\Parser\AttributesBlockParser());
        $environment->addInlineParser(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Attributes\Parser\AttributesInlineParser());
        $environment->addEventListener(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Event\DocumentParsedEvent::class, [new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Attributes\Event\AttributesListener(), 'processDocument']);
    }
}
