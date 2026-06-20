<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Instagram\Type;

use YOOtheme\Str;
use ZOOlanders\YOOessentials\Api\Instagram\InstagramMediaTypes;
use ZOOlanders\YOOessentials\Source\GraphQL\TypeInterface;
use ZOOlanders\YOOessentials\Util;

class InstagramMediaType implements TypeInterface
{
    public const TYPE_NAME = 'InstagramMedia';
    public const TYPE_LABEL = 'Instagram Media';

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
                'id' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'ID',
                    ],
                ],
                'media_type' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Media Type',
                    ],
                ],
                'media_url_raw' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Media URL',
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::mediaUrl',
                    ],
                ],
                'media_url' => [ // keeping media_url name for historic reason
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Media Thumbnail URL',
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::mediaThumbnail',
                    ],
                ],
                'caption' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Caption',
                        'filters' => ['limit'],
                    ],
                ],
                'permalink' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Permalink',
                    ],
                ],
                'hashtags' => [
                    'type' => [
                        'listOf' => 'String',
                    ],
                    'metadata' => [
                        'label' => 'Hashtags',
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::tags',
                    ],
                ],
                'hashtags_list' => [
                    'type' => 'String',
                    'args' => [
                        'separator' => [
                            'type' => 'String',
                        ]
                    ],
                    'metadata' => [
                        'label' => 'Hashtags',
                        'arguments' => [

                            'separator' => [
                                'label' => 'Separator',
                                'description' => 'Set the separator between hashtags.',
                                'default' => ', ',
                            ]

                        ],
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::tagString',
                    ],
                ],
                'timestamp' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Timestamp',
                        'filters' => ['date'],
                    ],
                ],
                'username' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Username',
                    ],
                ],
                'children' => [
                    'type' => [
                        'listOf' => InstagramAlbumMediaType::TYPE_NAME,
                    ],
                    'metadata' => [
                        'label' => 'Children',
                    ]
                ],
            ],

            'metadata' => [
                'type' => true,
                'label' => $this->label(),
            ],

        ];
    }

    public static function mediaUrl($media)
    {
        return self::cacheMedia($media, 'media_url');
    }

    public static function mediaThumbnail($media)
    {
        $type = $media['media_type'] ?? '';

        if ($type === InstagramMediaTypes::TYPE_VIDEO) {
            return self::cacheMedia($media, 'thumbnail_url');
        }

        return self::mediaUrl($media);
    }

    public static function tags($media)
    {
        preg_match_all('/#([^ ]+)/', $media['caption'] ?? '', $matches);

        return $matches[0] ?: [];
    }

    public static function tagString($media, array $args)
    {
        $tags = static::tags($media);
        $args += ['separator' => ', '];

        return implode($args['separator'], $tags);
    }

    protected static function cacheMedia(array $media, string $key = 'media_url')
    {
        $url = $media[$key] ?? '';

        if (!$url) {
            return '';
        }

        $id = $media['id'] ?? '';
        $type = Str::lower($media['media_type'] ?? 'image');

        if (Str::startsWith($type, 'carousel')) {
            $type = 'album';
        }

        $cacheKey = "ig-media-$type-$id";

        return Util\File::cacheMedia($url, $cacheKey);
    }
}
