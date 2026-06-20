<?php

namespace ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\AwsError;

use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\UnparsableResponse;
/**
 * @internal
 */
class ChainAwsErrorFactory implements \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\AwsError\AwsErrorFactoryInterface
{
    use AwsErrorFactoryFromResponseTrait;
    private $factories;
    /**
     * @param AwsErrorFactoryInterface[]|null $factories
     */
    public function __construct(array $factories = null)
    {
        $this->factories = $factories ?? [new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\AwsError\JsonRestAwsErrorFactory(), new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\AwsError\JsonRpcAwsErrorFactory(), new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\AwsError\XmlAwsErrorFactory()];
    }
    public function createFromContent(string $content, array $headers) : \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\AwsError\AwsError
    {
        $e = null;
        foreach ($this->factories as $factory) {
            try {
                return $factory->createFromContent($content, $headers);
            } catch (\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\UnparsableResponse $e) {
            }
        }
        throw new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\UnparsableResponse('Failed to parse AWS error: ' . $content, 0, $e);
    }
}
