<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Rss;

use ZOOlanders\YOOessentials\Source\Resolver\AbstractResolver;
use ZOOlanders\YOOessentials\Source\Resolver\Filters\InMemoryFilters;
use ZOOlanders\YOOessentials\Source\Resolver\HasQueryMode;
use ZOOlanders\YOOessentials\Source\Resolver\Orders\InMemoryOrders;
use ZOOlanders\YOOessentials\Source\Resolver\QueryMode;
use ZOOlanders\YOOessentials\Source\Resolver\SourceResolver;
use ZOOlanders\YOOessentials\Source\SourceService;
use ZOOlanders\YOOessentials\Util\Arr;

class RssResolver extends AbstractResolver
{
    use HasQueryMode;

    /** @var InMemoryFilters */
    protected $filters;

    public function fromArgs(array $args, $root): SourceResolver
    {
        return $this
            ->offset($args['offset'] ?? self::DEFAULT_OFFSET)
            ->limit($args['limit'] ?? self::DEFAULT_LIMIT)
            ->mode($args['mode'] ?? QueryMode::MODE_AND)
            ->orders($args['ordering'] ?? [], $root)
            ->filters($args['filters'] ?? [], $root);
    }

    protected function makeFilters(array $filters): InMemoryFilters
    {
        return new InMemoryFilters($filters, $this->mode);
    }

    protected function makeOrders(array $orders): InMemoryOrders
    {
        return new InMemoryOrders($orders);
    }

    public function resolve(): array
    {
        /** @var RssFeedItem[] $items */
        $items = $this->source()->rss()->items();

        if ($this->hasFilters()) {
            $items = Arr::filter($items, function (array $record) {
                return $this->filters->apply($record);
            });
        }

        if ($this->hasOrders()) {
            usort($items, function (array $recordA, array $recordB) {
                return $this->orders->apply($recordA, $recordB);
            });
        }

        $records = [];
        foreach ($items as $row) {
            $data = [];
            foreach ($row as $key => $value) {
                $data[SourceService::encodeField($key)] = $value;
            }
            $records[] = $data;
        }

        return array_slice($records, $this->offset, $this->limit);
    }
}
