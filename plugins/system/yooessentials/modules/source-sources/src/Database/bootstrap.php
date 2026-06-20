<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Database;

use YOOtheme\Builder;
use ZOOlanders\YOOessentials\Source\QueryArgsTransform;

return [

    'routes' => [
        ['post', DatabaseController::TABLES_URL, DatabaseController::class . '@tables'],
        ['post', DatabaseController::FIELDS_URL, DatabaseController::class . '@fields'],
        ['post', DatabaseController::RECORDS_URL, DatabaseController::class . '@records'],
        ['post', DatabaseController::FILTER_FIELDS_URL, DatabaseController::class . '@filterFields'],
        ['post', DatabaseController::PRESAVE_ENDPOINT, DatabaseController::class . '@presave'],
    ],

    'yooessentials-sources' => [

        'database' => DatabaseSource::class,

    ],

    'extend' => [

        Builder::class => function (Builder $builder, $app) {
            $transform = new QueryArgsTransform('databaseRecord');
            $builder->addTransform('prerender', $transform, 2);
        },

    ]

];
