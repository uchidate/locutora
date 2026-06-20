<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials;

use function YOOtheme\app;
use YOOtheme\Arr;
use YOOtheme\Config as Yooconfig;

return [

    'config' => [

        // migrate config from yooconfig
        '1.6.0-beta' => function ($config) {

            /** @var Yooconfig $yooconfig */
            $yooconfig = app(Yooconfig::class);

            foreach (['access', 'auth', 'element', 'form', 'icon', 'source'] as $path) {
                if ($val = $yooconfig->get("~theme.yooessentials.{$path}")) {
                    if (!Arr::has($config, $path)) {
                        Arr::set($config, $path, $val);
                    }

                    $yooconfig->del("~theme.yooessentials.{$path}");
                }
            }

            $yooconfig->del('~theme.yooessentials');

            return $config;
        }

    ]

];
