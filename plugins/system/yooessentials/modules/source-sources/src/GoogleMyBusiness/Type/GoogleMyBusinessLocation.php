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
use ZOOlanders\YOOessentials\Source\Resolver\CachesResolvedData;
use ZOOlanders\YOOessentials\Source\Resolver\LoadsSourceFromArgs;

class GoogleMyBusinessLocation extends AbstractObjectType implements HasSourceInterface
{
    use LoadsSourceFromArgs, CachesResolvedData;

    public const TYPE_NAME = 'GoogleMyBusinessLocation';

    public function name(): string
    {
        return self::TYPE_NAME;
    }

    public function config(): array
    {
        return [
            'fields' => [
                'title' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Title',
                    ]
                ],
                'primaryPhone' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Primary Phone',
                    ],
                    'extensions' => [
                        'call' => [
                            'func' => static::class . '::resolvePhone',
                            'args' => []
                        ]
                    ]
                ],
                'additionalPhones' => [
                    'type' => ['listOf' => 'String'],
                    'metadata' => [
                        'label' => 'Additional Phones',
                    ],
                    'extensions' => [
                        'call' => [
                            'func' => static::class . '::resolvePhones',
                            'args' => []
                        ]
                    ]
                ],
                'primaryCategory' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Primary Category',
                    ],
                    'extensions' => [
                        'call' => [
                            'func' => static::class . '::resolveCategory',
                            'args' => []
                        ]
                    ]
                ],
                'additionalCategories' => [
                    'type' => ['listOf' => 'String'],
                    'metadata' => [
                        'label' => 'Additional Categories',
                    ],
                    'extensions' => [
                        'call' => [
                            'func' => static::class . '::resolveCategories',
                            'args' => []
                        ]
                    ]
                ],
                'websiteUri' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Website Url',
                    ]
                ],
                'labels' => [
                    'type' => ['listOf' => 'String'],
                    'metadata' => [
                        'label' => 'Labels',
                    ],
                ],
                'labels_string' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Labels',
                    ],
                    'extensions' => [
                        'call' => [
                            'func' => static::class . '::resolveLabels',
                            'args' => []
                        ]
                    ]
                ],
                'languageCode' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Language Code',
                    ]
                ],
                'storeCode' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Store Code',
                    ]
                ],
                'coordinates' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Coordinates',
                    ],
                    'extensions' => [
                        'call' => static::class . '::resolveCoordinates'
                    ]
                ],
                'latitude' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Latitude',
                    ],
                    'extensions' => [
                        'call' => static::class . '::resolveLatitude'
                    ]
                ],
                'longitude' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Longitude',
                    ],
                    'extensions' => [
                        'call' => static::class . '::resolveLongitude'
                    ]
                ],
                'storefrontAddress' => [
                    'type' => GoogleMyBusinessStoreAddress::TYPE_NAME,
                    'metadata' => [
                        'label' => 'Address',
                    ],
                ],
                'reviewsUri' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Reviews Uri',
                    ],
                    'extensions' => [
                        'call' => [
                            'func' => static::class . '::resolveReviewsUri'
                        ]
                    ]
                ],
                'newReviewUri' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Leave a Review URI',
                    ],
                    'extensions' => [
                        'call' => static::class . '::resolveNewReviewUri'
                    ]
                ],
                'totalReviewCount' => [
                    'type' => 'Int',
                    'metadata' => [
                        'label' => 'Total Reviews Count',
                    ]
                ],
                'averageRating' => [
                    'type' => 'Float',
                    'metadata' => [
                        'label' => 'Average Rating',
                    ]
                ],
                'placeId' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Google Maps Place ID',
                    ],
                    'extensions' => [
                        'call' => static::class . '::resolvePlaceId'
                    ]
                ],
                'mapsUri' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Google Maps URI',
                    ],
                    'extensions' => [
                        'call' => static::class . '::resolveMapsUri'
                    ]
                ],
                'name' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'ID',
                    ]
                ],
                'regularHours' => [
                    'type' => ['listOf' => GoogleMyBusinessPeriod::TYPE_NAME],
                    'metadata' => [
                        'label' => 'Business Hours',
                    ],
                    'extensions' => [
                        'call' => [
                            'func' => static::class . '::resolveRegularHours'
                        ]
                    ]
                ],
                'specialHours' => [
                    'type' => ['listOf' => GoogleMyBusinessPeriod::TYPE_NAME],
                    'metadata' => [
                        'label' => 'Special Hours',
                    ],
                    'extensions' => [
                        'call' => [
                            'func' => static::class . '::resolveSpecialHours'
                        ]
                    ]
                ]
            ],
            'metadata' => [
                'type' => true,
                'label' => 'Location',
            ],
        ];
    }

    public static function resolveCoordinates(array $location): ?string
    {
        return self::resolveLatitude($location) . ',' . self::resolveLongitude($location);
    }

    public static function resolveLatitude(array $location): ?string
    {
        return $location['latlng']->latitude ?? null;
    }

    public static function resolveLongitude(array $location): ?string
    {
        return $location['latlng']->longitude ?? null;
    }

    public static function resolvePhone(array $location): ?string
    {
        return $location['phoneNumbers']->phoneNumbers ?? null;
    }

    public static function resolvePhones(array $location): array
    {
        return $location['phoneNumbers']->additionalPhones ?? [];
    }

    public static function resolveCategory(array $location): ?string
    {
        $primaryCategory = $location['categories']->primaryCategory;
        if (!$primaryCategory) {
            return null;
        }

        return $primaryCategory->displayName ?? null;
    }

    public static function resolveCategories(array $location): array
    {
        $categories = $location['categories']->additionalCategories;
        if (!$categories) {
            return [];
        }

        return array_filter(array_map(function ($category) {
            return $category->displayName ?? null;
        }, $categories));
    }

    public static function resolveLabels(array $location): ?string
    {
        return implode(', ', $location['labels'] ?? []);
    }

    public static function resolvePlaceId(array $location): string
    {
        return $location['metadata']->placeId ?? '';
    }

    public static function resolveMapsUri(array $location): string
    {
        return $location['metadata']->mapsUri ?? '';
    }

    public static function resolveReviewsUri(array $location): string
    {
        $placeId = self::resolvePlaceId($location);

        return "https://search.google.com/local/reviews?placeid=$placeId";
    }

    public static function resolveNewReviewUri(array $location): string
    {
        return $location['metadata']->newReviewUri ?? '';
    }

    public static function resolveRegularHours($location): array
    {
        return $location['regularHours']->periods ?? [];
    }

    public static function resolveSpecialHours($location): array
    {
        return $location['specialHours']->periods ?? [];
    }

    public static function getCacheKey(): string
    {
        return 'google-my-business-location-fields';
    }
}
