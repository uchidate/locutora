<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Vimeo\Type;

use ZOOlanders\YOOessentials\Source\GraphQL\AbstractQueryType;
use ZOOlanders\YOOessentials\Source\GraphQL\HasSourceInterface;
use ZOOlanders\YOOessentials\Source\Resolver\CachesResolvedData;
use ZOOlanders\YOOessentials\Source\Resolver\LoadsSourceFromArgs;
use ZOOlanders\YOOessentials\Sources\Vimeo\VimeoSource;

class VimeoMyShowcaseVideosQueryType extends AbstractQueryType implements HasSourceInterface
{
    use LoadsSourceFromArgs, CachesResolvedData;

    public function name(): string
    {
        return "vimeoMyShowcaseVideos_{$this->source()->id()}_query";
    }

    public function label(): string
    {
        return "{$this->source()->name()} My Showcase Videos";
    }

    public static function getCacheKey(): string
    {
        return 'vimeo-my-showcase-videos';
    }

    public function config(): array
    {
        return [

            'fields' => [

                $this->name() => [

                    'type' => [
                        'listOf' => VimeoVideoType::TYPE_NAME
                    ],

                    'args' => [

                        'id' => [
                            'type' => 'String',
                        ],
                        'password' => [
                            'type' => 'String',
                        ],
                        // 'filter' => [
                        //     'type' => 'String',
                        // ],
                        // 'filter_tag' => [
                        //     'type' => 'String',
                        // ],
                        'query' => [
                            'type' => 'String',
                        ],
                        'sort' => [
                            'type' => 'String',
                        ],
                        'direction' => [
                            'type' => 'String',
                        ],
                        'page' => [
                            'type' => 'Int',
                        ],
                        'per_page' => [
                            'type' => 'Int',
                        ],
                        'cache' => [
                            'type' => 'Int'
                        ]

                    ],

                    'metadata' => [
                        'group' => 'Vimeo',
                        'label' => $this->label(),
                        'fields' => [

                            'id' => [
                                'label' => 'Showcase ID',
                                'description' => 'Set the ID of the showcase from which to fetch the videos.',
                            ],

                            'password' => [
                                'label' => 'Password',
                                'description' => 'The password of the showcase.',
                            ],

                            // 'filter' => [
                            //     'label' => 'Filter',
                            //     'type' => 'select',
                            //     'description' => 'The attribute by which to filter the results.',
                            //     'default' => '',
                            //     'options' => [
                            //         'None' => '',
                            //         'Embeddable' => 'embeddable',
                            //     ]
                            // ],

                            // 'filter_tag' => [
                            //     'label' => 'Filter Tag',
                            //     'description' => 'A comma-separated list of tags to filter on.'
                            // ],

                            'query' => [
                                'label' => 'Query',
                                'description' => 'The search query to use to filter the results.',
                            ],

                            '_sort' => [
                                'description' => 'Set the sort and direction of videos.',
                                'type' => 'grid',
                                'width' => '1-2',
                                'fields' => [
                                    'sort' => [
                                        'label' => 'Sort',
                                        'type' => 'select',
                                        'default' => 'manual',
                                        'options' => [
                                            'Default' => 'manual',
                                            'Alphabetical' => 'alphabetical',
                                            'Comments' => 'comments',
                                            'Date' => 'date',
                                            'Modified' => 'modified_time',
                                            'Duration' => 'duration',
                                            'Total Plays' => 'plays',
                                            'Total Likes' => 'likes',
                                        ]
                                    ],
                                    'direction' => [
                                        'label' => 'Direction',
                                        'type' => 'select',
                                        'default' => 'desc',
                                        'options' => [
                                            'Ascending' => 'asc',
                                            'Descending' => 'desc',
                                        ]
                                    ],
                                ]
                            ],

                            '_pagination' => [
                                'description' => 'Set the page and the number of videos per page.',
                                'type' => 'grid',
                                'width' => '1-2',
                                'fields' => [
                                    'page' => [
                                        'label' => 'Page',
                                        'type' => 'yooessentials-number',
                                        'default' => 1,
                                        'attrs' => [
                                            'min' => 1,
                                            'placeholder' => 1
                                        ],
                                    ],
                                    'per_page' => [
                                        'label' => 'Per Page',
                                        'type' => 'yooessentials-number',
                                        'default' => 25,
                                        'attrs' => [
                                            'min' => 1,
                                            'max' => 100,
                                            'placeholder' => 25
                                        ],
                                    ],
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
        $source = self::loadSource($args, VimeoSource::class);
        $showcaseId = $args['id'] ?? null;

        if (!$source || !$showcaseId) {
            return [];
        }

        $videos = self::resolveFromCache($source, $args, function () use ($source, $showcaseId, $args) {
            $args['fields'] = VimeoVideoType::fields();

            return (array) $source->api()->myShowcaseVideos($showcaseId, $args);
        });

        return $videos;
    }
}
