<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Facebook\Type;

use ZOOlanders\YOOessentials\Api\Facebook\FacebookApi;
use ZOOlanders\YOOessentials\Source\GraphQL\AbstractQueryType;
use ZOOlanders\YOOessentials\Source\GraphQL\HasSourceInterface;
use ZOOlanders\YOOessentials\Source\Resolver\CachesResolvedData;
use ZOOlanders\YOOessentials\Source\Resolver\LoadsSourceFromArgs;
use ZOOlanders\YOOessentials\Sources\Facebook\FacebookSource;
use ZOOlanders\YOOessentials\Sources\Facebook\HasApiRequest;

class FacebookPagePostsQueryType extends AbstractQueryType implements HasSourceInterface
{
    use LoadsSourceFromArgs, CachesResolvedData, HasApiRequest;

    public function name(): string
    {
        $id = $this->source()->id();

        return "facebook_{$id}_page_posts_query";
    }

    public function label(): string
    {
        return "{$this->source()->name()} Page Posts";
    }

    public static function getCacheKey(): string
    {
        return 'facebook-page-posts';
    }

    public function config(): array
    {
        return [

            'fields' => [

                $this->name() => [

                    'type' => [
                        'listOf' => FacebookPostType::TYPE_NAME
                    ],

                    'args' => [

                        'limit' => [
                            'type' => 'Int',
                        ],
                        'cache' => [
                            'type' => 'Int'
                        ],

                    ],

                    'metadata' => [
                        'group' => 'Facebook',
                        'label' => $this->label(),
                        'fields' => [

                            'limit' => [
                                'label' => 'Limit',
                                'type' => 'yooessentials-number',
                                'default' => FacebookSource::MEDIA_LIMIT_DEFAULT,
                                'attr' => [
                                    'max' => 100
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
        /** @var FacebookSource */
        $source = self::loadSource($args, FacebookSource::class);

        /** @var FacebookApi */
        $api = self::api($source->account());

        if (!$source || !$api) {
            return [];
        }

        return self::resolveFromCache($source, $args, function () use ($source, $api, $args) {
            return $api->posts($source->pageId(), $args['limit'] ?? null);
        });
    }
}
