<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\HeadingPermalink;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\ConfigurableEnvironmentInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Event\DocumentParsedEvent;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\ExtensionInterface;
/**
 * Extension which automatically anchor links to heading elements
 */
final class HeadingPermalinkExtension implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\ExtensionInterface
{
    public function register(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\ConfigurableEnvironmentInterface $environment)
    {
        $environment->addEventListener(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Event\DocumentParsedEvent::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkProcessor(), -100);
        $environment->addInlineRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\HeadingPermalink\HeadingPermalink::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkRenderer());
    }
}
