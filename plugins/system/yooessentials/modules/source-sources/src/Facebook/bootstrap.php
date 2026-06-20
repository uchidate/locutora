<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Facebook;

return [

    'routes' => [

        ['post', FacebookController::PRESAVE_ENDPOINT, FacebookController::class . '@presave'],
        ['post', FacebookController::PAGES_ENDPOINT, FacebookController::class . '@pages', ['allowed' => true]],

    ],

    'yooessentials-sources' => [

        'facebook' => FacebookSource::class

    ],

];
