<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Storage;

use YOOtheme\Config as Yooconfig;
use YOOtheme\Metadata;
use YOOtheme\Path;
use ZOOlanders\YOOessentials\Config;

class CustomizerListener
{
    public static function initStorages(Config $config, StorageService $storageService)
    {
        $storages = $config->get(StorageService::STORAGES_CONFIG_KEY, []);
        $storageService->setConfigs($storages);
    }

    public static function initCustomizer(Metadata $metadata, Yooconfig $yooconfig, StorageAdapterManager $storages)
    {
        $adapters = [];
        foreach ($storages->adapters() as $class) {
            $config = $class->metadata();
            $adapters[$config->name] = (array) $config;
        }

        $yooconfig->set('customizer.yooessentials.storage_adapters', $adapters);
        $yooconfig->addFile('customizer', Path::get('../config/customizer.json'));

        $metadata->set('script:yooessentials-customizer-storage', ['src' => '~yooessentials_url/modules/storage/assets/customizer.min.js',
            'defer' => true
        ]);
    }
}
