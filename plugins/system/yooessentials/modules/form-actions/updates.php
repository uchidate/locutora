<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

use function YOOtheme\app;
use ZOOlanders\YOOessentials\Form\Actions\Action;
use ZOOlanders\YOOessentials\Form\Actions\ActionManager;

return [

    'nodes' => [

        // Move action keys from class name to action name
        '1.5.2' => function ($node) {
            if (!isset($node->props['yooessentials_form'], $node->formid)) {
                return;
            }

            /** @var ActionManager $manager */
            $manager = app(ActionManager::class);

            $config = $node->props['yooessentials_form'] ?? [];

            foreach ($config->after_submit_actions ?? [] as $action) {
                // Old Action Key, and we still know the class
                if (class_exists($action->type ?? '')) {
                    $actionClass = app($action->type);
                    if ($actionClass instanceof Action) {
                        $actionClass = $manager->actionFromClassName(get_class($actionClass));
                        $action->type = $actionClass->name() ?? '';
                    }
                }
            }

            $node->props['yooessentials_form'] = $config;
        },

        // Generate Ids for Form actions
        '1.5.3' => function ($node) {
            if (!isset($node->props['yooessentials_form'], $node->formid)) {
                return;
            }

            $config = $node->props['yooessentials_form'] ?? [];

            foreach ($config->after_submit_actions ?? [] as $action) {
                $action->id = $action->id ?? uniqid();
            }

            $node->props['yooessentials_form'] = $config;
        }

    ]

];
