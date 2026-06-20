<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\GoogleMyBusiness\Type;

use YOOtheme\Event;
use ZOOlanders\YOOessentials\Source\GraphQL\AbstractQueryType;
use ZOOlanders\YOOessentials\Source\GraphQL\HasSourceInterface;
use ZOOlanders\YOOessentials\Source\Resolver\CachesResolvedData;
use ZOOlanders\YOOessentials\Source\Resolver\LoadsSourceFromArgs;
use ZOOlanders\YOOessentials\Sources\GoogleMyBusiness\GoogleMyBusinessSource;

class GoogleMyBusinessReviewsQuery extends AbstractQueryType implements HasSourceInterface
{
    use LoadsSourceFromArgs, CachesResolvedData;

    public function name(): string
    {
        $id = $this->source()->id();

        return "googleMyBusinessReviews_{$id}_query";
    }

    public function config(): array
    {
        return [

            'fields' => [

                $this->name() => [
                    'type' => ['listOf' => GoogleMyBusinessReview::TYPE_NAME],

                    'args' => [
                        'cache' => [
                            'type' => 'Int'
                        ],
                        'order_by' => [
                            'type' => 'String'
                        ],
                        'limit' => [
                            'type' => 'Int'
                        ],
                    ],

                    'metadata' => [
                        'group' => 'Google MyBusiness',
                        'label' => $this->label() . ' - Reviews',
                        'fields' => [
                            '_offset' => [
                                'description' => 'Set the order and limit the number of reviews.',
                                'type' => 'grid',
                                'width' => '1-2',
                                'fields' => [
                                    'order_by' => [
                                        'label' => 'Order By',
                                        'type' => 'select',
                                        'options' => [
                                            'Rating Ascending' => 'rating',
                                            'Rating Descending' => 'rating desc',
                                            'Latest' => 'update_time desc'
                                        ],
                                        'default' => 'update_time desc'
                                    ],
                                    'limit' => [
                                        'label' => 'Quantity',
                                        'type' => 'limit',
                                        'default' => 10,
                                        'attrs' => [
                                            'min' => 1,
                                        ],
                                    ],
                                ],
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
                            ],
                        ],
                    ],

                    'extensions' => [
                        'call' => [
                            'func' => static::class . '::resolve',
                            'args' => [
                                'source_id' => $this->source->id(),
                            ]
                        ]
                    ],

                ],

            ],

        ];
    }

    public static function resolve($root, array $args): array
    {
        $source = self::loadSource($args, GoogleMyBusinessSource::class);
        if (!$source || !$source->location) {
            return [];
        }

        try {
            return self::resolveFromCache($source, $args, function () use ($source, $args) {
                return $source->api()->reviews($source->businessAccount . '/' . $source->location, [
                    'pageSize' => $args['limit'] ?? 100,
                    'orderBy' => $args['order_by'] ?? 'update_time desc'
                ]);
            });
        } catch (\Exception $e) {
            Event::emit('yooessentials.error', [
                'addon' => 'source',
                'action' => 'source-google-my-business-reviews-resolve',
                'args' => $args,
                'error' => $e->getMessage(),
                'exception' => $e
            ]);
        }

        return [];
    }

    public static function getCacheKey(): string
    {
        return 'google-my-business-reviews';
    }
}
