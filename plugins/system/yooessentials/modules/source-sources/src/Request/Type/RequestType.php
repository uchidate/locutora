<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Request\Type;

class RequestType
{
    public static function config(): array
    {
        return [

            'fields' => [

                'href' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Href',
                    ],
                ],
                'time' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Timestamp',
                        'filters' => ['datemodify', 'date'],
                    ],
                ],
                'ip' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'IP'
                    ],
                ],
                'method' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Method'
                    ],
                ],
                'origin' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Origin'
                    ],
                ],
                'useragent' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Useragent'
                    ],
                ],
                'url' => [
                    'type' => 'YooessentialsRequestUrl',
                    'metadata' => [
                        'label' => 'Url',
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::resolveUrl',
                    ],
                ],

            ],

            'metadata' => [
                'type' => true,
                'label' => 'Request',
            ],

        ];
    }

    public static function resolveUrl(array $request): array
    {
        return parse_url($request['href'] ?? []);
    }
}
