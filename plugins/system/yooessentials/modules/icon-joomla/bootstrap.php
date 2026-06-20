<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Icon\Joomla;

use YOOtheme\Builder;
use YOOtheme\Path;
use ZOOlanders\YOOessentials\Icon\IconLoader;

return [

    'actions' => [

        'onAfterRender' => [
            IconListener::class => ['loadIcons', -10]
        ],

        'onContentPrepare' => [
            IconListener::class => ['loadIcons', -10]
        ],

        'onRenderModule' => [
            IconListener::class => ['loadIcons', -10]
        ],
    ],

    'extend' => [

        Builder::class => function (Builder $builder, $app) {
            $builder->addTransform('presave', new IconCacheTransform());
        }

    ],

    'services' => [

        IconCacheHelper::class => '',

        IconLoader::class => [
            'arguments' => ['$location' => function () {
                return Path::get('~/media/yooessentials/icons');
            }],
        ],

    ]

];
