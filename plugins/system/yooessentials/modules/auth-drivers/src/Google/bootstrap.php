<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Auth\Driver\Google;

use ZOOlanders\YOOessentials\Api\Google\GoogleService;
use ZOOlanders\YOOessentials\Auth\AuthDriver;
use ZOOlanders\YOOessentials\Vendor\Google\Client;
use ZOOlanders\YOOessentials\Vendor\GuzzleHttp\Client as GuzzleHttpClient;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\Cache\CacheInterface;

return [

    'routes' => [

        ['post', GoogleController::PRESAVE_ENDPOINT, GoogleController::class . '@presave'],
        ['post', GoogleController::PRESAVE_KEY_ENDPOINT, GoogleController::class . '@presaveKey'],

    ],

    'yooessentials-auth-drivers' => [

        AuthDriver::class => __DIR__ . '/driver-api.json',
        GoogleDriver::class => __DIR__ . '/driver.json'

    ],

    'services' => [
        Client::class => function (CacheInterface $cache) {
            $client = new Client();
            $client->setHttpClient(new GuzzleHttpClient());
            $client->setClientId(GoogleService::CLIENT_ID);
            $client->setClientSecret(GoogleService::CLIENT_SECRET);
            $client->setCache($cache);

            return $client;
        },

    ]

];
