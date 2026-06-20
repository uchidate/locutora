<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Request\Type;

use function YOOtheme\app;

class RequestQueryType
{
    public static function config(): array
    {
        return [

            'fields' => [

                'yooessentials_request' => [
                    'type' => 'YooessentialsRequest',
                    'metadata' => [
                        'label' => 'Request',
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::resolve',
                    ],
                ],

            ],

        ];
    }

    public static function resolve()
    {
        return app()->config->get('req', []);
    }
}
