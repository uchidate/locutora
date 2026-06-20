<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Rss\Type;

use YOOtheme\Event;
use ZOOlanders\YOOessentials\Source\GraphQL\AbstractQueryType;
use ZOOlanders\YOOessentials\Source\GraphQL\HasSourceInterface;
use ZOOlanders\YOOessentials\Source\Resolver\CachesResolvedData;
use ZOOlanders\YOOessentials\Source\Resolver\HasDynamicArgs;
use ZOOlanders\YOOessentials\Source\Resolver\LoadsSourceFromArgs;
use ZOOlanders\YOOessentials\Source\Type\SourceInterface;
use ZOOlanders\YOOessentials\Sources\Rss\RssSource;
use ZOOlanders\YOOessentials\Util\Arr;

class RssFeedQueryType extends AbstractQueryType implements HasSourceInterface
{
    use CachesResolvedData, LoadsSourceFromArgs, HasDynamicArgs;

    /**
     * @var RssFeedType
     */
    private $rssType;

    /**
     * @var RssSource
     */
    protected $source;

    public function __construct(SourceInterface $source, RssFeedType $rssType)
    {
        parent::__construct($source);

        $this->rssType = $rssType;
    }

    public function name(): string
    {
        return $this->rssType->name() . '_query';
    }

    public function config(): array
    {
        $args = [
            'source_id' => $this->source->id()
        ];

        if (!$this->source->id()) {
            $args = array_merge($args, $this->source->config());
        }

        return [

            'fields' => [

                $this->name() => [
                    'type' => $this->rssType->name(),

                    'args' => [

                        'cache' => [
                            'type' => 'Int'
                        ],
                    ],

                    'metadata' => [
                        'group' => 'RSS',
                        'label' => $this->label(),
                        'fields' => [

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

                        ],
                    ],

                    'extensions' => [
                        'call' => [
                            'func' => __CLASS__ . '::resolve',
                            'args' => $args
                        ]
                    ],

                ],

            ],

        ];
    }

    public static function resolve($root, array $args): array
    {
        $source = self::loadSource($args, RssSource::class);
        if (!$source) {
            return [];
        }

        try {
            return self::resolveFromCache($source, $args, function () use ($source, $args, $root) {
                return $source->rss()->toArray();
            });
        } catch (\Exception $e) {
            Event::emit('yooessentials.error', [
                'addon' => 'source',
                'action' => 'source-rss-resolve',
                'args' => $args,
                'error' => $e->getMessage(),
                'exception' => $e
            ]);
        }

        return [];
    }

    public static function getCacheKey(): string
    {
        return 'rss-feed';
    }

    protected static function resolveArgs(array $args, $root): array
    {
        $dynamicArgs = [
            'filters',
            'ordering',
            'orderings'
        ];

        foreach ($dynamicArgs as $arg) {
            $args[$arg] = Arr::map($args[$arg] ?? [], function ($dynamic) use ($root) {
                if (!isset($dynamic['source'])) {
                    return $dynamic;
                }

                return self::resolveDynamicArguments($dynamic, $root);
            });
        }

        return $args;
    }
}
