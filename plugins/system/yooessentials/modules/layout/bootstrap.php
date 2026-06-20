<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Layout;

use ZOOlanders\YOOessentials\Layout\Library\LayoutLibraryController;

return [

    'routes' => [

        ['post', LayoutController::PRESAVE_ENDPOINT, LayoutController::class . '@presave'],
        ['post', LayoutLibraryController::LAYOUT_LIBRARY_INDEX_ENDPOINT, LayoutLibraryController::class . '@getLibraryIndex'],
        ['post', LayoutLibraryController::LAYOUT_LIBRARY_NODE_GET_ENDPOINT, LayoutLibraryController::class . '@getNode'],
        ['post', LayoutLibraryController::LAYOUT_LIBRARY_NODE_SAVE_ENDPOINT, LayoutLibraryController::class . '@saveNode'],
        ['post', LayoutLibraryController::LAYOUT_LIBRARY_NODE_DELETE_ENDPOINT, LayoutLibraryController::class . '@deleteNodes'],

    ],

    'events' => [

        'customizer.init' => [
            CustomizerListener::class => ['initCustomizer', -10],
        ],

        'theme.init' => [
            CustomizerListener::class => ['initLibraries', -10],
        ],

    ],

    'loaders' => [
        'yooessentials-layout-libraries' => new LayoutLoader(),
    ],

    'yooessentials-layout-libraries' => [

    ],

    'services' => [
        LayoutManager::class => ''
    ]

];
