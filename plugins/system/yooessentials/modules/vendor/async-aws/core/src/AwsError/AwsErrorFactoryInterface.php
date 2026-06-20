<?php

namespace ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\AwsError;

use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\ResponseInterface;
/**
 * @internal
 */
interface AwsErrorFactoryInterface
{
    public function createFromResponse(\ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\ResponseInterface $response) : \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\AwsError\AwsError;
    public function createFromContent(string $content, array $headers) : \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\AwsError\AwsError;
}
