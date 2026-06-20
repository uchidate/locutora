<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TaskList;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\ConfigurableEnvironmentInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\ExtensionInterface;
final class TaskListExtension implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\ExtensionInterface
{
    public function register(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\ConfigurableEnvironmentInterface $environment)
    {
        $environment->addInlineParser(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TaskList\TaskListItemMarkerParser(), 35);
        $environment->addInlineRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TaskList\TaskListItemMarker::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TaskList\TaskListItemMarkerRenderer());
    }
}
