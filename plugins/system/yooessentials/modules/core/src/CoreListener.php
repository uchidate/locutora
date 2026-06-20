<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials;

use YOOtheme\Config;
use YOOtheme\Metadata;
use YOOtheme\Path;
use YOOtheme\Str;
use YOOtheme\Url;
use ZOOlanders\YOOessentials\Api\MaxMind\GeoIp;

class CoreListener
{
    public static function initCustomizer(Metadata $metadata, Config $config, GeoIp $geoip)
    {
        $config->set('customizer.yooessentials.geoipcity', $geoip->isCityDb());
        $config->set('customizer.yooessentials.geoipcountry', $geoip->isCountryDb());
        $config->set('customizer.yooessentials.requestUrl', Url::route('route'));
        $config->addFile('yooessentials.core.fields', Path::get('../config/fields.json'));

        // add builder core assets
        $metadata->set('script:yooessentials-customizer-core', ['src' => '~yooessentials_url/modules/core/assets/customizer.min.js', 'defer' => true]);
        $metadata->set('style:yooessentials-customizer-core', ['href' => '~yooessentials_url/modules/core/assets/customizer.min.css', 'defer' => true]);
    }

    public static function loadMetadata(Config $config, $meta)
    {
        if (Str::contains($meta->name, ':yooessentials')) {
            $version = $config('yooessentials.version');
            $build = $config('yooessentials.build');
            $meta->version = $version . ($build ? "-$build" : '');
        }

        return $meta;
    }
}
