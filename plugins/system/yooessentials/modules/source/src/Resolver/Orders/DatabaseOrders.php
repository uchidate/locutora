<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Source\Resolver\Orders;

use ZOOlanders\YOOessentials\DatabaseQuery;
use ZOOlanders\YOOessentials\Sources\Database\DatabaseSource;

class DatabaseOrders extends Orders
{
    /**
     * @var DatabaseSource
     */
    private $source;

    public function __construct(array $orders, DatabaseSource $source)
    {
        $this->source = $source;

        parent::__construct($orders);
    }

    protected function createOrder(array $order): DatabaseOrder
    {
        return new DatabaseOrder($order, $this->source);
    }

    public function apply(DatabaseQuery $query): DatabaseQuery
    {
        foreach ($this->orders as $order) {
            $query = $order->apply($query);
        }

        return $query;
    }
}
