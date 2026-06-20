<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Icon;

use YOOtheme\Config;
use YOOtheme\Metadata;
use YOOtheme\Path;

class IconListener
{
    public static function initCustomizer(Config $config, Metadata $metadata, IconLoader $loader)
    {
        if ($dir = $config->get('theme.childDir')) {
            $loader->addCollection([
                'name' => 'myicons',
                'title' => 'My Icons',
                'groups' => $loader->getCollectionGroups("$dir/myicons"),
                'icons' => $loader->getTotalIcons("$dir/myicons"),
            ]);
        }

        $config->add('customizer.yooessentials.icon_collections', array_values($loader->collections()));
        $config->addFile('customizer', Path::get('../config/customizer.json'));
        $metadata->set('script:yooessentials-customizer-icon', ['src' => '~yooessentials_url/modules/icon/assets/customizer.min.js', 'defer' => true]);
    }

    public static function initTheme(Config $config, IconLoader $loader)
    {
        $menuItems = $config->get('~theme.menu.items', []);

        foreach ($menuItems as $item) {
            if (!empty($item['icon'])) {
                $loader->loadIcon($item['icon']);
            }
        }
    }
}
