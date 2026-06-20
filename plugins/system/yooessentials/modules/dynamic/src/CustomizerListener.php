<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Dynamic;

use YOOtheme\Config;
use YOOtheme\Metadata;
use YOOtheme\Path;

class CustomizerListener
{
    public static function initCustomizer(Config $config, Metadata $metadata)
    {
        $config->addFile('customizer', Path::get('../config/customizer.json'));

        $metadata->set('script:yooessentials-dynamic', ['src' => '~yooessentials_url/modules/dynamic/assets/customizer.min.js', 'defer' => true]);
    }

    public static function builderType($type)
    {
        if (isset($type['fields']['source']['fields']['_source'])) {
            $type['fields']['source']['fields']['_source']['type'] = 'yooessentials-source-select';
        }

        return $type;
    }
}
