<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Auth\Driver\TikTok;

return [

    'routes' => [

        ['post', TikTokController::PRE_SAVE_ENDPOINT, TikTokController::class . '@presave'],

    ],

    'yooessentials-auth-drivers' => [

        TikTokDriver::class => __DIR__ . '/driver.json'

    ],

];
