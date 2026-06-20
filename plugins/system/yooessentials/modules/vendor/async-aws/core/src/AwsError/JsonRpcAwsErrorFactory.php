<?php

namespace ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\AwsError;

use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\UnexpectedValue;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\UnparsableResponse;
/**
 * @internal
 */
class JsonRpcAwsErrorFactory implements \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\AwsError\AwsErrorFactoryInterface
{
    use AwsErrorFactoryFromResponseTrait;
    public function createFromContent(string $content, array $headers) : \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\AwsError\AwsError
    {
        try {
            $body = \json_decode($content, \true);
            return self::parseJson($body, $headers);
        } catch (\Throwable $e) {
            throw new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\UnparsableResponse('Failed to parse AWS error: ' . $content, 0, $e);
        }
    }
    private static function parseJson(array $body, array $headers) : \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\AwsError\AwsError
    {
        $code = null;
        $message = $body['message'] ?? $body['Message'] ?? null;
        if (isset($body['__type'])) {
            $parts = \explode('#', $body['__type'], 2);
            $code = $parts[1] ?? $parts[0];
        }
        if (null !== $code || null !== $message) {
            return new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\AwsError\AwsError($code, $message, null, null);
        }
        throw new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\UnexpectedValue('JSON does not contains AWS Error');
    }
}
