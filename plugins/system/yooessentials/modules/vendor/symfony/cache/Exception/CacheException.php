<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZOOlanders\YOOessentials\Vendor\Symfony\Component\Cache\Exception;

use ZOOlanders\YOOessentials\Vendor\Psr\Cache\CacheException as Psr6CacheInterface;
use ZOOlanders\YOOessentials\Vendor\Psr\SimpleCache\CacheException as SimpleCacheInterface;
if (\interface_exists(\ZOOlanders\YOOessentials\Vendor\Psr\SimpleCache\CacheException::class)) {
    class CacheException extends \Exception implements \ZOOlanders\YOOessentials\Vendor\Psr\Cache\CacheException, \ZOOlanders\YOOessentials\Vendor\Psr\SimpleCache\CacheException
    {
    }
} else {
    class CacheException extends \Exception implements \ZOOlanders\YOOessentials\Vendor\Psr\Cache\CacheException
    {
    }
}
