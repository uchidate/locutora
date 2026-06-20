<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\DependencyInjection;

use ZOOlanders\YOOessentials\Vendor\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\DependencyInjection\ContainerBuilder;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\DependencyInjection\ContainerInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\DependencyInjection\Reference;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\TraceableHttpClient;
final class HttpClientPass implements \ZOOlanders\YOOessentials\Vendor\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    private $clientTag;
    public function __construct(string $clientTag = 'http_client.client')
    {
        if (0 < \func_num_args()) {
            trigger_deprecation('symfony/http-client', '5.3', 'Configuring "%s" is deprecated.', __CLASS__);
        }
        $this->clientTag = $clientTag;
    }
    /**
     * {@inheritdoc}
     */
    public function process(\ZOOlanders\YOOessentials\Vendor\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        if (!$container->hasDefinition('data_collector.http_client')) {
            return;
        }
        foreach ($container->findTaggedServiceIds($this->clientTag) as $id => $tags) {
            $container->register('.debug.' . $id, \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\TraceableHttpClient::class)->setArguments([new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\DependencyInjection\Reference('.debug.' . $id . '.inner'), new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\DependencyInjection\Reference('debug.stopwatch', \ZOOlanders\YOOessentials\Vendor\Symfony\Component\DependencyInjection\ContainerInterface::IGNORE_ON_INVALID_REFERENCE)])->addTag('kernel.reset', ['method' => 'reset'])->setDecoratedService($id);
            $container->getDefinition('data_collector.http_client')->addMethodCall('registerClient', [$id, new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\DependencyInjection\Reference('.debug.' . $id)]);
        }
    }
}
