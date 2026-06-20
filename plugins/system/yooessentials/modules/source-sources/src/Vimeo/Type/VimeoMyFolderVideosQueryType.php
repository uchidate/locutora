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

class VimeoMyFolderVideosQueryType extends AbstractQueryType implements HasSourceInterface
{
    use LoadsSourceFromArgs, CachesResolvedData;

    public function name(): string
    {
        return "vimeoMyFolderVideos_{$this->source()->id()}_query";
    }

    public function label(): string
    {
        return "{$this->source()->name()} My Folder Videos";
    }

    public static function getCacheKey(): string
    {
        return 'vimeo-my-folder-videos';
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
                        // 'filter' => [
                        //     'type' => 'String',
                        // ],
                        // 'filter_tag' => [
                        //     'type' => 'String',
                        // ],
                        'query' => [
                            'type' => 'String',
                        ],
                        'include_subfolders' => [
                            'type' => 'Boolean',
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
                                'label' => 'Folder ID',
                                'description' => 'Set the ID of the folder from which to fetch the videos.',
                            ],

                            'include_subfolders' => [
                                'text' => 'Include Subfolders',
                                'type' => 'checkbox'
                            ],

                            // 'filter' => [
                            //     'label' => 'Filter',
                            //     'type' => 'select',
                            //     'description' => 'The attribute by which to filter the results.',
                            //     'default' => '',
                            //     'options' => [
                            //         'None' => '',
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
                                        'default' => 'default',
                                        'options' => [
                                            'Default' => 'default',
                                            'Alphabetical' => 'alphabetical',
                                            'Date' => 'date',
                                            'Duration' => 'duration',
                                            'Last User Action' => 'last_user_action_event_date',
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
        $folderId = $args['id'] ?? null;

        if (!$source || !$folderId) {
            return [];
        }

        $videos = self::resolveFromCache($source, $args, function () use ($source, $folderId, $args) {
            $args['fields'] = VimeoVideoType::fields();

            return (array) $source->api()->myFolderVideos($folderId, $args);
        });

        return $videos;
    }
}
