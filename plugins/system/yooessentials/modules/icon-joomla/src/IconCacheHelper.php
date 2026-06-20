<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Icon\Joomla;

use Joomla\CMS\Cache\Cache;
use Joomla\CMS\Cache\Controller\CallbackController;
use Joomla\CMS\Factory;
use ZOOlanders\YOOessentials\Icon\IconLoader;

class IconCacheHelper
{
    /**
     * @var Cache
     */
    protected $cache;

    public function __construct(IconLoader $loader)
    {
        /** @var CallbackController $cache */
        $this->cache = Factory::getCache('yooessentials', 'callback')->cache;
        $this->loader = $loader;
    }

    public function getCacheId(int $id): string
    {
        return 'yooessentials.icons.article.' . $id;
    }

    public function store(int $id): self
    {
        $cacheId = $this->getCacheId($id);

        $currentIcons = $this->cache->get($cacheId) ?: [];
        $icons = array_merge($currentIcons, $this->loader->queued());
        $this->cache->store($icons, $cacheId);

        return $this;
    }

    public function get(int $id): array
    {
        return $this->cache->get($id) ?: [];
    }
}
