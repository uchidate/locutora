<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Layout;

use ZOOlanders\YOOessentials\Storage\StorageService;

class LayoutManager
{
    public const LIBRARIES_CONFIG_KEY = 'layout.libraries';

    /** @var array|Library\LayoutLibrary[] */
    protected $libraries = [];

    /** @var StorageService */
    protected $storages;

    public function __construct(StorageService $storageService)
    {
        $this->storages = $storageService;
    }

    public function setLibraries(array $libraries): self
    {
        $libraries = array_filter(array_map(function (array $data) {
            $library = new Library\LayoutLibrary($data);

            $storageId = $data['storage'] ?? null;
            if (!$storageId) {
                return $library;
            }

            $storage = $this->storages->storage($storageId);
            if (!$storage) {
                return null;
            }

            return $library->onStorage($storage);
        }, $libraries));

        $this->libraries = array_column($libraries, null, 'id');

        return $this;
    }

    public function library(string $id): ?Library\LayoutLibrary
    {
        return $this->libraries[$id] ?? null;
    }

    public function libraries(?string $storageId = null): array
    {
        if ($storageId === null) {
            return $this->libraries;
        }

        return array_filter($this->libraries, function (Library\LayoutLibrary $library) use ($storageId) {
            return $library->storage() && $library->storage()->id() === $storageId;
        });
    }
}
