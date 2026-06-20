<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\GoogleMyBusiness\Type;

use YOOtheme\Event;
use ZOOlanders\YOOessentials\Source\GraphQL\AbstractQueryType;
use ZOOlanders\YOOessentials\Source\GraphQL\HasSourceInterface;
use ZOOlanders\YOOessentials\Source\Resolver\CachesResolvedData;
use ZOOlanders\YOOessentials\Source\Resolver\LoadsSourceFromArgs;
use ZOOlanders\YOOessentials\Sources\GoogleMyBusiness\GoogleMyBusinessSource;

class GoogleMyBusinessLocationQuery extends AbstractQueryType implements HasSourceInterface
{
    use CachesResolvedData, LoadsSourceFromArgs;

    public function name(): string
    {
        $id = $this->source()->id();

        return "googleMyBusinessLocation_{$id}_query";
    }

    public function config(): array
    {
        return [

            'fields' => [

                $this->name() => [
                    'type' => GoogleMyBusinessLocation::TYPE_NAME,

                    'args' => [
                        'cache' => [
                            'type' => 'Int'
                        ],
                    ],

                    'metadata' => [
                        'group' => 'Google MyBusiness',
                        'label' => $this->label() . ' - Location',
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
                            ],
                        ],
                    ],

                    'extensions' => [
                        'call' => [
                            'func' => static::class . '::resolve',
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
        $source = self::loadSource($args, GoogleMyBusinessSource::class);
        if (!$source || !$source->location) {
            return [];
        }

        try {
            return self::resolveFromCache($source, $args, function () use ($source) {
                $location = (array) $source->api()->location($source->location)->toSimpleObject();

                // TODO: remove this and write an update script to use advanced source dynamic queries and a dedicated query for these infos.
                $location['totalReviewCount'] = $source->api()->totalReviewCount($source->businessAccount . '/' . $source->location);
                $location['averageRating'] = $source->api()->averageReviewRating($source->businessAccount . '/' . $source->location);

                return $location;
            });
        } catch (\Exception $e) {
            Event::emit('yooessentials.error', [
                'addon' => 'source',
                'action' => 'source-google-my-business-location-resolve',
                'args' => $args,
                'error' => $e->getMessage(),
                'exception' => $e
            ]);
        }

        return [];
    }

    public static function getCacheKey(): string
    {
        return 'google-my-business-location';
    }
}
