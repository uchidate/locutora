<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Auth\Driver\ApiKey;

use ZOOlanders\YOOessentials\Auth\AuthDriver;

return [

    'routes' => [

        ['post', ApiKeyController::PRESAVE_ENDPOINT, ApiKeyController::class . '@presave'],

    ],

    'yooessentials-auth-drivers' => [

        AuthDriver::class => __DIR__ . '/driver.json',

    ]

];
