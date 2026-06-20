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

class TwitterUserQueryType extends AbstractQueryType implements HasSourceInterface
{
    use LoadsSourceFromArgs, CachesResolvedData;

    public function name(): string
    {
        $id = $this->source()->id();

        return "twitter_{$id}_user_query";
    }

    public function label(): string
    {
        return "{$this->source()->name()} User";
    }

    public static function getCacheKey(): string
    {
        return 'twitter-user';
    }

    public function config(): array
    {
        return [

            'fields' => [

                $this->name() => [

                    'type' => TwitterUserType::TYPE_NAME,

                    'args' => [

                        'cache' => [
                            'type' => 'Int'
                        ],

                    ],

                    'metadata' => [
                        'group' => 'Twitter',
                        'label' => $this->label(),
                        'fields' => [

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

        return self::resolveFromCache($source, $args, function () use ($source, $args) {
            return $source->api()->account();
        });
    }
}
