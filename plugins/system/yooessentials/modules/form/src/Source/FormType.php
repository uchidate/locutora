<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form\Source;

use function YOOtheme\app;
use YOOtheme\Builder;
use YOOtheme\Str;

class FormType
{
    public const TYPE_NAME = 'YooessentialsForm';

    public static function config(array $controls): array
    {
        /** @var Builder $builder */
        $builder = app(Builder::class);

        $fields = [];
        foreach ($controls as $control) {
            $type = $builder->types[$control['type']] ?? null;

            if (!$type || !$type->submittable) {
                continue;
            }

            $fields[Str::camelCase($control['name'])] = [
                'type' => $type->container
                    ? ['listOf' => 'String']
                    : 'String',
                'metadata' => [
                    'label' => $control['props']['label'] ?? Str::titleCase($control['name']),
                    'filters' => [
                        Str::contains($control['type'], 'date') ? 'date' : null,
                        Str::contains($control['type'], 'text') ? 'limit' : null
                    ],
                ],
            ];
        }

        return [
            'fields' => $fields,
            'metadata' => [
                'type' => true,
                'label' => 'Form',
            ],
        ];
    }
}
