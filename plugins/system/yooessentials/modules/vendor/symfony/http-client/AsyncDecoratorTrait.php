<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient;

use ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Response\AsyncResponse;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Response\ResponseStream;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\ResponseInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\ResponseStreamInterface;
/**
 * Eases with processing responses while streaming them.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
trait AsyncDecoratorTrait
{
    use DecoratorTrait;
    /**
     * {@inheritdoc}
     *
     * @return AsyncResponse
     */
    public abstract function request(string $method, string $url, array $options = []) : \ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\ResponseInterface;
    /**
     * {@inheritdoc}
     */
    public function stream($responses, float $timeout = null) : \ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\ResponseStreamInterface
    {
        if ($responses instanceof \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Response\AsyncResponse) {
            $responses = [$responses];
        } elseif (!\is_iterable($responses)) {
            throw new \TypeError(\sprintf('"%s()" expects parameter 1 to be an iterable of AsyncResponse objects, "%s" given.', __METHOD__, \get_debug_type($responses)));
        }
        return new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Response\ResponseStream(\ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Response\AsyncResponse::stream($responses, $timeout, static::class));
    }
}
