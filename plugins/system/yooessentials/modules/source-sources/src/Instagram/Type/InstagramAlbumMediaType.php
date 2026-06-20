<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Instagram\Type;

use ZOOlanders\YOOessentials\Source\GraphQL\TypeInterface;

class InstagramAlbumMediaType extends InstagramMediaType
{
    public const TYPE_NAME = 'InstagramAlbumMedia';
    public const TYPE_LABEL = 'Instagram Album Media';

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
                'media_type' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Type',
                    ],
                ],
                'media_url_raw' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Url',
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::mediaUrl',
                    ],
                ],
                'media_url' => [ // keeping media_url name for historic reason
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Thumbnail Url',
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::mediaThumbnail',
                    ],
                ],
                'permalink' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Permalink',
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
                'id' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'ID',
                    ],
                ]
            ],

            'metadata' => [
                'type' => true,
                'label' => $this->label(),
            ],

        ];
    }
}
