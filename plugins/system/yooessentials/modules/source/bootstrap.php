<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Source;

use YOOtheme\Builder\Source\SourceTransform as YooSourceTransform;

return [

    'routes' => [

        ['post', SourceController::REBUILD_SCHEMA_URL, SourceController::class . '@rebuildSchema'],

    ],

    'events' => [

        'source.init' => [
            SourceListener::class => ['initSources', 60],
        ],

        'customizer.init' => [
            SourceListener::class => ['initCustomizer', -10],
        ],

    ],

    'loaders' => [
        'yooessentials-sources' => new SourceLoader,
    ],

    'extend' => [

        YooSourceTransform::class => function (YooSourceTransform $transform) {
            $transform->addFilter('time', function ($value, $format) use ($transform) {
                return $transform->applyDate($value, $format ?: 'H:i');
            }, -10);

            $transform->addFilter('datemodify', function ($value, $modifier) {
                if (!$value || !strtotime($modifier)) {
                    return $value;
                }

                if (is_string($value) && !is_numeric($value)) {
                    $value = strtotime($value);
                }

                $date = (new \DateTime());
                $date->setTimestamp($value);
                $date->modify($modifier);

                return $date->getTimestamp();
            }, -10);
        },

    ],

    'services' => [
        SourceService::class => ''
    ],

    'yooessentials-bootstrap' => [
        __DIR__ . '/../source-sources/bootstrap.php'
    ],

];
