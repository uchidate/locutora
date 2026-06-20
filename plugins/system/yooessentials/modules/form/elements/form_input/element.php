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

        'render' => function (object $node, array $params) {
            $parent = $params['parent'] ?? new \stdClass;

            $node->propsControl = Prop::filterByPrefix($node->props, 'control_');

            if (($parent->type ?? '') === 'yooessentials_form_fieldset' && !$parent->props['fields_show_label']) {
                $node->props['show_label'] = false;
            }
        }

    ]

];
