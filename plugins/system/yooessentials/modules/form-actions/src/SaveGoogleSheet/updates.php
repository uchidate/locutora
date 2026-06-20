<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

use function YOOtheme\app;
use YOOtheme\Str;
use ZOOlanders\YOOessentials\Form\FormService;

return [

    'nodes' => [

        // Transition actions to new dynamic configuration
        '1.8.1' => function ($node) {
            if (!isset($node->props['yooessentials_form'], $node->formid)) {
                return;
            }

            /** @var FormService $formService */
            $formService = app(FormService::class);

            $config = $node->props['yooessentials_form'] ?? [];

            foreach ($config->after_submit_actions ?? [] as $action) {
                if ($action->type !== 'save-google-sheet' || !isset($action->props->columns)) {
                    continue;
                }

                $columns = $action->props->columns ?? [];

                if (empty($columns)) {
                    $controls = array_values(array_filter($formService->getControlList($node), function ($control) use ($formService) {
                        return $formService->getControlType($control)->submittable ?? false;
                    }));

                    $columns = array_map(function ($control) {
                        return (object) ['title' => $control['name'], 'field' => $control['name']];
                    }, $controls);
                }

                $action->props->content = [];
                foreach ($columns as $column) {
                    if (!isset($column->title, $column->field)) {
                        continue;
                    }

                    $action->props->content[] = [
                        'id' => $column->title,
                        'props' => [],
                        'source_extended' => [
                            'props' => [
                                'value' => [
                                    'name' => Str::camelCase($column->field),
                                    'query' => [
                                        'name' => 'yooessentials_form_query'
                                    ]
                                ]
                            ]
                        ]
                    ];
                }

                unset($action->props->columns);
            }

            $node->props['yooessentials_form'] = $config;
        }

    ]

];
