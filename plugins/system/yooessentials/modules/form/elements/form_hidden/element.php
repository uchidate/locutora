<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form;

use ZOOlanders\YOOessentials\Util\Prop;

return [

    'transforms' => [

        'render' => function ($node) {
            $controlName = $node->controls->hidden['name'];
            $controlProps = $node->controls->hidden['props'];

            $node->control = (object) [
                'name' => $controlName,
                'id' => $controlProps['id'] ?? null,
                'value' => $controlProps['value'],
                'props' => $controlProps
            ];
        }

    ],

    'controls' => [

        'hidden' => function ($node) {
            $props = Prop::filterByPrefix($node->props, 'control_');
            $name = isset($props['name']) ? $props['name'] : "$node->id-hidden";

            return compact('name', 'props');
        }

    ]

];
