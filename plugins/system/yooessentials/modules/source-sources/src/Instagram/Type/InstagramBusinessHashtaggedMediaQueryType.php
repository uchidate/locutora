<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Instagram\Type;

use ZOOlanders\YOOessentials\Source\Instagram\InstagramBusinessSource;
use ZOOlanders\YOOessentials\Source\Resolver\CachesResolvedData;
use ZOOlanders\YOOessentials\Source\Resolver\LoadsSourceFromArgs;

class InstagramBusinessHashtaggedMediaQueryType extends InstagramBusinessMediaQueryType
{
    use LoadsSourceFromArgs, CachesResolvedData;

    public const VIDEO_CACHE_TIME_DEFAULT = 3600;

    public function name(): string
    {
        $id = $this->source()->id();

        return "instagramHashtaggedMedia_{$id}_query";
    }

    public function label(): string
    {
        return "{$this->source()->name()} Hashtagged Media";
    }

    public static function getCacheKey(): string
    {
        return 'instagram-hashtagged-media';
    }

    public function config(): array
    {
        return [

            'fields' => [

                $this->name() => [

                    'type' => [
                        'listOf' => InstagramBusinessMediaType::TYPE_NAME
                    ],

                    'args' => [

                        'hashtag' => [
                            'type' => 'String',
                        ],
                        'edge' => [
                            'type' => 'String'
                        ],
                        'cache' => [
                            'type' => 'Int'
                        ],

                    ],

                    'metadata' => [
                        'group' => 'Instagram',
                        'label' => $this->label(),
                        'fields' => [

                            '_media' => [
                                'type' => 'grid',
                                'description' => 'Set the Hashtag and Edge by which to fetch the media. Top Media fetched the most popular Media that have been tagged with the specified hashtag, while the Recent Media fetches the ones tagged in the last 24 hours.',
                                'width' => '1-2',
                                'fields' => [
                                    'hashtag' => [
                                        'label' => 'Hashtag'
                                    ],

                                    'edge' => [
                                        'type' => 'select',
                                        'label' => 'Edge',
                                        'default' => 'top_media',
                                        'options' => [
                                            'Top Media' => 'top_media',
                                            'Recent Media' => 'recent_media'
                                        ]
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
                                'source_id' => $this->source()->id()
                            ]
                        ]
                    ],

                ],

            ],

        ];
    }

    public static function resolve($root, array $args): array
    {
        $hashtag = $args['hashtag'] ?? null;
        $edge = $args['edge'] ?? null;

        /** @var InstagramBusinessSource */
        $source = self::loadSource($args, InstagramBusinessSource::class);

        if (!$hashtag || !$source) {
            return [];
        }

        return self::resolveFromCache($source, $args, function () use ($source, $hashtag, $edge) {
            return $source->api()->mediaByHashtag($source->pageId(), $hashtag, $edge);
        });
    }
}
