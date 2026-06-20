<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form;

use ZOOlanders\YOOessentials\Vendor\Respect\Validation\Validator;

$input = require __DIR__ . '/../form_input_text/element.php';

return array_merge($input, [

    'transforms' => [

        'render' => function (object $node, array $params) use ($input) {
            $input['transforms']['render']($node, $params);

            try {
                if ($value = $node->control->value ?? null) {
                    $value = new \DateTime($value);
                    $node->control->value = $value->format('Y-m-d');
                }
            } catch (\Exception $e) {
            }
        }

    ],

    'validation' => function ($control, Validator $validator) {
        $props = $control['props'];

        if ($props['required'] ?? false) {
            $validator->notOptional();
        }

        if ($control['value'] ?? false) {
            $validator->dateTime();

            if ($min = $props['mindate'] ?? false) {
                $validator->min(new \DateTime($min));
            }

            if ($max = $props['maxdate'] ?? false) {
                $validator->max(new \DateTime($max));
            }
        }

        return $validator;
    }

]);
