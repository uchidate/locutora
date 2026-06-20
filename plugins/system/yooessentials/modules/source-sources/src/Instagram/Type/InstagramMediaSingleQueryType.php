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

class InstagramMediaSingleQueryType extends AbstractQueryType implements HasSourceInterface
{
    use LoadsSourceFromArgs, CachesResolvedData;

    public function name(): string
    {
        $id = $this->source()->id();

        return "instagram_single_media_{$id}_query";
    }

    public function label(): string
    {
        return "{$this->source()->name()} Media (single)";
    }

    public static function getCacheKey(): string
    {
        return 'instagram-single-media';
    }

    public function config(): array
    {
        return [

            'fields' => [

                $this->name() => [

                    'type' => InstagramMediaType::TYPE_NAME,

                    'args' => [

                        'id' => [
                            'type' => 'String',
                        ],
                        'cache' => [
                            'type' => 'Int'
                        ]

                    ],

                    'metadata' => [
                        'group' => 'Instagram',
                        'label' => $this->label(),
                        'fields' => [

                            'id' => [
                                'label' => 'ID',
                                'description' => 'The Media ID.',
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

        $id = $args['id'] ?? null;

        if (!$source || !$id) {
            return [];
        }

        return self::resolveFromCache($source, $args, function () use ($source, $args) {
            $media = $source->api()->media($args['id']);
            $media['children'] = $source->api()->children($args['id']);

            return $media;
        });
    }
}
