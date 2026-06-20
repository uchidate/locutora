<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\TikTok;

return [

    'routes' => [

        ['post', TikTokController::PRESAVE_ENDPOINT, TikTokController::class . '@presave']

    ],

    'yooessentials-sources' => [

        'tiktok' => TikTokSource::class

    ],

];
