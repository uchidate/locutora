<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Request\Type;

use YOOtheme\Arr;

class RequestUrlType
{
    public static function config(): array
    {
        return [

            'fields' => [

                'scheme' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Scheme'
                    ],
                ],

                'host' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Host'
                    ],
                ],

                'port' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Port'
                    ],
                ],

                'path' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Path'
                    ],
                ],

                'fragment' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Fragment'
                    ],
                ],

                'query' => [
                    'type' => 'String',
                    'args' => [
                        'param' => [
                            'type' => 'String'
                        ],
                    ],
                    'metadata' => [
                        'label' => 'Query'
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::resolveQuery',
                    ],
                ],

                'query_param' => [
                    'type' => 'String',
                    'args' => [
                        'param' => [
                            'type' => 'String'
                        ],
                    ],
                    'metadata' => [
                        'label' => 'Query Param',
                        'arguments' => [
                            'param' => [
                                'label' => 'Param',
                                'description' => 'Set the query param name or path which value to return. E.g. <code>foo</code>, <code>foo.0</code>.',
                                'default' => ''
                            ],
                        ],
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::resolveQueryParam',
                    ],
                ],

            ],

            'metadata' => [
                'type' => true,
                'label' => 'Request',
            ],

        ];
    }

    public static function resolveQuery(array $url, array $args): string
    {
        $query = $url['query'] ?? '';
        $param = $args['param'] ?? '';

        /** Deprecated since 1.5.4 */
        if ($param && $query) {
            parse_str($query, $parts);
            $result = Arr::get($parts, $param);

            if (is_array($result)) {
                return http_build_query($result);
            }

            return $result;
        }

        return $query;
    }

    public static function resolveQueryParam(array $url, array $args): string
    {
        $query = $url['query'] ?? '';
        $param = $args['param'] ?? '';

        if (!$query || !$param) {
            return '';
        }

        parse_str($query, $parts);
        $result = Arr::get($parts, $param);

        if (is_array($result)) {
            return http_build_query($result);
        }

        return $result;
    }
}
