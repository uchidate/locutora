<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form\Actions;

use YOOtheme\Config;
use YOOtheme\Middleware;
use ZOOlanders\YOOessentials\Form\Http\FormSubmissionResponse;

class ActionListener
{
    private static $registered = false;

    public static function initCustomizer(Config $config, ActionManager $actionManager)
    {
        $panels = [];
        $options = [];

        // get actions panels and options
        foreach ($actionManager->actions() as $name => $action) {
            $panelName = 'forms-action-' . $action->name();

            $options[] = [
                'name' => $action->name(),
                'title' => $action->title(),
                'icon' => $action->panel()['icon'] ?? '',
                'collection' => $action->panel()['collection'] ?? '',
                'description' => $action->panel()['description'] ?? '',
                'group' => $action->panel()['group'] ?? '',
                'panel' => $panelName,
                'titleFallback' => $action->title()
            ];

            $panels[$panelName] = $action->panel();
        }

        $config->add('customizer.panels', $panels);

        // workaround to set options on index keyed with a dot
        $fields = $config->get('customizer.panels.yooessentials-form-settings.fields');
        $fields['yooessentials_form.after_submit_actions']['options'] = $options;
        $config->set('customizer.panels.yooessentials-form-settings.fields', $fields);
    }

    /**
     * @param FormSubmissionResponse $response
     * @param callable $next
     */
    public static function handleFormActions($response, $next)
    {
        if (self::$registered) {
            return $next($response);
        }

        $form = $response->submission()->form();

        if ($form->hasExternalActionUrl()) {
            return $next($response);
        }

        $middleware = new Middleware(function () use ($next, $response) {
            return $next($response);
        }, $form->actions());

        self::$registered = true;

        /** @var FormSubmissionResponse $response */
        return $middleware($response);
    }
}
