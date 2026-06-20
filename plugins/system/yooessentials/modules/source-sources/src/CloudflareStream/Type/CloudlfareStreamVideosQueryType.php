<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\CloudflareStream\Type;

use YOOtheme\Event;
use ZOOlanders\YOOessentials\Source\GraphQL\AbstractQueryType;
use ZOOlanders\YOOessentials\Source\GraphQL\HasSourceInterface;
use ZOOlanders\YOOessentials\Source\Resolver\CachesResolvedData;
use ZOOlanders\YOOessentials\Source\Resolver\LoadsSourceFromArgs;

class CloudlfareStreamVideosQueryType extends AbstractQueryType implements HasSourceInterface
{
    use LoadsSourceFromArgs, CachesResolvedData;

    public function name(): string
    {
        return "cloudflareStreamVideos_{$this->source()->id()}_query";
    }

    public function label(): string
    {
        return "{$this->source()->name()} Videos";
    }

    public static function getCacheKey(): string
    {
        return 'cloudflare-stream-videos';
    }

    public function config(): array
    {
        return [

            'fields' => [

                $this->name() => [

                    'type' => [
                        'listOf' => CloudflareStreamVideoType::TYPE_NAME
                    ],

                    'args' => [
                        'after' => [
                            'type' => 'String',
                        ],
                        'before' => [
                            'type' => 'String',
                        ],
                        'search' => [
                            'type' => 'String',
                        ],
                        'limit' => [
                            'type' => 'Int',
                        ],
                        'status' => [
                            'type' => 'String',
                        ],
                        'cache' => [
                            'type' => 'Int'
                        ],
                    ],

                    'metadata' => [
                        'group' => 'Cloudflare',
                        'label' => $this->label(),
                        'fields' => [

                            'search' => [
                                'label' => 'Search',
                                'description' => 'Filter videos based on it name.',
                            ],

                            '_basic_filter' => [
                                'type' => 'grid',
                                'width' => '1-2',
                                'fields' => [
                                    'status' => [
                                        'label' => 'Status',
                                        'type' => 'select',
                                        'description' => 'Filter by status.',
                                        'default' => 'ready',
                                        'options' => [
                                            'Downloading' => 'downloading',
                                            'Queued' => 'queued',
                                            'In Progress' => 'inprogress',
                                            'Ready' => 'ready',
                                            'Error' => 'error',
                                        ],
                                    ],
                                    'limit' => [
                                        'label' => 'Limit',
                                        'description' => 'The total of videos to fetch.',
                                        'type' => 'yooessentials-number',
                                        'default' => 20,
                                        'attrs' => [
                                            'min' => 0,
                                            'max' => 1000,
                                        ]
                                    ],
                                ],
                            ],

                            '_datetime_range' => [
                                'type' => 'grid',
                                'width' => '1-2',
                                'description' => 'Filter videos created after or before specified date-time.',
                                'fields' => [
                                    'after' => [
                                        'label' => 'After',
                                        'attrs' => [
                                            'type' => 'datetime-local'
                                        ]
                                    ],
                                    'before' => [
                                        'label' => 'Before',
                                        'attrs' => [
                                            'type' => 'datetime-local'
                                        ]
                                    ],
                                ],
                            ],

                            // 'order_direction' => [
                            //     'label' => trans('Direction'),
                            //     'type' => 'select',
                            //     'default' => 'DESC',
                            //     'options' => [
                            //         trans('Ascending') => 'ASC',
                            //         trans('Descending') => 'DESC',
                            //     ],
                            //     'enable' => '!id',
                            // ],

                            'cache' => [
                                'type' => 'yooessentials-number',
                                'label' => 'Cache Time',
                                'description' => 'The duration in seconds before the cache is renewed. Set to <code>0</code> to disable caching.',
                                'attrs' => [
                                    'min' => 0,
                                    'max' => 86400 * 30,
                                    'placeholder' => static::DEFAULT_CACHE_TIME
                                ]
                            ],

                        ]
                    ],

                    'extensions' => [
                        'call' => [
                            'func' => __CLASS__ . '::resolve',
                            'args' => [
                                'source_id' => $this->source()->id()
                            ]
                        ]
                    ],

                ],

            ],

        ];
    }

    public static function resolve($root, array $args)
    {
        $source = self::loadSource($args, CloudflareStreamSource::class);

        if (!$source) {
            return [];
        }

        try {
            $streams = self::resolveFromCache($source, $args, function () use ($source, $args) {
                return (array) $source->api()->streams($args);
            });
        } catch (\Exception $e) {
            Event::emit('yooessentials.error', [
                'addon' => 'source',
                'action' => 'source-cloudflare-stream-videos-resolve',
                'args' => $args,
                'error' => $e->getMessage(),
                'exception' => $e
            ]);
        }

        foreach ($streams as &$stream) {
            $source->signStream($stream);
        }

        return $streams;
    }
}
