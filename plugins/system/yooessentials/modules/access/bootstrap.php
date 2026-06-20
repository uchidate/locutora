<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Access;

use YOOtheme\Builder;
use ZOOlanders\YOOessentials\UpdateTransform;

return [

    'events' => [

        'customizer.init' => [
            AccessListener::class => ['initCustomizer', -10]
        ],

        'builder.type' => [
            AccessListener::class => ['builderType', -10]
        ]

    ],

    'extend' => [

        Builder::class => function (Builder $builder, $app) {
            $builder->addTransform('render', $app(AccessTransform::class));
        },

        UpdateTransform::class => function (UpdateTransform $update) {
            $update->addGlobals(require __DIR__ . '/updates.php');
        },

    ],

    'services' => [

        Access::class => ''

    ],

    'loaders' => [
        'yooessentials-access-rules' => new RuleLoader(),
    ],

    'yooessentials-access-rules' => [
        Rule\TimeRule::class,
        Rule\DateRule::class,
        Rule\DatetimeRule::class,
        Rule\DayRule::class,
        Rule\WeekRule::class,
        Rule\MonthRule::class,
        Rule\SeasonRule::class,
        Rule\UrlRule::class,
        Rule\IpRule::class,
        Rule\IpGeolocationRule::class,
        Rule\DeviceRule::class,
        Rule\BrowserRule::class,
        Rule\OsRule::class,
        Rule\DynamicRule::class,
    ]

];
