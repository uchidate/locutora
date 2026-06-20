<?php

namespace ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\AwsError;

use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\UnexpectedValue;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\UnparsableResponse;
/**
 * @internal
 */
class JsonRestAwsErrorFactory implements \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\AwsError\AwsErrorFactoryInterface
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
        $type = $body['type'] ?? $body['Type'] ?? null;
        if ($type) {
            $type = \strtolower($type);
        }
        $message = $body['message'] ?? $body['Message'] ?? null;
        if (isset($headers['x-amzn-errortype'][0])) {
            $code = \explode(':', $headers['x-amzn-errortype'][0], 2)[0];
        }
        if (null !== $code) {
            return new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\AwsError\AwsError($code, $message, $type, null);
        }
        throw new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\UnexpectedValue('JSON does not contains AWS Error');
    }
}
