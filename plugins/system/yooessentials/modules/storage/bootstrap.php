<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Storage;

return [

    'routes' => [
        ['post', StorageAdapterController::PRESAVE_ENDPOINT, StorageAdapterController::class . '@presave'],
    ],

    'events' => [

        'customizer.init' => [
            CustomizerListener::class => ['initCustomizer', -10],
        ],

        'theme.init' => [
            CustomizerListener::class => ['initStorages', -10],
        ],

    ],

    'loaders' => [
        'yooessentials-storages' => new StorageAdapterLoader(),
    ],

    'services' => [
        StorageService::class => '',
    ],

    'yooessentials-bootstrap' => [
        __DIR__ . '/../storage-adapters/bootstrap.php'
    ],

];
