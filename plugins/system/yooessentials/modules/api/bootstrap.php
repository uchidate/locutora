<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Api;

use ZOOlanders\YOOessentials\Api\Facebook\FacebookApi;
use ZOOlanders\YOOessentials\Api\Facebook\FacebookApiInterface;
use ZOOlanders\YOOessentials\Api\Google\GoogleService;
use ZOOlanders\YOOessentials\Api\Google\MyBusiness\GoogleMyBusinessApi;
use ZOOlanders\YOOessentials\Api\Google\MyBusiness\GoogleMyBusinessApiInteface;
use ZOOlanders\YOOessentials\Api\Google\Sheet\GoogleSheetApi;
use ZOOlanders\YOOessentials\Api\Google\Sheet\GoogleSheetApiInteface;
use ZOOlanders\YOOessentials\Api\Google\YouTube\YouTubeApi;
use ZOOlanders\YOOessentials\Api\Google\YouTube\YouTubeApiInterface;
use ZOOlanders\YOOessentials\Api\MaxMind\GeoIp;
use ZOOlanders\YOOessentials\Api\Twitter\TwitterApi;
use ZOOlanders\YOOessentials\Api\Twitter\TwitterApiInterface;
use ZOOlanders\YOOessentials\Vendor\Google\Client;
use ZOOlanders\YOOessentials\Vendor\GuzzleHttp\Client as GuzzleHttpClient;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\Cache\CacheInterface;

return [

    'services' => [

        Client::class => function (CacheInterface $cache) {
            $client = new Client();
            $client->setHttpClient(new GuzzleHttpClient());
            $client->setClientId(GoogleService::CLIENT_ID);
            $client->setClientSecret(GoogleService::CLIENT_SECRET);
            $client->setCache($cache);

            return $client;
        },

        GoogleSheetApiInteface::class => GoogleSheetApi::class,

        GoogleMyBusinessApiInteface::class => GoogleMyBusinessApi::class,

        TwitterApiInterface::class => TwitterApi::class,

        YouTubeApiInterface::class => YouTubeApi::class,

        FacebookApiInterface::class => FacebookApi::class,

        GeoIp::class => ''

    ],

];
