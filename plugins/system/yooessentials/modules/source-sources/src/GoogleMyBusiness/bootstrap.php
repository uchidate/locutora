<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\GoogleMyBusiness;

return [

    'routes' => [

        ['post', GoogleMyBusinessController::PRESAVE_ENDPOINT, GoogleMyBusinessController::class . '@presave'],
        ['post', GoogleMyBusinessController::GET_LOCATIONS_ENDPOINT, GoogleMyBusinessController::class . '@locations'],
        ['post', GoogleMyBusinessController::GET_ACCOUNTS_ENDPOINT, GoogleMyBusinessController::class . '@accounts'],
        ['post', GoogleMyBusinessController::GET_REVIEWS_ENDPOINT, GoogleMyBusinessController::class . '@reviews']

    ],

    'yooessentials-sources' => [

        'google_mybusiness' => GoogleMyBusinessSource::class,

    ],

];
