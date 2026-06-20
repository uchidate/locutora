<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\YouTube\Type;

use YOOtheme\Event;
use ZOOlanders\YOOessentials\Source\GraphQL\AbstractQueryType;
use ZOOlanders\YOOessentials\Source\GraphQL\HasSourceInterface;
use ZOOlanders\YOOessentials\Source\Resolver\CachesResolvedData;
use ZOOlanders\YOOessentials\Source\Resolver\LoadsSourceFromArgs;
use ZOOlanders\YOOessentials\Sources\YouTube\YouTubePlaylistSource;

class YouTubePlaylistVideosQueryType extends AbstractQueryType implements HasSourceInterface
{
    use LoadsSourceFromArgs, CachesResolvedData;

    public const DEFAULT_MAX_RESULTS = 5;
    public const MIN_CACHE_TIME = 3600;

    public function name(): string
    {
        $id = $this->source->config()['id'];

        return "youtubePlaylistVideos_{$id}_query";
    }

    public function label(): string
    {
        return "{$this->source()->name()} Videos";
    }

    public static function getCacheKey(): string
    {
        return 'youtube-playlist-videos';
    }

    public function config(): array
    {
        return [

            'fields' => [

                $this->name() => [

                    'type' => [
                        'listOf' => YouTubeVideoType::TYPE_NAME,
                    ],

                    'args' => [
                        'offset' => [
                            'type' => 'Int',
                        ],
                        'maxResults' => [
                            'type' => 'Int',
                        ],
                        'cache' => [
                            'type' => 'Int'
                        ]
                    ],

                    'metadata' => [
                        'group' => 'YouTube',
                        'label' => $this->label(),
                        'fields' => [
                            '_offset' => [
                                'description' => 'The starting point and the maximum amount of videos to retrieve.',
                                'type' => 'grid',
                                'width' => '1-2',
                                'fields' => [
                                    'offset' => [
                                        'label' => 'Start',
                                        'type' => 'yooessentials-number',
                                        'default' => 0,
                                        'modifier' => 1,
                                        'attrs' => [
                                            'min' => 1
                                        ],
                                    ],
                                    'maxResults' => [
                                        'label' => 'Quantity',
                                        'type' => 'yooessentials-number',
                                        'default' => self::DEFAULT_MAX_RESULTS,
                                        'attrs' => [
                                            'min' => 1,
                                            'max' => 50,
                                        ]
                                    ],
                                ],
                            ],
                            'cache' => [
                                'type' => 'yooessentials-number',
                                'label' => 'Cache Time',
                                'description' => 'The duration in seconds before the cache is renewed, being the minimum allowed ' . self::MIN_CACHE_TIME . '.',
                                'attrs' => [
                                    'min' => self::MIN_CACHE_TIME,
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
        $source = self::loadSource($args, YouTubePlaylistSource::class);

        if (!$source) {
            return [];
        }

        try {
            return self::resolveFromCache($source, $args, function () use ($source, $args) {
                $offset = $args['offset'] ?? 0;
                $maxResults = $offset + $args['maxResults'];

                $result = (array) $source->api()->playlistVideos($source->playlist, compact('maxResults'));

                return array_splice($result, $offset);
            });
        } catch (\Exception $e) {
            Event::emit('yooessentials.error', [
                'addon' => 'source',
                'action' => 'source-youtube-playlist-videos-resolve',
                'args' => $args,
                'error' => $e->getMessage(),
                'exception' => $e
            ]);
        }

        return [];
    }
}
