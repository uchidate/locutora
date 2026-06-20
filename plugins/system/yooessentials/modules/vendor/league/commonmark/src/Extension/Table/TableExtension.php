<?php

declare (strict_types=1);
/*
 * This is part of the league/commonmark package.
 *
 * (c) Martin Hasoň <martin.hason@gmail.com>
 * (c) Webuni s.r.o. <info@webuni.cz>
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Table;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\ConfigurableEnvironmentInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\ExtensionInterface;
final class TableExtension implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\ExtensionInterface
{
    public function register(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\ConfigurableEnvironmentInterface $environment) : void
    {
        $environment->addBlockParser(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Table\TableParser())->addBlockRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Table\Table::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Table\TableRenderer())->addBlockRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Table\TableSection::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Table\TableSectionRenderer())->addBlockRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Table\TableRow::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Table\TableRowRenderer())->addBlockRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Table\TableCell::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Table\TableCellRenderer());
    }
}
