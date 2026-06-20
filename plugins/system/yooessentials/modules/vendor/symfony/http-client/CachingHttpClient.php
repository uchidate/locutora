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

use ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Response\MockResponse;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Response\ResponseStream;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpFoundation\Request;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpKernel\HttpCache\HttpCache;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpKernel\HttpCache\StoreInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpKernel\HttpClientKernel;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\HttpClientInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\ResponseInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\ResponseStreamInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\Service\ResetInterface;
/**
 * Adds caching on top of an HTTP client.
 *
 * The implementation buffers responses in memory and doesn't stream directly from the network.
 * You can disable/enable this layer by setting option "no_cache" under "extra" to true/false.
 * By default, caching is enabled unless the "buffer" option is set to false.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
class CachingHttpClient implements \ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\HttpClientInterface, \ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\Service\ResetInterface
{
    use HttpClientTrait;
    private $client;
    private $cache;
    private $defaultOptions = self::OPTIONS_DEFAULTS;
    public function __construct(\ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\HttpClientInterface $client, \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpKernel\HttpCache\StoreInterface $store, array $defaultOptions = [])
    {
        if (!\class_exists(\ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpKernel\HttpClientKernel::class)) {
            throw new \LogicException(\sprintf('Using "%s" requires that the HttpKernel component version 4.3 or higher is installed, try running "composer require symfony/http-kernel:^5.4".', __CLASS__));
        }
        $this->client = $client;
        $kernel = new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpKernel\HttpClientKernel($client);
        $this->cache = new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpKernel\HttpCache\HttpCache($kernel, $store, null, $defaultOptions);
        unset($defaultOptions['debug']);
        unset($defaultOptions['default_ttl']);
        unset($defaultOptions['private_headers']);
        unset($defaultOptions['allow_reload']);
        unset($defaultOptions['allow_revalidate']);
        unset($defaultOptions['stale_while_revalidate']);
        unset($defaultOptions['stale_if_error']);
        unset($defaultOptions['trace_level']);
        unset($defaultOptions['trace_header']);
        if ($defaultOptions) {
            [, $this->defaultOptions] = self::prepareRequest(null, null, $defaultOptions, $this->defaultOptions);
        }
    }
    /**
     * {@inheritdoc}
     */
    public function request(string $method, string $url, array $options = []) : \ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\ResponseInterface
    {
        [$url, $options] = $this->prepareRequest($method, $url, $options, $this->defaultOptions, \true);
        $url = \implode('', $url);
        if (!empty($options['body']) || !empty($options['extra']['no_cache']) || !\in_array($method, ['GET', 'HEAD', 'OPTIONS'])) {
            return $this->client->request($method, $url, $options);
        }
        $request = \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpFoundation\Request::create($url, $method);
        $request->attributes->set('http_client_options', $options);
        foreach ($options['normalized_headers'] as $name => $values) {
            if ('cookie' !== $name) {
                foreach ($values as $value) {
                    $request->headers->set($name, \substr($value, 2 + \strlen($name)), \false);
                }
                continue;
            }
            foreach ($values as $cookies) {
                foreach (\explode('; ', \substr($cookies, \strlen('Cookie: '))) as $cookie) {
                    if ('' !== $cookie) {
                        $cookie = \explode('=', $cookie, 2);
                        $request->cookies->set($cookie[0], $cookie[1] ?? '');
                    }
                }
            }
        }
        $response = $this->cache->handle($request);
        $response = new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Response\MockResponse($response->getContent(), ['http_code' => $response->getStatusCode(), 'response_headers' => $response->headers->allPreserveCase()]);
        return \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Response\MockResponse::fromRequest($method, $url, $options, $response);
    }
    /**
     * {@inheritdoc}
     */
    public function stream($responses, float $timeout = null) : \ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\ResponseStreamInterface
    {
        if ($responses instanceof \ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\ResponseInterface) {
            $responses = [$responses];
        } elseif (!\is_iterable($responses)) {
            throw new \TypeError(\sprintf('"%s()" expects parameter 1 to be an iterable of ResponseInterface objects, "%s" given.', __METHOD__, \get_debug_type($responses)));
        }
        $mockResponses = [];
        $clientResponses = [];
        foreach ($responses as $response) {
            if ($response instanceof \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Response\MockResponse) {
                $mockResponses[] = $response;
            } else {
                $clientResponses[] = $response;
            }
        }
        if (!$mockResponses) {
            return $this->client->stream($clientResponses, $timeout);
        }
        if (!$clientResponses) {
            return new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Response\ResponseStream(\ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Response\MockResponse::stream($mockResponses, $timeout));
        }
        return new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Response\ResponseStream((function () use($mockResponses, $clientResponses, $timeout) {
            yield from \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Response\MockResponse::stream($mockResponses, $timeout);
            (yield $this->client->stream($clientResponses, $timeout));
        })());
    }
    public function reset()
    {
        if ($this->client instanceof \ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\Service\ResetInterface) {
            $this->client->reset();
        }
    }
}
