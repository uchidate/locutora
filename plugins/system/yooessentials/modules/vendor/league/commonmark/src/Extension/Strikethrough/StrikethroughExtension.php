<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com> and uAfrica.com (http://uafrica.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Strikethrough;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\ConfigurableEnvironmentInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\ExtensionInterface;
final class StrikethroughExtension implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\ExtensionInterface
{
    public function register(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\ConfigurableEnvironmentInterface $environment)
    {
        $environment->addDelimiterProcessor(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Strikethrough\StrikethroughDelimiterProcessor());
        $environment->addInlineRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Strikethrough\Strikethrough::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Strikethrough\StrikethroughRenderer());
    }
}
