<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\TikTok\Type;

use ZOOlanders\YOOessentials\Source\GraphQL\TypeInterface;
use ZOOlanders\YOOessentials\Util;

class TikTokVideoType implements TypeInterface
{
    public const TYPE_NAME = 'TikTokVideo';
    public const TYPE_LABEL = 'TikTok Video';

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
                'video_description' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Description',
                        'filters' => ['limit'],
                    ],
                ],
                'cover_image_url' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Cover',
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::resolveCover',
                    ],
                ],
                'embed_link' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Embed Link',
                    ],
                ],
                'embed_html' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Embed HTML',
                    ],
                ],
                'like_count' => [
                    'type' => 'Int',
                    'metadata' => [
                        'label' => 'Like Count',
                    ],
                ],
                'comment_count' => [
                    'type' => 'Int',
                    'metadata' => [
                        'label' => 'Comment Count',
                    ],
                ],
                'view_count' => [
                    'type' => 'Int',
                    'metadata' => [
                        'label' => 'View Count',
                    ],
                ],
                'share_url' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Share URL',
                    ],
                ],
                'share_count' => [
                    'type' => 'Int',
                    'metadata' => [
                        'label' => 'Share Count',
                    ],
                ],
                'create_time' => [
                    'type' => 'Int',
                    'metadata' => [
                        'label' => 'Created',
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

    public static function resolveCover(array $video): string
    {
        $id = $video['id'] ?? '';
        $url = $video['cover_image_url'] ?? '';

        if (!$url || !$id) {
            return '';
        }

        return Util\File::cacheMedia($url, "tiktok-media-$id");
    }
}
