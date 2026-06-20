<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Joomla;

use YOOtheme\Config as Yooconfig;
use YOOtheme\File;
use YOOtheme\Metadata;
use YOOtheme\Path;
use ZOOlanders\YOOessentials\Config;
use ZOOlanders\YOOessentials\Logger;

class CustomizerListener
{
    public static function initCustomizer(Yooconfig $yooconfig, Config $config)
    {
        $yooconfig->addFile('customizer', Path::get('../config/customizer.json'));
        $yooconfig->set(
            'customizer.yooessentials.requestUrl',
            sprintf('%s&templateStyle=%s', $yooconfig->get('customizer.yooessentials.requestUrl'), $yooconfig->get('theme.id'))
        );

        $geoipdb = '~/plugins/system/akgeoip/db/GeoLite2-Country.mmdb';

        // set akeeba geoipdb
        if (empty($config->get('core.geoipdb')) && File::exists($geoipdb)) {
            $config->set('core.geoipdb', $geoipdb);
            $config->set('updated', true);
        }
    }

    public static function printLogger(Metadata $metadata, Yooconfig $config)
    {
        if ($config->get('app.isCustomizer')) {
            $metadata->set('script:yooesslogs', sprintf('window.parent.$yooesslogs = window.$yooesslogs = %s', json_encode(Logger::$logs)));
        }
    }
}
