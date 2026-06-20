<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Instagram;

return [

    'config' => [

        // migrate config to youtube multiple sources
        '1.8.8' => function ($config) {
            if (!isset($config['source']['sources'])) {
                return $config;
            }

            foreach ($config['source']['sources'] as &$source) {
                if ($source['provider'] !== 'youtube') {
                    continue;
                }

                $videosSource = $source['videos_source'] ?? '';

                if ($videosSource === 'channel') {
                    $source['provider'] = 'youtube_channel';
                    unset($source['videos_source']);
                }

                if ($videosSource === 'playlist') {
                    $source['provider'] = 'youtube_playlist';
                    unset($source['videos_source']);
                }
            }

            return $config;
        }

    ]

];
