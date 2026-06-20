<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Source\Resolver\Orders;

use YOOtheme\Event;
use ZOOlanders\YOOessentials\Util\Arr;

abstract class Orders
{
    /**
     * @var Order[]
     */
    protected $orders;

    public function __construct(array $orders)
    {
        $this->orders = Arr::map(Arr::filter($orders), function (array $order) {
            return $this->createOrder($order);
        });
    }

    public function enabled(): array
    {
        return Arr::filter($this->orders, function (Order $order) {
            try {
                $order->validate();
            } catch (InvalidOrderException $e) {
                Event::emit('yooessentials.info', [
                    'group' => 'YOOessentials Invalid Order - Disabled',
                    'addon' => 'source',
                    'error' => $e->getMessage(),
                ]);

                return false;
            }

            return $order->enabled();
        });
    }

    /**
     * @param array $order
     * @return Order
     */
    protected function createOrder(array $order)
    {
        return new InMemoryOrder($order);
    }
}
