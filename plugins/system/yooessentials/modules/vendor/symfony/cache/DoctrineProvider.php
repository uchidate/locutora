<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZOOlanders\YOOessentials\Vendor\Symfony\Component\Cache;

use ZOOlanders\YOOessentials\Vendor\Doctrine\Common\Cache\CacheProvider;
use ZOOlanders\YOOessentials\Vendor\Psr\Cache\CacheItemPoolInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\Service\ResetInterface;
if (!\class_exists(\ZOOlanders\YOOessentials\Vendor\Doctrine\Common\Cache\CacheProvider::class)) {
    return;
}
/**
 * @author Nicolas Grekas <p@tchwork.com>
 *
 * @deprecated Use Doctrine\Common\Cache\Psr6\DoctrineProvider instead
 */
class DoctrineProvider extends \ZOOlanders\YOOessentials\Vendor\Doctrine\Common\Cache\CacheProvider implements \ZOOlanders\YOOessentials\Vendor\Symfony\Component\Cache\PruneableInterface, \ZOOlanders\YOOessentials\Vendor\Symfony\Component\Cache\ResettableInterface
{
    private $pool;
    public function __construct(\ZOOlanders\YOOessentials\Vendor\Psr\Cache\CacheItemPoolInterface $pool)
    {
        trigger_deprecation('symfony/cache', '5.4', '"%s" is deprecated, use "Doctrine\\Common\\Cache\\Psr6\\DoctrineProvider" instead.', __CLASS__);
        $this->pool = $pool;
    }
    /**
     * {@inheritdoc}
     */
    public function prune()
    {
        return $this->pool instanceof \ZOOlanders\YOOessentials\Vendor\Symfony\Component\Cache\PruneableInterface && $this->pool->prune();
    }
    /**
     * {@inheritdoc}
     */
    public function reset()
    {
        if ($this->pool instanceof \ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\Service\ResetInterface) {
            $this->pool->reset();
        }
        $this->setNamespace($this->getNamespace());
    }
    /**
     * {@inheritdoc}
     *
     * @return mixed
     */
    protected function doFetch($id)
    {
        $item = $this->pool->getItem(\rawurlencode($id));
        return $item->isHit() ? $item->get() : \false;
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    protected function doContains($id)
    {
        return $this->pool->hasItem(\rawurlencode($id));
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    protected function doSave($id, $data, $lifeTime = 0)
    {
        $item = $this->pool->getItem(\rawurlencode($id));
        if (0 < $lifeTime) {
            $item->expiresAfter($lifeTime);
        }
        return $this->pool->save($item->set($data));
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    protected function doDelete($id)
    {
        return $this->pool->deleteItem(\rawurlencode($id));
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    protected function doFlush()
    {
        return $this->pool->clear();
    }
    /**
     * {@inheritdoc}
     *
     * @return array|null
     */
    protected function doGetStats()
    {
        return null;
    }
}
