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
use ZOOlanders\YOOessentials\Source\Resolver\Filters\InMemoryFilter;
use ZOOlanders\YOOessentials\Source\Resolver\HasDynamicArgs;
use ZOOlanders\YOOessentials\Source\Resolver\HasFilterAndOrderFields;
use ZOOlanders\YOOessentials\Source\Resolver\LoadsSourceFromArgs;
use ZOOlanders\YOOessentials\Source\Resolver\QueryMode;
use ZOOlanders\YOOessentials\Source\SourceService;
use ZOOlanders\YOOessentials\Source\Type\DynamicSourceInputType;
use ZOOlanders\YOOessentials\Source\Type\SourceInterface;
use ZOOlanders\YOOessentials\Sources\Rss\RssResolver;
use ZOOlanders\YOOessentials\Sources\Rss\RssSource;
use ZOOlanders\YOOessentials\Util\Arr;

class RssFeedItemsQueryType extends AbstractQueryType implements HasSourceInterface
{
    use HasFilterAndOrderFields, CachesResolvedData, LoadsSourceFromArgs, HasDynamicArgs;

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

    public function label(): string
    {
        return $this->source()->name() . ' Entries';
    }

    public function name(): string
    {
        return $this->rssType->name() . '_items_query';
    }

    public function config(): array
    {
        $args = [
            'source_id' => $this->source->id()
        ];

        if (!$this->source->id()) {
            $args = array_merge($args, $this->source->config());
        }

        $headers = $this->getHeaders();

        return [

            'fields' => [

                $this->name() => [
                    'type' => ['listOf' => $this->rssType->itemType()->name()],

                    'args' => [
                        'offset' => [
                            'type' => 'Int',
                        ],
                        'limit' => [
                            'type' => 'Int',
                        ],
                        'mode' => [
                            'type' => 'String',
                        ],
                        'filters' => [
                            'type' => ['listOf' => DynamicSourceInputType::nameForInputType(RssFilterType::TYPE_NAME)],
                            'defaultValue' => []
                        ],
                        'ordering' => [
                            'type' => ['listOf' => DynamicSourceInputType::nameForInputType(RssOrderingType::TYPE_NAME)],
                            'defaultValue' => []
                        ],
                        'cache' => [
                            'type' => 'Int'
                        ],
                    ],

                    'metadata' => [
                        'group' => 'RSS',
                        'label' => $this->label(),
                        'fields' => [
                            '_filters' => [
                                'label' => 'Filter by Fields',
                                'type' => 'yooessentials-button-panel',
                                'text' => 'Filters',
                                'description' => 'Set conditions to filter the records depending on the content of a field.',
                                'panel' => [
                                    'title' => 'Filters',
                                    'name' => 'yooessentials-csv-source-filter',
                                    'description' => 'Set conditions to filter the records depending on the content of a field.',
                                    'fields' => $this->filterFields(InMemoryFilter::operators(), [
                                        'mode' => [
                                            'label' => 'Mode',
                                            'type' => 'select',
                                            'default' => 'AND',
                                            'enable' => 'filters.length > 1',
                                            'options' => [
                                                'AND' => QueryMode::MODE_AND,
                                                'OR' => QueryMode::MODE_OR,
                                            ]
                                        ],
                                    ], [
                                        'field' => [
                                            'label' => 'Field',
                                            'type' => 'yooessentials-select-dropdown',
                                            'options' => $headers
                                        ]
                                    ])
                                ]
                            ],

                            '_orderings' => [
                                'label' => 'Order by Fields',
                                'type' => 'yooessentials-button-panel',
                                'text' => 'Ordering',
                                'description' => 'Set conditions to order the records depending on the content of a field.',
                                'panel' => [
                                    'title' => 'Ordering',
                                    'name' => 'yooessentials-csv-source-ordering',
                                    'description' => 'Set conditions to order the records depending on the content of a field.',
                                    'fields' => $this->orderingFields([
                                        'field' => [
                                            'label' => 'Field',
                                            'type' => 'yooessentials-select-dropdown',
                                            'options' => $headers
                                        ],
                                    ])
                                ]
                            ],

                            '_offset' => [
                                'description' => 'Set the starting point and limit the number of rows.',
                                'type' => 'grid',
                                'width' => '1-2',
                                'fields' => [
                                    'offset' => [
                                        'label' => 'Start',
                                        'type' => 'yooessentials-number',
                                        'default' => 0,
                                        'modifier' => 1,
                                        'attrs' => [
                                            'min' => 1,
                                            'required' => true,
                                        ],
                                    ],
                                    'limit' => [
                                        'label' => 'Quantity',
                                        'type' => 'limit',
                                        'default' => 10,
                                        'attrs' => [
                                            'min' => 1,
                                        ],
                                    ],
                                ],
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
                return (new RssResolver($source, $args, $root))->resolve();
            });
        } catch (\Exception $e) {
            Event::emit('yooessentials.error', [
                'addon' => 'source',
                'action' => 'source-rss-items-resolve',
                'args' => $args,
                'error' => $e->getMessage(),
                'exception' => $e
            ]);
        }

        return [];
    }

    public static function getCacheKey(): string
    {
        return 'rss-feed-items';
    }

    protected function getHeaders(): array
    {
        $items = $this->source->rss()->items();
        $item = array_shift($items);
        $keys = array_keys($item);
        $headers = [];
        foreach ($keys as $header) {
            $id = SourceService::encodeField($header);
            $name = ExtractsFields::prepareLabel(utf8_encode($header ?? $id)); // make sure to return no empty string utf-8 encoded

            $headers[$name] = $id;
        }

        return $headers;
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
