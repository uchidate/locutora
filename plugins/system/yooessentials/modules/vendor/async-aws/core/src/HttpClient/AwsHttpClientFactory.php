<?php

namespace ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\HttpClient;

use ZOOlanders\YOOessentials\Vendor\Psr\Log\LoggerInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\HttpClient;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\RetryableHttpClient;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\HttpClientInterface;
/**
 * @author Jérémy Derussé <jeremy@derusse.com>
 */
class AwsHttpClientFactory
{
    public static function createRetryableClient(\ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\HttpClientInterface $httpClient = null, \ZOOlanders\YOOessentials\Vendor\Psr\Log\LoggerInterface $logger = null) : \ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\HttpClientInterface
    {
        if (null === $httpClient) {
            $httpClient = \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\HttpClient::create();
        }
        if (\class_exists(\ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\RetryableHttpClient::class)) {
            /** @psalm-suppress MissingDependency */
            $httpClient = new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\RetryableHttpClient($httpClient, new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\HttpClient\AwsRetryStrategy(), 3, $logger);
        }
        return $httpClient;
    }
}
