<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\CloudflareStream\Type;

use YOOtheme\Event;
use ZOOlanders\YOOessentials\Source\GraphQL\AbstractQueryType;
use ZOOlanders\YOOessentials\Source\GraphQL\HasSourceInterface;
use ZOOlanders\YOOessentials\Source\Resolver\CachesResolvedData;
use ZOOlanders\YOOessentials\Source\Resolver\LoadsSourceFromArgs;

class CloudlfareStreamVideoQueryType extends AbstractQueryType implements HasSourceInterface
{
    use LoadsSourceFromArgs, CachesResolvedData;

    public function name(): string
    {
        return "cloudflareStreamVideo_{$this->source()->id()}_query";
    }

    public function label(): string
    {
        return "{$this->source()->name()} Video";
    }

    public static function getCacheKey(): string
    {
        return 'cloudflare-stream-video';
    }

    public function config(): array
    {
        return [

            'fields' => [

                $this->name() => [

                    'type' => CloudflareStreamVideoType::TYPE_NAME,

                    'args' => [
                        'uid' => [
                            'type' => 'String',
                        ],
                        'cache' => [
                            'type' => 'Int'
                        ],
                    ],

                    'metadata' => [
                        'group' => 'Cloudflare',
                        'label' => $this->label(),
                        'fields' => [

                            'uid' => [
                                'label' => 'Select Manually',
                                'description' => 'Pick a video manually or use filter options to specify which one should be loaded dynamically.',
                                'type' => 'yooessentials-cloudflare-stream',
                                'sourceId' => $this->source()->id()
                            ],

                            'cache' => [
                                'type' => 'yooessentials-number',
                                'label' => 'Cache Time',
                                'description' => 'The duration in seconds before the cache is renewed. Set to <code>0</code> to disable caching.',
                                'attrs' => [
                                    'min' => 0,
                                    'max' => 86400 * 30,
                                    'placeholder' => static::DEFAULT_CACHE_TIME
                                ]
                            ],

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

    public static function resolve($root, array $args)
    {
        $uid = $args['uid'] ?? null;
        $source = self::loadSource($args, CloudflareStreamSource::class);

        if (!$uid or !$source) {
            return [];
        }

        try {
            $stream = self::resolveFromCache($source, $args, function () use ($source, $args) {
                return $source->api()->stream($args['uid']);
            });
        } catch (\Exception $e) {
            Event::emit('yooessentials.error', [
                'addon' => 'source',
                'action' => 'source-cloudflare-stream-video-resolve',
                'args' => $args,
                'error' => $e->getMessage(),
                'exception' => $e
            ]);
        }

        $source->signStream($stream);

        return $stream;
    }
}
