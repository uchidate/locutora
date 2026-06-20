<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Source\Resolver;

use ZOOlanders\YOOessentials\Source\Resolver\Filters\Filters;
use ZOOlanders\YOOessentials\Source\Resolver\Orders\Orders;
use ZOOlanders\YOOessentials\Util\Arr;

trait HasFilterAndOrderConditions
{
    use HasDynamicArgs;

    /** @var Filters|null */
    protected $filters = null;

    /** @var Orders|null */
    protected $orders = [];

    /**
     * @param array $filters
     * @return Filters
     */
    abstract protected function makeFilters(array $filters);

    /**
     * @param array $orders
     * @return Orders
     */
    abstract protected function makeOrders(array $orders);

    public function filters(array $filters, $root): self
    {
        $this->filters = $this->makeFilters(
            $this->resolveFiltersOrOrders(Arr::filter($filters), $root)
        );

        return $this;
    }

    public function orders(array $orders, $root): self
    {
        $this->orders = $this->makeOrders(
            $this->resolveFiltersOrOrders(Arr::filter($orders), $root)
        );

        return $this;
    }

    public function resolveFiltersOrOrders(array $args, $root): array
    {
        return Arr::map($args, function ($arg) use ($root) {
            return self::resolveDynamicArguments($arg, $root);
        });
    }

    public function hasFilters(): bool
    {
        return $this->filters !== null && count($this->filters->enabled()) > 0;
    }

    public function hasOrders(): bool
    {
        return $this->orders !== null && count($this->orders->enabled()) > 0;
    }
}
