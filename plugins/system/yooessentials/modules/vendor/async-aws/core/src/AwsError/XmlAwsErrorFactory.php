<?php

namespace ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\AwsError;

use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\RuntimeException;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\UnexpectedValue;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\UnparsableResponse;
/**
 * @internal
 */
class XmlAwsErrorFactory implements \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\AwsError\AwsErrorFactoryInterface
{
    use AwsErrorFactoryFromResponseTrait;
    public function createFromContent(string $content, array $headers) : \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\AwsError\AwsError
    {
        try {
            /**
             * @phpstan-ignore-next-line
             * @psalm-suppress InvalidArgument
             */
            \set_error_handler(static function ($errno, $errstr) {
                throw new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\RuntimeException($errstr, $errno);
            });
            try {
                $xml = new \SimpleXMLElement($content);
            } finally {
                \restore_error_handler();
            }
            return self::parseXml($xml);
        } catch (\Throwable $e) {
            throw new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\UnparsableResponse('Failed to parse AWS error: ' . $content, 0, $e);
        }
    }
    private static function parseXml(\SimpleXMLElement $xml) : \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\AwsError\AwsError
    {
        if (0 < $xml->Error->count()) {
            return new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\AwsError\AwsError($xml->Error->Code->__toString(), $xml->Error->Message->__toString(), $xml->Error->Type->__toString(), $xml->Error->Detail->__toString());
        }
        if (1 === $xml->Code->count() && 1 === $xml->Message->count()) {
            return new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\AwsError\AwsError($xml->Code->__toString(), $xml->Message->__toString(), null, null);
        }
        throw new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\UnexpectedValue('XML does not contains AWS Error');
    }
}
