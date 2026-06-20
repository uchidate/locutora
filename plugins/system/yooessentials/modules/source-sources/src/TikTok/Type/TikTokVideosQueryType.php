<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\TikTok\Type;

use ZOOlanders\YOOessentials\Source\GraphQL\AbstractQueryType;
use ZOOlanders\YOOessentials\Source\GraphQL\HasSourceInterface;
use ZOOlanders\YOOessentials\Source\Resolver\CachesResolvedData;
use ZOOlanders\YOOessentials\Source\Resolver\LoadsSourceFromArgs;
use ZOOlanders\YOOessentials\Sources\TikTok\TikTokSource;

class TikTokVideosQueryType extends AbstractQueryType implements HasSourceInterface
{
    use LoadsSourceFromArgs, CachesResolvedData;

    public function name(): string
    {
        return "tiktokVideos_{$this->source()->id()}_query";
    }

    public function label(): string
    {
        return "{$this->source()->name()} Videos";
    }

    public static function getCacheKey(): string
    {
        return 'tiktok-videos';
    }

    public function config(): array
    {
        return [

            'fields' => [

                $this->name() => [

                    'type' => [
                        'listOf' => TikTokVideoType::TYPE_NAME
                    ],

                    'args' => [

                        'cursor' => [
                            'type' => 'String',
                        ],
                        'offset' => [
                            'type' => 'Int',
                        ],
                        'limit' => [
                            'type' => 'Int',
                        ],
                        'cache' => [
                            'type' => 'Int'
                        ]

                    ],

                    'metadata' => [
                        'group' => 'TikTok',
                        'label' => $this->label(),
                        'fields' => [

                            '_offset_limit' => [
                                'description' => 'Set the starting point and limit the number of videos.',
                                'type' => 'grid',
                                'width' => '1-2',
                                'fields' => [
                                    'offset' => [
                                        'label' => 'Start',
                                        'type' => 'yooessentials-number',
                                        'modifier' => 1,
                                        'default' => 0,
                                        'attrs' => [
                                            'min' => 1,
                                            'placeholder' => 1
                                        ],
                                    ],
                                    'limit' => [
                                        'label' => 'Quantity',
                                        'type' => 'yooessentials-number',
                                        'default' => 20,
                                        'attrs' => [
                                            'min' => 1,
                                            'max' => 20,
                                            'placeholder' => TikTokSource::VIDEO_LIMIT_DEFAULT
                                        ],
                                    ],
                                ],
                            ],

                            'cursor' => [
                                'label' => 'Before Than',
                                'description' => 'Fetch videos created before the specified date.',
                                'attrs' => [
                                    'type' => 'date'
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
        $source = self::loadSource($args, TikTokSource::class);

        if (!$source) {
            return [];
        }

        $videos = self::resolveFromCache($source, $args, function () use ($source, $args) {
            return (array) $source->api()->videos([
                'cursor' => isset($args['cursor'])
                    ? self::getTimestamp($args['cursor'])
                    : null
            ]);
        });

        return array_slice($videos, abs($args['offset'] ?? 0), $args['limit'] ?? null);
    }

    protected static function getTimestamp(string $date): int
    {
        return round((new \DateTime($date))->getTimestamp() * 1000);
    }
}
