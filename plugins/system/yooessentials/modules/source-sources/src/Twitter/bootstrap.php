<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Twitter;

return [

    'routes' => [

        ['post', TwitterController::PRESAVE_ENDPOINT, TwitterController::class . '@presave'],

    ],

    'yooessentials-sources' => [

        'twitter' => TwitterSource::class

    ],

];
