<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Icon;

use YOOtheme\Builder;
use YOOtheme\Path;

return [

    'events' => [

        'customizer.init' => [
            IconListener::class => ['initCustomizer', -10]
        ],

        'theme.init' => [
            IconListener::class => ['initTheme', -10]
        ],

    ],

    'routes' => [
        ['post', '/yooessentials/icon/list', IconController::class . '@getIcons'],
        ['post', '/yooessentials/icon/collection/add', IconController::class . '@addCollection'],
        ['post', '/yooessentials/icon/collection/remove', IconController::class . '@removeCollection']
    ],

    'extend' => [

        Builder::class => function (Builder $builder, $app) {
            $builder->addTransform('prerender', new IconTransform);
        },

        IconLoader::class => function (IconLoader $loader, $app) {
            $loader->addCollectionPath(Path::get('~yooessentials/modules/icon/collections/*/*.json'));
        },

    ],

    'services' => [

        IconService::class => '',

        IconApi::class => '',

    ]

];
