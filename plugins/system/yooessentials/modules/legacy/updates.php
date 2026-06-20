<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

return [

    'nodes' => [

        // migrate deprecated actions to legacy
        '1.8.0' => function ($node) {
            if (!isset($node->props['yooessentials_form'], $node->formid)) {
                return;
            }

            $config = (object) ($node->props['yooessentials_form'] ?? []);

            foreach ($config->after_submit_actions ?? [] as &$action) {
                if ($action->type === 'save-csv' && isset($action->props->columns)) {
                    $action->type = 'save-csv-legacy';
                }

                if ($action->type === 'save-google-sheet' && isset($action->props->columns)) {
                    $action->type = 'save-google-sheet-legacy';
                }
            }

            $node->props['yooessentials_form'] = $config;
        },

        // migrate deprecated datetime rules to legacy
        '1.6.11' => function ($node) {
            foreach ($node->props['yooessentials_access_conditions'] ?? [] as &$rule) {
                $props = (array) ($rule->props ?? []);

                if (empty($props)) {
                    continue;
                }

                $isLegacyDatetime = ($rule->type ?? '') === 'yooessentials_access_datetime';
                $isConverted = isset($props['publish_up']) || isset($props['publish_down']);

                if ($isLegacyDatetime && !$isConverted) {
                    $rule->type = 'yooessentials_access_datetime_legacy';
                }
            }
        },

    ]

];
