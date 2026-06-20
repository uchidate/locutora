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

        // migrate config to ig personal and business
        '1.8.8' => function ($config) {
            if (!isset($config['source']['sources'])) {
                return $config;
            }

            foreach ($config['source']['sources'] as &$source) {
                if ($source['provider'] !== 'instagram') {
                    continue;
                }

                if ($source['page_id'] ?? false) {
                    $source['provider'] = 'instagram_business';
                }
            }

            return $config;
        }

    ]

];
