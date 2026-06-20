<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Instagram;

use ZOOlanders\YOOessentials\Config\ConfigUpdater;

return [

    'routes' => [

        ['post', InstagramController::PRESAVE_ENDPOINT, InstagramController::class . '@presave'],
        ['post', InstagramController::PAGES_ENDPOINT, InstagramController::class . '@pages', ['allowed' => true]],

    ],

    'yooessentials-sources' => [

        'instagram' => InstagramSource::class,
        'instagram_business' => InstagramBusinessSource::class

    ],

    'extend' => [
        ConfigUpdater::class => function (ConfigUpdater $update) {
            $update->addGlobals(require __DIR__ . '/updates.php');
        }
    ],

];
