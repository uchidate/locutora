<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Layout;

use YOOtheme\Config as Yooconfig;
use YOOtheme\Metadata;
use YOOtheme\Path;
use ZOOlanders\YOOessentials\Config;

class CustomizerListener
{
    public static function initLibraries(Config $config, LayoutManager $manager)
    {
        $libraries = $config->get(LayoutManager::LIBRARIES_CONFIG_KEY, []);

        $manager->setLibraries($libraries);
    }

    public static function initCustomizer(Metadata $metadata, Yooconfig $yooconfig)
    {
        $yooconfig->addFile('customizer', Path::get('../config/customizer.json'));

        $metadata->set('script:yooessentials-customizer-layout', ['src' => '~yooessentials_url/modules/layout/assets/customizer.min.js',
            'defer' => true
        ]);
    }
}
