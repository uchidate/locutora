<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

use YOOtheme\Str;

return [

    'nodes' => [

        '1.7.0-beta.4' => function ($node) {
            // convert source to source_extended custom prop query
            foreach ($node->props['yooessentials_access_conditions'] ?? [] as $condition) {
                if (!isset($condition->source->query)) {
                    continue;
                }

                $condition->source_extended = (object) ['props' => (object) []];

                foreach ($condition->source->props ?? [] as $name => $prop) {
                    $prop->query = $condition->source->query;
                    $condition->source_extended->props->{$name} = $prop;
                }

                unset($condition->source);
            }
        },

        '1.4.0' => function ($node) {
            // merge rule conditions into same namespace
            foreach ($node->props as $prop => $value) {
                if (!Str::startsWith($prop, 'yooessentials_access_')) {
                    continue;
                }

                $type = $prop;
                $condition = (array) $value;

                if (!($condition['state'] ?? false)) {
                    continue;
                }

                unset($condition['state']);

                $node->props['yooessentials_access_conditions'][] = (object) [
                    'props' => $condition,
                    'type' => $type
                ];

                unset($node->props[$prop]);
            }
        }

    ]

];
