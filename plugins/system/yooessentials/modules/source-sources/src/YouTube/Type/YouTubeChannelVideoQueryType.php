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
use ZOOlanders\YOOessentials\Sources\YouTube\YouTubeChannelSource;
use ZOOlanders\YOOessentials\Sources\YouTube\YouTubeController;

class YouTubeChannelVideoQueryType extends AbstractQueryType implements HasSourceInterface
{
    use LoadsSourceFromArgs, CachesResolvedData;

    public const MIN_CACHE_TIME = 3600;

    public function name(): string
    {
        $id = $this->source->id();

        return "youtubeChannelVideo_{$id}_query";
    }

    public function label(): string
    {
        return "{$this->source()->name()} Video";
    }

    public static function getCacheKey(): string
    {
        return 'youtube-channel-video';
    }

    public function config(): array
    {
        return [

            'fields' => [

                $this->name() => [

                    'type' => YouTubeVideoType::TYPE_NAME,

                    'args' => [
                        'video_id' => [
                            'type' => 'String',
                        ],
                        'cache' => [
                            'type' => 'Int'
                        ]
                    ],

                    'metadata' => [
                        'group' => 'YouTube',
                        'label' => $this->label(),
                        'fields' => [

                            'video_id' => [
                                'label' => 'Video',
                                'type' => 'yooessentials-select-dropdown-async',
                                'description' => 'The ID of the specific Video to load.',
                                'endpoint' => YouTubeController::GET_VIDEOS_ENDPOINT,
                                'params' => [
                                    'source_id' => $this->source->id(),
                                ]
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
        $videoId = $args['video_id'] ?? null;
        $source = self::loadSource($args, YouTubeChannelSource::class);

        if (!$videoId || !$source) {
            return;
        }

        try {
            return self::resolveFromCache($source, $args, function () use ($source, $args, $videoId) {
                return $source->api()->videos([$videoId])[0] ?? null;
            });
        } catch (\Exception $e) {
            Event::emit('yooessentials.error', [
                'addon' => 'source',
                'action' => 'source-youtube-channel-video-resolve',
                'args' => $args,
                'error' => $e->getMessage(),
                'exception' => $e
            ]);
        }

        return;
    }
}
