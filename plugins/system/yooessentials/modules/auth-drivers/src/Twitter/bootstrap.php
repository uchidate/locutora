<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Auth\Driver\Twitter;

return [

    'routes' => [

        ['post', TwitterController::PRE_SAVE_ENDPOINT, TwitterController::class . '@presave'],
        ['post', TwitterController::GENERATE_ID_ENDPOINT, TwitterController::class . '@generateId'],

    ],

    'yooessentials-auth-drivers' => [

        TwitterDriver::class => __DIR__ . '/driver.json'

    ],

];
