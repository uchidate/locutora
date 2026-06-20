<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZOOlanders\YOOessentials\Vendor\Symfony\Component\Cache\Adapter;

use ZOOlanders\YOOessentials\Vendor\Symfony\Component\Cache\Marshaller\DefaultMarshaller;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\Cache\Marshaller\MarshallerInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\Cache\PruneableInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\Cache\Traits\FilesystemTrait;
class FilesystemAdapter extends \ZOOlanders\YOOessentials\Vendor\Symfony\Component\Cache\Adapter\AbstractAdapter implements \ZOOlanders\YOOessentials\Vendor\Symfony\Component\Cache\PruneableInterface
{
    use FilesystemTrait;
    public function __construct(string $namespace = '', int $defaultLifetime = 0, string $directory = null, \ZOOlanders\YOOessentials\Vendor\Symfony\Component\Cache\Marshaller\MarshallerInterface $marshaller = null)
    {
        $this->marshaller = $marshaller ?? new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\Cache\Marshaller\DefaultMarshaller();
        parent::__construct('', $defaultLifetime);
        $this->init($namespace, $directory);
    }
}
