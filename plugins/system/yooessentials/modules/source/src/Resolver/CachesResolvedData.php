<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Source\Resolver;

use function YOOtheme\app;
use YOOtheme\Event;
use ZOOlanders\YOOessentials\Source\Type\SourceInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\Cache\Adapter\FilesystemAdapter;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\Cache\CacheInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\Cache\ItemInterface;

trait CachesResolvedData
{
    abstract public static function getCacheKey(): string;

    /**
     * This may be called with
     * resolveCache($source, $args, function()
     * resolveCache($source, $args, $root, function())
     *
     * The first is kept for backwards compatibility
     *
     * @param SourceInterface $source
     * @param array $args
     * @param \Closure $callback
     * @return array|null|mixed
     * @throws \ZOOlanders\YOOessentials\Vendor\Psr\Cache\InvalidArgumentException
     */
    public static function resolveFromCache(SourceInterface $source, array $args, $root, $callback = null)
    {
        // Root may or may not be passed.
        if ($callback === null) {
            $callback = $root;
            $root = [];
        }

        // Pre-resolve the arguments so they get cached correcly
        $args = static::resolveArgs($args, $root);
        $cacheKey = self::getCacheKey() . sha1(json_encode($args + $source->config()));

        /** @var FilesystemAdapter $cache */
        $cache = app(CacheInterface::class);

        $records = $cache->get($cacheKey, function (ItemInterface $item) use ($source, $callback, $args) {
            $item->expiresAfter(self::getCachetime($args));

            try {
                return $callback();
            } catch (\Exception $e) {
                Event::emit('yooessentials.error', [
                    'addon' => 'source',
                    'source' => "{$source->name()} ({$source->metadata()->name})",
                    'action' => 'source-query-resolve',
                    'args' => $args,
                    'error' => $e->getMessage(),
                    'exception' => $e,
                    'trace' => json_encode($e->getTrace() ?? [])
                ]);
            }

            return [];
        });

        // avoid caching empty list
        if (!$records || empty($records)) {
            $cache->delete($cacheKey);
        }

        return $records;
    }

    protected static function getCacheTime(array $args): int
    {
        $min = defined('static::MIN_CACHE_TIME') ? static::MIN_CACHE_TIME : null;
        $default = defined('static::DEFAULT_CACHE_TIME') ? static::DEFAULT_CACHE_TIME : 3600;

        $cache = $args['cache'] ?? $default;

        if ($min !== null && $cache < $min) {
            $cache = $min;
        }

        return $cache;
    }

    /**
     * Override this method if the args contains dynamic properties (ie: sources)
     */
    protected static function resolveArgs(array $args, $root): array
    {
        return $args;
    }
}
