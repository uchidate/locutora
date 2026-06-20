<?php

namespace ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\HttpClient;

use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\AwsError\AwsErrorFactoryInterface;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\AwsError\ChainAwsErrorFactory;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\UnparsableResponse;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Response\AsyncContext;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Retry\GenericRetryStrategy;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
/**
 * @author Jérémy Derussé <jeremy@derusse.com>
 */
class AwsRetryStrategy extends \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Retry\GenericRetryStrategy
{
    public const DEFAULT_RETRY_STATUS_CODES = [0, 423, 425, 429, 500, 502, 503, 504, 507, 510];
    private $awsErrorFactory;
    // Override Symfony default options for a better integration of AWS servers.
    public function __construct(array $statusCodes = self::DEFAULT_RETRY_STATUS_CODES, int $delayMs = 1000, float $multiplier = 2.0, int $maxDelayMs = 0, float $jitter = 0.1, \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\AwsError\AwsErrorFactoryInterface $awsErrorFactory = null)
    {
        parent::__construct($statusCodes, $delayMs, $multiplier, $maxDelayMs, $jitter);
        $this->awsErrorFactory = $awsErrorFactory ?? new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\AwsError\ChainAwsErrorFactory();
    }
    public function shouldRetry(\ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Response\AsyncContext $context, ?string $responseContent, ?\ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface $exception) : ?bool
    {
        if (parent::shouldRetry($context, $responseContent, $exception)) {
            return \true;
        }
        if (!\in_array($context->getStatusCode(), [400, 403], \true)) {
            return \false;
        }
        if (null === $responseContent) {
            return null;
            // null mean no decision taken and need to be called again with the body
        }
        try {
            $error = $this->awsErrorFactory->createFromContent($responseContent, $context->getHeaders());
        } catch (\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\UnparsableResponse $e) {
            return \false;
        }
        return \in_array($error->getCode(), ['RequestLimitExceeded', 'Throttling', 'ThrottlingException', 'ThrottledException', 'LimitExceededException', 'PriorRequestNotComplete', 'ProvisionedThroughputExceededException', 'RequestThrottled', 'SlowDown', 'BandwidthLimitExceeded', 'RequestThrottledException', 'RetryableThrottlingException', 'TooManyRequestsException', 'IDPCommunicationError', 'EC2ThrottledException', 'TransactionInProgressException'], \true);
    }
}
