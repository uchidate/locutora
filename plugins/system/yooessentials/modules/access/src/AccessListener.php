<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Access;

use function YOOtheme\app;
use YOOtheme\Arr;
use YOOtheme\Config;
use YOOtheme\Metadata;
use YOOtheme\Path;

class AccessListener
{
    public static function initCustomizer(Config $config, Metadata $metadata, Access $access)
    {
        self::processPanels($access, $config);

        $metadata->set('script:yooessentials-customizer-access', ['src' => '~yooessentials_url/modules/access/assets/customizer.min.js', 'defer' => true]);
    }

    protected static function processPanels(Access $access, Config $config)
    {
        /**
         * Map rules as panels
         */
        $commonPanel = $config->loadFile(Path::get('../config/access-rule-panel.json'));
        $panels = [];

        foreach ($access->rules() as $rule) {
            $panel = array_merge($commonPanel, [
                'title' => $rule->name(),
                'group' => $rule->group(),
                'icon' => $rule->icon()
            ]);

            $about = sprintf('<div class="uk-text-muted">%s Review the <a href="%s" target="_blank">Documentation Guide</a> for usage, tips and best practices.</div>', $rule->description(), $rule->docs() ?: 'https://zoolanders.com/docs/essentials-for-yootheme-pro/access');

            $panel['fields']['_about']['content'] = $about;
            $panel['fields']['_condition']['fields'] = $rule->fields();

            $panels[$rule->namespace()] = $panel;
        }

        $config->add('customizer.panels', $panels);

        /**
         * Add Access Panel
         */
        $accessPanel = $config->loadFile(Path::get('../config/access-panel.json'));
        $options = [];

        foreach ($access->rules() as $rule) {
            $options[] = [
                'name' => $rule->namespace(),
                'title' => $rule->name(),
                'icon' => $panels[$rule->namespace()]['icon'] ?? '',
                'description' => $rule->description(),
                'group' => $rule->group(),
                'panel' => $rule->namespace()
            ];
        }

        Arr::set($accessPanel, 'fields.yooessentials_access_conditions.options', $options);
        $config->set('customizer.panels.yooessentials-access', $accessPanel);
    }

    public static function builderType($type)
    {
        if (!app(Config::class)->get('app.isCustomizer')) {
            return $type;
        }

        // make sure the main fieldset is set
        if (!Arr::has($type, 'fieldset.default')) {
            return $type;
        }

        $tabs = array_reduce($type['fieldset']['default']['fields'], function ($carry, $v) {
            return array_merge($carry, [$v['title'] ?? null]);
        }, []);

        if (($index = array_search('Advanced', $tabs)) === false) {
            return $type;
        }

        $accessField = [
            'name' => '_yooessentials_access',
            'label' => 'Access',
            'text' => 'Conditions',
            'type' => 'button-panel',
            'panel' => 'yooessentials-access',
            'description' => 'Set advanced conditions that will determine the display of this element.'
        ];

        // get fields
        $fields = $type['fieldset']['default']['fields'][$index]['fields'] ?? null;

        if (!$fields || !is_array($fields)) {
            return $type;
        }

        // set button after status or after name
        Arr::splice($fields, ($fields[1] ?? '') === 'status' ? 2 : 1, 0, [$accessField]);
        $type['fieldset']['default']['fields'][$index]['fields'] = $fields;

        // update source condition field description
        if ($path = 'fields.source.fields._sourceCondition.fields._sourceConditionProp.description' and $desc = Arr::get($type, $path)) {
            Arr::set($type, $path, $desc . ' For a more advanced workflow use <b>Access Conditions</b> instead.');
        }

        return $type;
    }
}
