<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\GoogleMyBusiness\Type;

use ZOOlanders\YOOessentials\Source\GraphQL\AbstractObjectType;
use ZOOlanders\YOOessentials\Source\GraphQL\HasSourceInterface;
use ZOOlanders\YOOessentials\Util;
use ZOOlanders\YOOessentials\Vendor\Google_Service_MyBusiness_MediaItem;

class GoogleMyBusinessMedia extends AbstractObjectType implements HasSourceInterface
{
    public const TYPE_NAME = 'GoogleMyBusinessMedia';

    public function name(): string
    {
        return self::TYPE_NAME;
    }

    public function config(): array
    {
        return [
            'fields' => [
                'description' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Description',
                        'filters' => ['limit']
                    ]
                ],
                'createTime' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Updated on',
                        'filters' => ['date']
                    ]
                ],
                'mediaFormat' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Format'
                    ],
                    'extensions' => [
                        'call' => [
                            'func' => static::class . '::resolveMediaFormat',
                            'args' => [

                            ]
                        ]
                    ]
                ],
                'width' => [
                    'type' => 'Int',
                    'metadata' => [
                        'label' => 'Width (px)'
                    ],
                    'extensions' => [
                        'call' => [
                            'func' => static::class . '::resolveWidth',
                            'args' => [

                            ]
                        ]
                    ]
                ],
                'height' => [
                    'type' => 'Int',
                    'metadata' => [
                        'label' => 'Height (px)'
                    ],
                    'extensions' => [
                        'call' => [
                            'func' => static::class . '::resolveHeight',
                            'args' => [

                            ]
                        ]
                    ]
                ],
                'viewCount' => [
                    'type' => 'Int',
                    'metadata' => [
                        'label' => 'View Count'
                    ],
                    'extensions' => [
                        'call' => [
                            'func' => static::class . '::resolveViewCount',
                            'args' => [

                            ]
                        ]
                    ]
                ],

                'googleUrl' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Google Url'
                    ]
                ],
                'thumbnailUrl' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Thumbnail Url'
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::resolveThumbnailUrl',
                    ],
                ],
                'sourceUrl' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Source Url'
                    ]
                ],
                'resourceName' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Resource Name'
                    ],
                    'extensions' => [
                        'call' => [
                            'func' => static::class . '::resolveResourceName',
                            'args' => [

                            ]
                        ]
                    ]
                ],
                'locationAssociation' => [
                    'type' => GoogleMyBusinessMediaLocationAssociation::TYPE_NAME,
                    'metadata' => [
                        'label' => 'Location Association',
                    ]
                ],
                'attribution' => [
                    'type' => GoogleMyBusinessMediaAttribution::TYPE_NAME,
                    'metadata' => [
                        'label' => 'Attribution',
                    ]
                ],
                'name' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Id',
                        'filters' => ['limit']
                    ]
                ],
            ],
            'metadata' => [
                'type' => true,
                'label' => 'Media',
            ],
        ];
    }

    public static function resolveMediaFormat(Google_Service_MyBusiness_MediaItem $media): ?string
    {
        return $media->getMediaFormat();
    }

    public static function resolveWidth(Google_Service_MyBusiness_MediaItem $media): ?int
    {
        if (!$media->getDimensions()) {
            return null;
        }

        return $media->getDimensions()->getWidthPixels();
    }

    public static function resolveHeight(Google_Service_MyBusiness_MediaItem $media): ?int
    {
        if (!$media->getDimensions()) {
            return null;
        }

        return $media->getDimensions()->getHeightPixels();
    }

    public static function resolveViewCount(Google_Service_MyBusiness_MediaItem $media): ?int
    {
        if (!$media->getInsights()) {
            return null;
        }

        return $media->getInsights()->getViewCount();
    }

    public static function resolveResourceName(Google_Service_MyBusiness_MediaItem $media): ?string
    {
        if (!$media->getDataRef()) {
            return null;
        }

        return $media->getDataRef()->getResourceName();
    }

    public static function resolveThumbnailUrl($data): ?string
    {
        $name = $data['name'] ?? '';
        $url = $data['thumbnailUrl'] ?? '';

        return Util\File::cacheMedia($url, "gbp-media-$name");
    }
}
