<?php

namespace ZOOlanders\YOOessentials\Vendor\GuzzleHttp\Promise;

final class Is
{
    /**
     * Returns true if a promise is pending.
     *
     * @return bool
     */
    public static function pending(\ZOOlanders\YOOessentials\Vendor\GuzzleHttp\Promise\PromiseInterface $promise)
    {
        return $promise->getState() === \ZOOlanders\YOOessentials\Vendor\GuzzleHttp\Promise\PromiseInterface::PENDING;
    }
    /**
     * Returns true if a promise is fulfilled or rejected.
     *
     * @return bool
     */
    public static function settled(\ZOOlanders\YOOessentials\Vendor\GuzzleHttp\Promise\PromiseInterface $promise)
    {
        return $promise->getState() !== \ZOOlanders\YOOessentials\Vendor\GuzzleHttp\Promise\PromiseInterface::PENDING;
    }
    /**
     * Returns true if a promise is fulfilled.
     *
     * @return bool
     */
    public static function fulfilled(\ZOOlanders\YOOessentials\Vendor\GuzzleHttp\Promise\PromiseInterface $promise)
    {
        return $promise->getState() === \ZOOlanders\YOOessentials\Vendor\GuzzleHttp\Promise\PromiseInterface::FULFILLED;
    }
    /**
     * Returns true if a promise is rejected.
     *
     * @return bool
     */
    public static function rejected(\ZOOlanders\YOOessentials\Vendor\GuzzleHttp\Promise\PromiseInterface $promise)
    {
        return $promise->getState() === \ZOOlanders\YOOessentials\Vendor\GuzzleHttp\Promise\PromiseInterface::REJECTED;
    }
}
