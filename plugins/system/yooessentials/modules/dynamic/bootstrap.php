<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Dynamic;

use YOOtheme\Builder;
use YOOtheme\Builder\Source\SourceTransform as YooSourceTransform;

return [

    'routes' => [

        ['post', GlobalQueryController::PRESAVE_QUERY_ENDPOINT, GlobalQueryController::class . '@presave'],

    ],

    'events' => [

        'customizer.init' => [
            CustomizerListener::class => ['initCustomizer', -10],
        ],

        'builder.type' => [
            CustomizerListener::class => ['builderType', -10]
        ]

    ],

    'extend' => [

        Builder::class => function (Builder $builder, $app) {
            $resolver = $app(DynamicResolver::class);

            $builder->addTransform('preload', [$resolver, 'preload']);
            $builder->addTransform('prerender', [$resolver, 'prerender']);
        }

    ],

    'services' => [
        DynamicResolver::class => '',
        YooSourceTransform::class => SourceTransform::class,
    ],

];
