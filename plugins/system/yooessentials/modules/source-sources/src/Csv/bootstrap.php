<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Csv;

use YOOtheme\Builder;
use ZOOlanders\YOOessentials\Source\QueryArgsTransform;

return [

    'routes' => [

        ['post', CsvController::PRESAVE_ENDPOINT, CsvController::class . '@presave'],

    ],

    'yooessentials-sources' => [

        'csv' => CsvSource::class

    ],

    'extend' => [

        Builder::class => function (Builder $builder, $app) {
            $transform = new QueryArgsTransform('fileCSV');
            $builder->addTransform('prerender', $transform, 2);
        },

    ]

];
