<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form;

use YOOtheme\File;
use YOOtheme\Path;

class FormConfigCache
{
    /**
     * @var string
     */
    protected $prefix;

    /**
     * @var string
     */
    protected $cache;

    /**
     * Constructor.
     *
     * @param string $prefix
     */
    public function __construct(string $prefix)
    {
        $this->prefix = $prefix;
        $this->cache = Path::resolve('~theme/cache/yooessentials');

        File::makeDir($this->cache, 0777, true);
    }

    public function getPrefix(): string
    {
        return $this->prefix;
    }

    /**
     * Return the cache path
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->cache;
    }

    /**
     * Returns the cached asset path
     *
     * @param string $name
     *
     * @return string|null
     */
    public function get(string $name): ?string
    {
        $file = $this->resolve($name);

        if (File::exists($file)) {
            return File::getContents($file);
        }

        return null;
    }

    /**
     * Saves the asset in the resolved cache ubication
     *
     * @param string $name
     * @param mixed $data
     *
     * @return int|null
     */
    public function set(string $name, $data): ?int
    {
        return File::putContents($this->resolve($name), $data);
    }

    /**
     * Checks whether asset is cached
     *
     * @param string $name
     *
     * @return bool
     */
    public function exists(string $name): bool
    {
        return File::exists($this->resolve($name));
    }

    /**
     * Gets the inode change time of asset
     *
     * @param string $name
     *
     * @return int|null
     */
    public function getCTime(string $name): ?int
    {
        return File::getCTime($this->resolve($name));
    }

    /**
     * Resolves path to cache asset
     *
     * @param string $name
     *
     * @return string
     */
    public function resolve(string $name): string
    {
        return Path::resolve($this->cache, "$this->prefix-$name");
    }

    /**
     * Clear che cache for a given key
     *
     * @param string $name
     * @return bool
     */
    public function clear(string $name): bool
    {
        if (!$this->exists($name)) {
            return true;
        }

        return File::delete($this->resolve($name));
    }
}
