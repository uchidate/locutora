<?php

namespace ZOOlanders\YOOessentials\Vendor\AsyncAws\S3\Result;

use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\Http\HttpException;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\InvalidArgument;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Response;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Waiter;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\S3\Input\HeadObjectRequest;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\S3\S3Client;
class ObjectNotExistsWaiter extends \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Waiter
{
    protected const WAIT_TIMEOUT = 100.0;
    protected const WAIT_DELAY = 5.0;
    protected function extractState(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Response $response, ?\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\Http\HttpException $exception) : string
    {
        if (404 === $response->getStatusCode()) {
            return self::STATE_SUCCESS;
        }
        return null === $exception ? self::STATE_PENDING : self::STATE_FAILURE;
    }
    protected function refreshState() : \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Waiter
    {
        if (!$this->awsClient instanceof \ZOOlanders\YOOessentials\Vendor\AsyncAws\S3\S3Client) {
            throw new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\InvalidArgument('missing client injected in waiter result');
        }
        if (!$this->input instanceof \ZOOlanders\YOOessentials\Vendor\AsyncAws\S3\Input\HeadObjectRequest) {
            throw new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\InvalidArgument('missing last request injected in waiter result');
        }
        return $this->awsClient->objectNotExists($this->input);
    }
}
