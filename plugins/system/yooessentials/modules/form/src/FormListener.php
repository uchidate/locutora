<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form;

use YOOtheme\Arr;
use YOOtheme\Config;
use YOOtheme\Http\Request;
use YOOtheme\Metadata;
use YOOtheme\Path;
use ZOOlanders\YOOessentials\Form\Controller\FormAdminController;
use ZOOlanders\YOOessentials\Form\Source\FormQueryType;
use ZOOlanders\YOOessentials\Form\Source\FormType;

class FormListener
{
    public static function initSource(Request $request, $source)
    {
        if ($request->getParam('p') !== FormAdminController::FIELDS_URL) {
            return;
        }

        $source->objectType(FormType::TYPE_NAME, FormType::config($request->getParam('controls', [])));
        $source->queryType(FormQueryType::config());
    }

    public static function initCustomizer(Config $config, Metadata $metadata)
    {
        $config->addFile('customizer', Path::get('../config/customizer.json'));
        $config->addFile('yooessentials.form.fields', Path::get('../config/builder.json'));

        $metadata->set('script:yooessentials-customizer-form', ['src' => '~yooessentials_url/modules/form/assets/customizer.min.js', 'defer' => true]);
    }

    public static function addFormPanel(Config $config, $type)
    {
        // constraint types
        if (!in_array($type['name'], ['section', 'column'])) {
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

        $statusField = [
            'type' => 'checkbox',
            'name' => 'yooessentials_form.state',
            'label' => 'Form',
            'text' => 'Enable as Form Area'
        ];

        $configButton = [
            'name' => '_yooessentials_form',
            'text' => 'Configuration',
            'type' => 'button-panel',
            'panel' => 'yooessentials-form-settings',
            'enable' => 'yooessentials_form.state',
            'description' => 'Enable this element as a Form Area, and set it submission configuration.'
        ];

        // set button right after status field
        Arr::splice($type['fieldset']['default']['fields'][$index]['fields'], 2, 0, [$statusField, $configButton]);

        return $type;
    }
}
