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

        'render' => function (object $node, array $params) {
            /** @var FormSubmissionRequest $submission */
            $submission = app(FormSubmissionRequest::class);

            $parent = $params['parent'] ?? new \stdClass;
            $controlName = $node->controls->range['name'];
            $controlProps = $node->controls->range['props'];

            if (($parent->type ?? '') === 'yooessentials_form_fieldset' && !$parent->props['fields_show_label']) {
                $controlProps['label'] = '';
            }

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

        'range' => function ($node) {
            $props = Prop::filterByPrefix($node->props, 'control_');
            $name = isset($props['name']) ? $props['name'] : "$node->id-range";

            return compact('name', 'props');
        }

    ],

    'validation' => function ($control, Validator $validator) {
        $props = $control['props'];

        if ($props['required'] ?? false) {
            $validator->notOptional();
        }

        if ($min = $props['min'] ?? false) {
            $validator->min($min);
        }

        if ($max = $props['max'] ?? false) {
            $validator->max($max);
        }

        return $validator;
    }

];
