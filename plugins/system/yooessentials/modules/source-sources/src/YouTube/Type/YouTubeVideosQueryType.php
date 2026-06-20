<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\YouTube\Type;

use YOOtheme\Arr;
use YOOtheme\Event;
use ZOOlanders\YOOessentials\Source\GraphQL\AbstractQueryType;
use ZOOlanders\YOOessentials\Source\GraphQL\HasSourceInterface;
use ZOOlanders\YOOessentials\Source\Resolver\CachesResolvedData;
use ZOOlanders\YOOessentials\Source\Resolver\LoadsSourceFromArgs;
use ZOOlanders\YOOessentials\Sources\YouTube\YouTubeSource;

class YouTubeVideosQueryType extends AbstractQueryType implements HasSourceInterface
{
    use LoadsSourceFromArgs, CachesResolvedData;

    public const DEFAULT_MAX_RESULTS = 5;

    public function name(): string
    {
        $id = $this->source->config()['id'];

        return "youtubeVideos_{$id}_query";
    }

    public function label(): string
    {
        return "{$this->source()->name()} Videos";
    }

    public static function getCacheKey(): string
    {
        return 'youtube-videos';
    }

    public function config(): array
    {
        return [

            'fields' => [

                $this->name() => [

                    'type' => [
                        'listOf' => YouTubeVideoType::TYPE_NAME,
                    ],

                    'args' => [
                        'channelId' => [
                            'type' => 'String',
                        ],
                        'location' => [
                            'type' => 'String',
                        ],
                        'locationRadius' => [
                            'type' => 'String',
                        ],
                        'order' => [
                            'type' => 'String',
                        ],
                        'offset' => [
                            'type' => 'Int',
                        ],
                        'maxResults' => [
                            'type' => 'Int',
                        ],
                        'publishedAfter' => [
                            'type' => 'String',
                        ],
                        'publishedBefore' => [
                            'type' => 'String',
                        ],
                        'q' => [
                            'type' => 'String',
                        ],
                        'regionCode' => [
                            'type' => 'String',
                        ],
                        'relevanceLanguage' => [
                            'type' => 'String',
                        ],
                        'videoDuration' => [
                            'type' => 'String',
                        ],
                        'videoDefinition' => [
                            'type' => 'String',
                        ],
                        'cache' => [
                            'type' => 'Int'
                        ]
                    ],

                    'metadata' => [
                        'group' => 'YouTube',
                        'label' => $this->label(),
                        'fields' => [
                            'q' => [
                                'label' => 'Query Term',
                                'description' => 'Use the Boolean NOT (-) and OR (|) operators to exclude or find videos that are associated with one of several search terms. For example, to match either "boating" or "sailing", set as <code>boating|sailing</code>. Similarly, to exclude "fishing", set as <code>boating|sailing -fishing</code>.',
                            ],
                            '_after_before' => [
                                'type' => 'grid',
                                'width' => '1-2',
                                'fields' => [
                                    'publishedAfter' => [
                                        'label' => 'Published After',
                                        'description' => 'At or after the specified date.',
                                        'attrs' => [
                                            'type' => 'datetime-local',
                                        ]
                                    ],
                                    'publishedBefore' => [
                                        'label' => 'Published Before',
                                        'description' => 'Before or at the specified date.',
                                        'attrs' => [
                                            'type' => 'datetime-local',
                                        ]
                                    ],
                                ]
                            ],
                            '_geo' => [
                                'type' => 'grid',
                                'width' => '1-2',
                                'description' => 'Location in conjunction with Radius, defines a circular geographic area to which to restrict the videos to retrieve.',
                                'fields' => [
                                    'location' => [
                                        'label' => 'Location',
                                        'description' => 'The coordinates that points at the center of the area.',
                                        'attrs' => [
                                            'placeholder' => 'lat,lon'
                                        ]
                                    ],
                                    'locationRadius' => [
                                        'label' => 'Radius',
                                        'description' => 'The maximum distance from the location in <b>m</b>, <b>km</b>, <b>ft</b>, or <b>mi</b> units.'
                                    ],
                                ]
                            ],
                            '_region_language' => [
                                'type' => 'grid',
                                'width' => '1-2',
                                'description' => 'Restrict the videos to those that can be viewed in a specific country and/or are in a relevant language. Note that videos in other languages will still be returned if they are highly relevant.',
                                'fields' => [
                                    'regionCode' => [
                                        'label' => 'Region',
                                        'description' => 'A <code>ISO 3166-1 alpha-2</code> country code.',
                                    ],
                                    'relevanceLanguage' => [
                                        'label' => 'Language',
                                        'description' => 'A <code>ISO 639-1 two-letter</code> language code.',
                                    ],
                                ]
                            ],
                            '_definition_duration' => [
                                'type' => 'grid',
                                'width' => '1-2',
                                'description' => 'The resolution definition and duration of videos to retrieve.',
                                'fields' => [
                                    'videoDefinition' => [
                                        'label' => 'Definition',
                                        'type' => 'select',
                                        'default' => 'any',
                                        'options' => [
                                            'Any' => 'any',
                                            'High (HD)' => 'high',
                                            'Standard (SD)' => 'standard',
                                        ]
                                    ],
                                    'videoDuration' => [
                                        'label' => 'Duration',
                                        'type' => 'select',
                                        'default' => 'any',
                                        'options' => [
                                            'Any' => 'any',
                                            'Longer than 20m' => 'long',
                                            'Between 4 and 20m' => 'medium',
                                            'Shorter than 4m' => 'short'
                                        ]
                                    ]
                                ]
                            ],
                            'channelId' => [
                                'label' => 'Channel',
                                'description' => 'Limit the videos to those created by a specific channel id.',
                            ],
                            '_offset' => [
                                'description' => 'The starting point and the maximum amount of videos to retrieve.',
                                'type' => 'grid',
                                'width' => '1-2',
                                'fields' => [
                                    'offset' => [
                                        'label' => 'Start',
                                        'type' => 'yooessentials-number',
                                        'default' => 0,
                                        'modifier' => 1,
                                        'attrs' => [
                                            'min' => 1
                                        ],
                                    ],
                                    'maxResults' => [
                                        'label' => 'Quantity',
                                        'type' => 'yooessentials-number',
                                        'default' => self::DEFAULT_MAX_RESULTS,
                                        'attrs' => [
                                            'min' => 1,
                                            'max' => 50,
                                        ]
                                    ],
                                ],
                            ],
                            'order' => [
                                'label' => 'Order',
                                'type' => 'select',
                                'default' => 'relevance',
                                'options' => [
                                    'Relevance' => 'relevance',
                                    'Rating Descendant' => 'rating',
                                    'Created Date Reversed' => 'date',
                                    'Title Alphabetical' => 'title',
                                    'View Count Descendant' => 'viewCount',
                                ]
                            ],
                            'cache' => [
                                'type' => 'yooessentials-number',
                                'label' => 'Cache Time',
                                'description' => 'The duration in seconds before the cache is renewed. Set to <code>0</code> to disable caching.',
                                'attrs' => [
                                    'min' => 0,
                                    'max' => 86400 * 30,
                                    'step' => 3600,
                                    'placeholder' => static::DEFAULT_CACHE_TIME
                                ]
                            ]
                        ]
                    ],

                    'extensions' => [
                        'call' => [
                            'func' => __CLASS__.'::resolve',
                            'args' => [
                                'source_id' => $this->source->id(),
                            ]
                        ]
                    ],

                ],

            ],

        ];
    }

    public static function resolve($root, array $args)
    {
        $source = self::loadSource($args, YouTubeSource::class);

        if (!$source) {
            return [];
        }

        try {
            return self::resolveFromCache($source, $args, function () use ($source, $args) {
                $offset = $args['offset'] ?? 0;
                $filter = array_filter(Arr::pick($args, ['channelId', 'location', 'locationRadius', 'order', 'maxResults', 'publishedAfter', 'publishedBefore', 'q', 'regionCode', 'relevanceLanguage', 'videoDuration', 'videoDefinition']));

                $filter['type'] = 'video';
                $filter['videoSyndicated'] = true;
                $filter['maxResults'] = $offset + $args['maxResults'];
                $filter['q'] = str_replace('|', '%7C', $filter['q'] ?? '');

                $result = (array) $source->api()->searchVideos($filter);

                return array_splice($result, $offset);
            });
        } catch (\Exception $e) {
            Event::emit('yooessentials.error', [
                'addon' => 'source',
                'action' => 'source-youtube-video-resolve',
                'args' => $args,
                'error' => $e->getMessage(),
                'exception' => $e
            ]);
        }

        return [];
    }
}
