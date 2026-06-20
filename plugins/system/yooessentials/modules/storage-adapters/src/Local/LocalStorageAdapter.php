<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Storage\Adapter\Local;

use YOOtheme\File;
use YOOtheme\Path;
use ZOOlanders\YOOessentials\Storage\StorageAdapter;
use ZOOlanders\YOOessentials\Storage\StorageConfigurationInvalidException;
use ZOOlanders\YOOessentials\Vendor\League\Flysystem\FilesystemAdapter;
use ZOOlanders\YOOessentials\Vendor\League\Flysystem\Local\LocalFilesystemAdapter;

class LocalStorageAdapter extends StorageAdapter
{
    public function adapter(array $config = []): FilesystemAdapter
    {
        $path = $config['root'] ?? '';

        if (Path::isRelative($path)) {
            $path = Path::resolve('~/' . $path);
        }

        return new LocalFilesystemAdapter($path);
    }

    public function validateConfig(array $config): void
    {
        $root = $config['root'] ?? null;

        if (Path::isRelative($root)) {
            $root = "~/$root";
        }

        $root = Path::resolve($root);

        if (!$root) {
            throw new StorageConfigurationInvalidException('Root path is required.');
        }

        if (!File::exists($root) || !is_writable($root)) {
            throw new StorageConfigurationInvalidException('Root path dose not exist or is not writable.');
        }
    }
}
