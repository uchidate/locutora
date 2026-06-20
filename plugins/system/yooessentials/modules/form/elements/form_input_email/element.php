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

    'validation' => function ($control, Validator $validator) {
        $props = $control['props'];

        if ($control['value'] ?? false) {
            $validator->email();
            $validator->noWhitespace();
        }

        if ($props['required'] ?? false) {
            $validator->notOptional();
        }

        if ($pattern = $props['pattern'] ?? false) {
            $validator->regex("/$pattern/");
        }

        return $validator;
    }

]);
