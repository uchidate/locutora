<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Auth\Driver\Cloudflare;

use ZOOlanders\YOOessentials\Auth\AuthDriver;

return [

    'routes' => [

        ['post', CloudflareController::PRE_SAVE_API_TOKEN_ENDPOINT, CloudflareController::class . '@verifyApiToken'],

    ],

    'yooessentials-auth-drivers' => [

        AuthDriver::class => [__DIR__ . '/driver-api-token.json', __DIR__ . '/driver-stream-key.json']

    ]

];
