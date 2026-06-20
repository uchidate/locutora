<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\ConfigurableEnvironmentInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Autolink\AutolinkExtension;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\DisallowedRawHtml\DisallowedRawHtmlExtension;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Strikethrough\StrikethroughExtension;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Table\TableExtension;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TaskList\TaskListExtension;
final class GithubFlavoredMarkdownExtension implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\ExtensionInterface
{
    public function register(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\ConfigurableEnvironmentInterface $environment)
    {
        $environment->addExtension(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Autolink\AutolinkExtension());
        $environment->addExtension(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\DisallowedRawHtml\DisallowedRawHtmlExtension());
        $environment->addExtension(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Strikethrough\StrikethroughExtension());
        $environment->addExtension(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Table\TableExtension());
        $environment->addExtension(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TaskList\TaskListExtension());
    }
}
