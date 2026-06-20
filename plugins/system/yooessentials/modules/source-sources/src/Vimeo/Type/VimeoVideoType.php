<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Vimeo\Type;

use function YOOtheme\app;
use YOOtheme\Arr;
use YOOtheme\Path;
use YOOtheme\View;
use ZOOlanders\YOOessentials\Source\GraphQL\TypeInterface;
use ZOOlanders\YOOessentials\Util;

class VimeoVideoType implements TypeInterface
{
    public const TYPE_NAME = 'VimeoVideo';
    public const TYPE_LABEL = 'Vimeo Video';

    public const FIELDS = ['name', 'description', 'resource_key', 'type', 'pictures.base_link', 'link', 'custom_url', 'stats.plays', 'created_time', 'release_time', 'modified_time', 'duration', 'height', 'width', 'language', 'license', 'metadata.connections.likes.total', 'metadata.connections.comments.total'];

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
                'name' => [
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
                'type' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Type'
                    ],
                ],
                'link' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Link',
                    ],
                ],
                'custom_url' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Custom URL'
                    ],
                ],
                'thumbnail' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Thumbnail',
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::resolveThumbnail',
                    ],
                ],
                'plays_count' => [
                    'type' => 'Int',
                    'metadata' => [
                        'label' => 'Total Plays',
                    ],
                    'extensions' => [
                        'call' => [
                            'func' => __CLASS__ . '::resolveProp',
                            'args' => [
                                'path' => 'stats.plays'
                            ]
                        ]
                    ],
                ],
                'likes_count' => [
                    'type' => 'Int',
                    'metadata' => [
                        'label' => 'Total Likes',
                    ],
                    'extensions' => [
                        'call' => [
                            'func' => __CLASS__ . '::resolveProp',
                            'args' => [
                                'path' => 'metadata.connections.likes.total'
                            ]
                        ]
                    ],
                ],
                'comments_count' => [
                    'type' => 'Int',
                    'metadata' => [
                        'label' => 'Total Comments',
                    ],
                    'extensions' => [
                        'call' => [
                            'func' => __CLASS__ . '::resolveProp',
                            'args' => [
                                'path' => 'metadata.connections.comments.total'
                            ]
                        ]
                    ],
                ],
                'created_time' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Created',
                        'filters' => ['date'],
                    ],
                ],
                'release_time' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Released',
                        'filters' => ['date'],
                    ],
                ],
                'modified_time' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Modified',
                        'filters' => ['date'],
                    ],
                ],
                'duration' => [
                    'type' => 'Int',
                    'metadata' => [
                        'label' => 'Duration (sec)',
                    ],
                ],
                'height' => [
                    'type' => 'Int',
                    'metadata' => [
                        'label' => 'Height',
                    ],
                ],
                'width' => [
                    'type' => 'Int',
                    'metadata' => [
                        'label' => 'Width',
                    ],
                ],
                'language' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Primary language',
                    ],
                ],
                'license' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'License',
                    ],
                ],
                'categoriesString' => [
                    'type' => 'String',
                    'args' => [
                        'separator' => [
                            'type' => 'String',
                        ],
                        'show_link' => [
                            'type' => 'Boolean',
                        ],
                        'link_style' => [
                            'type' => 'String',
                        ],
                    ],
                    'metadata' => [
                        'label' => 'Categories',
                        'arguments' => [
                            'separator' => [
                                'label' => 'Separator',
                                'description' => 'Set the separator between.',
                                'default' => ', ',
                            ],
                            'show_link' => [
                                'label' => 'Link',
                                'type' => 'checkbox',
                                'default' => true,
                                'text' => 'Show link',
                            ],
                            'link_style' => [
                                'label' => 'Link Style',
                                'description' => 'Set the link style.',
                                'type' => 'select',
                                'default' => '',
                                'options' => [
                                    'Default' => '',
                                    'Muted' => 'link-muted',
                                    'Text' => 'link-text',
                                    'Heading' => 'link-heading',
                                    'Reset' => 'link-reset',
                                ],
                                'enable' => 'arguments.show_link',
                            ],
                        ],
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::resolveCategoriesString'
                    ],
                ],
                'tagsString' => [
                    'type' => 'String',
                    'args' => [
                        'separator' => [
                            'type' => 'String',
                        ]
                    ],
                    'metadata' => [
                        'label' => 'Tags',
                        'arguments' => [
                            'separator' => [
                                'label' => 'Separator',
                                'description' => 'Set the separator between.',
                                'default' => ', ',
                            ]
                        ],
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::resolveTagsString'
                    ],
                ],
                'user' => [
                    'type' => 'VimeoUser',
                    'metadata' => [
                        'label' => 'Author',
                    ],
                ],
                'categories' => [
                    'type' => [
                        'listOf' => 'VimeoCategory',
                    ],
                    'metadata' => [
                        'label' => 'Categories',
                    ],
                ],
                'tags' => [
                    'type' => [
                        'listOf' => 'VimeoTag',
                    ],
                    'metadata' => [
                        'label' => 'Tags',
                    ],
                ],
                'resource_key' => [
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

    public static function fields()
    {
        return implode(',', array_merge(
            self::FIELDS,
            preg_filter('/^/', 'tags.', VimeoTagType::FIELDS),
            preg_filter('/^/', 'user.', VimeoUserType::FIELDS),
            preg_filter('/^/', 'categories.', VimeoCategoryType::FIELDS)
        ));
    }

    public static function resolveProp(array $video, array $args)
    {
        return Arr::get($video, $args['path']);
    }

    public static function resolveCategoriesString(array $video, array $args)
    {
        $items = $video['categories'];
        $args += ['separator' => ', ', 'show_link' => true, 'link_style' => ''];

        return app(View::class)->render(Path::get('./templates/list'), compact('items', 'args'));
    }

    public static function resolveTagsString(array $video, array $args)
    {
        $items = $video['tags'];
        $args += ['separator' => ', '];

        return app(View::class)->render(Path::get('./templates/list'), compact('items', 'args'));
    }

    public static function resolveThumbnail(array $video): string
    {
        $id = $video['resource_key'] ?? '';
        $url = Arr::get($video, 'pictures.base_link');

        if (!$url || !$id) {
            return '';
        }

        return Util\File::cacheMedia($url, "vimeo-media-$id");
    }
}
