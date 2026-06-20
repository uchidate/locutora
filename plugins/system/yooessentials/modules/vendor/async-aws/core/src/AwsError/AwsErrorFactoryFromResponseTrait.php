<?php

namespace ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\AwsError;

use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\ResponseInterface;
/**
 * @internal
 */
trait AwsErrorFactoryFromResponseTrait
{
    public function createFromResponse(\ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\ResponseInterface $response) : \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\AwsError\AwsError
    {
        $content = $response->getContent(\false);
        $headers = $response->getHeaders(\false);
        return $this->createFromContent($content, $headers);
    }
}
