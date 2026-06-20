<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\YouTube\Type;

use ZOOlanders\YOOessentials\Source\GraphQL\TypeInterface;

class YouTubeVideoType implements TypeInterface
{
    public const TYPE_NAME = 'YouTubeVideo';
    public const TYPE_LABEL = 'YouTube Video';

    public function type(): string
    {
        return TypeInterface::TYPE_OBJECT;
    }

    public function name(): string
    {
        return self::TYPE_NAME;
    }

    public function label(): string
    {
        return self::TYPE_LABEL;
    }

    public function config(): array
    {
        return [

            'fields' => [
                'title' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Title',
                        'filters' => ['limit'],
                    ],
                ],
                'description' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Description',
                        'filters' => ['limit'],
                    ],
                ],
                'url' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'URL',
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::resolveUrl',
                    ],
                ],
                'publishedAt' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Published At',
                        'filters' => ['date'],
                    ],
                ],
                // 'duration' => [
                //     'type' => 'String',
                //     'metadata' => [
                //         'label' => 'Duration',
                //         'filters' => ['date'],
                //     ],
                // ],
                'viewCount' => [
                    'type' => 'Int',
                    'metadata' => [
                        'label' => 'View Count'
                    ],
                ],
                'commentCount' => [
                    'type' => 'Int',
                    'metadata' => [
                        'label' => 'Comment Count'
                    ],
                ],
                'favoriteCount' => [
                    'type' => 'Int',
                    'metadata' => [
                        'label' => 'Favorite Count'
                    ],
                ],
                'dislikeCount' => [
                    'type' => 'Int',
                    'metadata' => [
                        'label' => 'Dislike Count'
                    ],
                ],
                'thumbnail_url' => [
                    'type' => 'String',
                    'args' => [
                        'size' => [
                            'type' => 'String',
                        ],
                    ],
                    'metadata' => [
                        'label' => 'Thumbnail URL',
                        'arguments' => [
                            'size' => [
                                'label' => 'Size',
                                'type' => 'select',
                                'default' => 'medium',
                                'options' => [
                                    'Low' => 'default',
                                    'Medium' => 'medium',
                                    'High Resolution' => 'high',
                                    'Standard' => 'standard',
                                    'Max Resolution' => 'maxres',
                                ],
                            ]
                        ],
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::resolveThumbnailUrl',
                    ],
                ],
                'thumbnail_width' => [
                    'type' => 'String',
                    'args' => [
                        'size' => [
                            'type' => 'String',
                        ],
                    ],
                    'metadata' => [
                        'label' => 'Thumbnail Width',
                        'arguments' => [
                            'size' => [
                                'label' => 'Size',
                                'type' => 'select',
                                'default' => 'medium',
                                'options' => [
                                    'Low' => 'default',
                                    'Medium' => 'medium',
                                    'High Resolution' => 'high',
                                    'Standard' => 'standard',
                                    'Max Resolution' => 'maxres',
                                ],
                            ]
                        ],
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::resolveThumbnailWidth',
                    ],
                ],
                'thumbnail_height' => [
                    'type' => 'String',
                    'args' => [
                        'size' => [
                            'type' => 'String',
                        ],
                    ],
                    'metadata' => [
                        'label' => 'Thumbnail Height',
                        'arguments' => [
                            'size' => [
                                'label' => 'Size',
                                'type' => 'select',
                                'default' => 'medium',
                                'options' => [
                                    'Low' => 'default',
                                    'Medium' => 'medium',
                                    'High Resolution' => 'high',
                                    'Standard' => 'standard',
                                    'Max Resolution' => 'maxres',
                                ],
                            ]
                        ],
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::resolveThumbnailHeight',
                    ],
                ],
                'id' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'ID',
                    ],
                ],
            ],

            'metadata' => [
                'type' => true,
                'label' => $this->label(),
            ],

        ];
    }

    public static function resolveUrl(array $video)
    {
        return "https://www.youtube.com/watch?v={$video['id']}";
    }

    public static function resolveThumbnailUrl(array $video, array $args): string
    {
        return $video['thumbnails'][$args['size']]['url'] ?? '';
    }

    public static function resolveThumbnailWidth(array $video, array $args): int
    {
        return $video['thumbnails'][$args['size']]['width'] ?? 0;
    }

    public static function resolveThumbnailHeight(array $video, array $args): int
    {
        return $video['thumbnails'][$args['size']]['height'] ?? 0;
    }
}
