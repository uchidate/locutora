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
use ZOOlanders\YOOessentials\Sources\GoogleMyBusiness\GoogleMyBusinessController;
use ZOOlanders\YOOessentials\Sources\GoogleMyBusiness\GoogleMyBusinessSource;

class GoogleMyBusinessReviewQuery extends AbstractQueryType implements HasSourceInterface
{
    use LoadsSourceFromArgs, CachesResolvedData;

    public function name(): string
    {
        $id = $this->source()->id();

        return "googleMyBusinessReview_{$id}_query";
    }

    public function config(): array
    {
        return [

            'fields' => [

                $this->name() => [
                    'type' => GoogleMyBusinessReview::TYPE_NAME,

                    'args' => [
                        'review_id' => [
                            'type' => 'String'
                        ],
                        'cache' => [
                            'type' => 'Int'
                        ],
                    ],

                    'metadata' => [
                        'group' => 'Google MyBusiness',
                        'label' => $this->label() . ' - Review',
                        'fields' => [
                            'review_id' => [
                                'label' => 'Review',
                                'type' => 'yooessentials-select-dropdown-async',
                                'description' => 'The specific Review to load.',
                                'endpoint' => GoogleMyBusinessController::GET_REVIEWS_ENDPOINT,
                                'params' => [
                                    'source_id' => $this->source->id(),
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
        if (!($args['review_id'] ?? null)) {
            return [];
        }

        $source = self::loadSource($args, GoogleMyBusinessSource::class);
        if (!$source) {
            return [];
        }

        try {
            return self::resolveFromCache($source, $args, function () use ($source, $args) {
                return (array) $source->api()->review($args['review_id'])->toSimpleObject();
            });
        } catch (\Exception $e) {
            Event::emit('yooessentials.error', [
                'addon' => 'source',
                'action' => 'source-google-my-business-review-resolve',
                'args' => $args,
                'error' => $e->getMessage(),
                'exception' => $e
            ]);
        }

        return [];
    }

    public static function getCacheKey(): string
    {
        return 'google-my-business-review';
    }
}
