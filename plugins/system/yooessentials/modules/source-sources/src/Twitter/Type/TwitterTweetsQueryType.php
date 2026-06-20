<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Twitter\Type;

use ZOOlanders\YOOessentials\Source\GraphQL\AbstractQueryType;
use ZOOlanders\YOOessentials\Source\GraphQL\HasSourceInterface;
use ZOOlanders\YOOessentials\Source\Resolver\CachesResolvedData;
use ZOOlanders\YOOessentials\Source\Resolver\LoadsSourceFromArgs;
use ZOOlanders\YOOessentials\Sources\Twitter\TwitterSource;

class TwitterTweetsQueryType extends AbstractQueryType implements HasSourceInterface
{
    use LoadsSourceFromArgs, CachesResolvedData;

    public function name(): string
    {
        $id = $this->source()->id();

        return "twitter_{$id}_tweets_query";
    }

    public function label(): string
    {
        return "{$this->source()->name()} Tweets";
    }

    public static function getCacheKey(): string
    {
        return 'twitter-tweets';
    }

    public function config(): array
    {
        return [

            'fields' => [

                $this->name() => [

                    'type' => [
                        'listOf' => TwitterTweetType::TYPE_NAME
                    ],

                    'args' => [

                        'start_time' => [
                            'type' => 'String'
                        ],

                        'end_time' => [
                            'type' => 'String'
                        ],

                        'limit' => [
                            'type' => 'Int',
                        ],

                        'cache' => [
                            'type' => 'Int'
                        ],

                    ],

                    'metadata' => [
                        'group' => 'Twitter',
                        'label' => $this->label(),
                        'fields' => [

                            '_datetime_filter' => [
                                'type' => 'grid',
                                'description' => 'Restrict the tweets by it start and/or end datetime.',
                                'width' => '1-2',
                                'fields' => [
                                    'start_time' => [
                                        'label' => 'Since',
                                        'type' => 'yooessentials-datetime',
                                        'source' => true,
                                        'small' => true,
                                        'valueFormat' => 'yyyy-MM-dd HH:mm',
                                        'displayFormat' => 'yyyy-MM-dd HH:mm',
                                    ],

                                    'end_time' => [
                                        'label' => 'Until',
                                        'type' => 'yooessentials-datetime',
                                        'source' => true,
                                        'small' => true,
                                        'valueFormat' => 'yyyy-MM-dd HH:mm',
                                        'displayFormat' => 'yyyy-MM-dd HH:mm',
                                    ],
                                ]
                            ],

                            'limit' => [
                                'label' => 'Limit',
                                'type' => 'yooessentials-number',
                                'description' => 'The maximum amount of tweets to fetch.',
                                'default' => TwitterSource::TWEETS_DEFAULT_LIMIT,
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
        /** @var TwitterSource */
        $source = self::loadSource($args, TwitterSource::class);

        if (!$source) {
            return [];
        }

        foreach (['start_time', 'end_time'] as $field) {
            if (isset($args[$field])) {
                $args[$field] = \DateTime::createFromFormat('Y-m-d H:i', $args[$field])->format(DATE_ATOM);
            }
        }

        return self::resolveFromCache($source, $args, function () use ($source, $args) {
            return $source->api()
                ->tweets($source->account(), $args['limit'] ?? null, $args);
        });
    }
}
