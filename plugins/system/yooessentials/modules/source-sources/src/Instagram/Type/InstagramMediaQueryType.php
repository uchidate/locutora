<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Instagram\Type;

use ZOOlanders\YOOessentials\Source\GraphQL\AbstractQueryType;
use ZOOlanders\YOOessentials\Source\GraphQL\HasSourceInterface;
use ZOOlanders\YOOessentials\Source\Resolver\CachesResolvedData;
use ZOOlanders\YOOessentials\Source\Resolver\LoadsSourceFromArgs;
use ZOOlanders\YOOessentials\Sources\Instagram\InstagramSource;

class InstagramMediaQueryType extends AbstractQueryType implements HasSourceInterface
{
    use LoadsSourceFromArgs, CachesResolvedData;

    public function name(): string
    {
        $id = $this->source()->id();

        return "instagram_{$id}_query";
    }

    public function label(): string
    {
        return "{$this->source()->name()} Media";
    }

    public static function getCacheKey(): string
    {
        return 'instagram-media';
    }

    public function config(): array
    {
        return [

            'fields' => [

                $this->name() => [

                    'type' => [
                        'listOf' => InstagramMediaType::TYPE_NAME
                    ],

                    'args' => [

                        'limit' => [
                            'type' => 'Int',
                        ],
                        'since' => [
                            'type' => 'String'
                        ],
                        'until' => [
                            'type' => 'String'
                        ],
                        'cache' => [
                            'type' => 'Int'
                        ],
                        'media_type' => [
                            'type' => 'String'
                        ]

                    ],

                    'metadata' => [
                        'group' => 'Instagram',
                        'label' => $this->label(),
                        'fields' => [

                            '_media_filter' => [
                                'type' => 'grid',
                                'description' => 'Choose the type and the maximum amount of media to fetch.',
                                'width' => '1-2',
                                'fields' => [
                                    'media_type' => [
                                        'type' => 'select',
                                        'label' => 'Type',
                                        'default' => 'all',
                                        'options' => [
                                            'All' => 'all',
                                            'Images' => 'images',
                                            'Videos' => 'videos'
                                        ]
                                    ],
                                    'limit' => [
                                        'label' => 'Limit',
                                        'type' => 'yooessentials-number',
                                        'default' => InstagramSource::MEDIA_LIMIT_DEFAULT,
                                    ],
                                ]
                            ],

                            '_datetime_filter' => [
                                'type' => 'grid',
                                'description' => 'Restrict by start and/or end datetime.',
                                'width' => '1-2',
                                'fields' => [
                                    'since' => [
                                        'label' => 'Since',
                                        'type' => 'yooessentials-datetime',
                                        'source' => true,
                                        'small' => true,
                                        'valueFormat' => 'yyyy-MM-dd HH:mm',
                                        'displayFormat' => 'yyyy-MM-dd HH:mm',
                                    ],

                                    'until' => [
                                        'label' => 'Until',
                                        'type' => 'yooessentials-datetime',
                                        'source' => true,
                                        'small' => true,
                                        'valueFormat' => 'yyyy-MM-dd HH:mm',
                                        'displayFormat' => 'yyyy-MM-dd HH:mm',
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
                            'func' => __CLASS__ . '::resolve',
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
        /** @var InstagramSource */
        $source = self::loadSource($args, InstagramSource::class);

        if (!$source) {
            return [];
        }

        return self::resolveFromCache($source, $args, function () use ($source, $args) {
            $limit = $args['limit'] ?? 20;

            return $source->api()->medias($source->auth()->userId(), $limit, $args);
        });
    }
}
