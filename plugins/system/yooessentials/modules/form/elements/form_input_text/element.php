<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form;

use function YOOtheme\App;
use ZOOlanders\YOOessentials\Form\Http\FormSubmissionRequest;
use ZOOlanders\YOOessentials\Util\Prop;
use ZOOlanders\YOOessentials\Vendor\Respect\Validation\Validator;

return [

    'transforms' => [

        'render' => function (object $node) {
            /** @var FormSubmissionRequest $submission */
            $submission = app(FormSubmissionRequest::class);

            $controlName = $node->controls->input['name'];
            $controlProps = $node->controls->input['props'];

            $node->control = (object) [
                'name' => $controlName,
                'id' => $controlProps['id'] ?? null,
                'errors' => $submission->validator()->errors($controlName) ?? [],
                'value' => $submission->data($controlName) ?? $controlProps['value'],
                'props' => $controlProps
            ];
        }

    ],

    'controls' => [

        'input' => function ($node, array $params) {
            $index = $params['index'];
            $parent = $params['parent'];
            $props = Prop::filterByPrefix($node->props, 'control_');
            $name = isset($props['name']) ? $props['name'] : "$parent->id-input-$index";

            return compact('name', 'props');
        }

    ],

    'validation' => function ($control, Validator $validator) {
        $props = $control['props'];

        if ($props['required'] ?? false) {
            $validator->notOptional();
        }

        if ($min = $props['minlength'] ?? false) {
            $validator->length($min);
        }

        if ($max = $props['maxlength'] ?? false) {
            $validator->length(null, $max);
        }

        if ($pattern = $props['pattern'] ?? false) {
            $validator->regex("/$pattern/");
        }

        return $validator;
    }

];
