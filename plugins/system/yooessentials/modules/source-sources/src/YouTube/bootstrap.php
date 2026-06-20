<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\YouTube;

use ZOOlanders\YOOessentials\Config\ConfigUpdater;

return [

    'routes' => [

        ['post', YouTubeController::PRESAVE_ENDPOINT, YouTubeController::class . '@presave'],
        ['post', YouTubeController::GET_VIDEOS_ENDPOINT, YouTubeController::class . '@videos'],
        ['post', YouTubeController::GET_CHANNELS_ENDPOINT, YouTubeController::class . '@channels'],
        ['post', YouTubeController::GET_PLAYLISTS_ENDPOINT, YouTubeController::class . '@playlists'],

    ],

    'yooessentials-sources' => [

        'youtube' => YouTubeSource::class,
        'youtube_channel' => YouTubeChannelSource::class,
        'youtube_playlist' => YouTubePlaylistSource::class,

    ],

    'extend' => [
        ConfigUpdater::class => function (ConfigUpdater $update) {
            $update->addGlobals(require __DIR__ . '/updates.php');
        }
    ],

];
