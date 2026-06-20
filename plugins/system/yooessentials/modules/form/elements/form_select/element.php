<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form;

use function YOOtheme\App;
use YOOtheme\Arr;
use ZOOlanders\YOOessentials\Form\Http\FormSubmissionRequest;
use ZOOlanders\YOOessentials\Util\Prop;
use ZOOlanders\YOOessentials\Vendor\Respect\Validation\Validator;

return [

    'transforms' => [

        'render' => function (object $node, array $params) {
            /** @var FormSubmissionRequest $submission */
            $submission = app(FormSubmissionRequest::class);

            $parent = $params['parent'] ?? new \stdClass;
            $controlName = $node->controls->select['name'];
            $controlProps = $node->controls->select['props'];

            if (($parent->type ?? '') === 'yooessentials_form_fieldset' && !$parent->props['fields_show_label']) {
                $controlProps['label'] = '';
            }

            $node->control = (object) [
                'name' => $controlName,
                'id' => $controlProps['id'] ?? null,
                'errors' => $submission->validator()->errors($controlName) ?? [],
                'value' => Arr::wrap($submission->data($controlName) ?? $controlProps['value']),
                'props' => $controlProps
            ];
        }

    ],

    'controls' => [

        'select' => function ($node) {
            $props = Prop::filterByPrefix($node->props, 'control_');
            $name = $props['name'] ?: "select-$node->id";
            $options = array_map(function ($child) {
                return $child->props['value'] ?? '';
            }, $node->children);

            return compact('name', 'props', 'options');
        }

    ],

    'validation' => function ($control, Validator $validator) {
        $props = $control['props'];
        $multiple = $props['multiple'] ?? false;

        if ($props['required'] ?? false) {
            $validator->notEmpty();
        }

        if (!$multiple) {
            return $validator;
        }

        if ($min = $props['min'] ?? false) {
            $validator->length($min);
        }

        if ($max = $props['max'] ?? false) {
            $validator->length(null, $max);
        }

        return $validator;
    }

];
