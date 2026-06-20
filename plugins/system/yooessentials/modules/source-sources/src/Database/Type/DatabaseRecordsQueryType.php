<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Database\Type;

use YOOtheme\Str;
use ZOOlanders\YOOessentials\Source\GraphQL\AbstractQueryType;
use ZOOlanders\YOOessentials\Source\GraphQL\HasSourceInterface;
use ZOOlanders\YOOessentials\Source\Resolver\CachesResolvedData;
use ZOOlanders\YOOessentials\Source\Resolver\Filters\DatabaseFilter;
use ZOOlanders\YOOessentials\Source\Resolver\HasDynamicArgs;
use ZOOlanders\YOOessentials\Source\Resolver\HasFilterAndOrderFields;
use ZOOlanders\YOOessentials\Source\Resolver\LoadsSourceFromArgs;
use ZOOlanders\YOOessentials\Source\Type\DynamicSourceInputType;
use ZOOlanders\YOOessentials\Source\Type\SourceInterface;
use ZOOlanders\YOOessentials\Sources\Database\DatabaseSource;
use ZOOlanders\YOOessentials\Sources\Database\Table\DatabaseResolver;
use ZOOlanders\YOOessentials\Sources\Database\Table\Relation;
use ZOOlanders\YOOessentials\Util\Arr;

class DatabaseRecordsQueryType extends AbstractQueryType implements HasSourceInterface
{
    use HasFilterAndOrderFields, CachesResolvedData, LoadsSourceFromArgs, HasDynamicArgs;

    /** @var HasSourceInterface */
    protected $objectType;

    public function __construct(SourceInterface $source, HasSourceInterface $objectType)
    {
        parent::__construct($source);

        $this->objectType = $objectType;
    }

    public function name(): string
    {
        $id = $this->source()->id();

        return "databaseRecords_{$id}_query";
    }

    public function label(): string
    {
        return "{$this->source()->name()} Records";
    }

    public function config(): array
    {
        $args = [
            'source_id' => $this->source->id()
        ];

        if (!$this->source->id()) {
            $args = array_merge($args, $this->source->config());
        }

        $tableOptions = $this->getTableOptions();

        return [
            'fields' => [
                $this->name() => [
                    'type' => ['listOf' => $this->objectType->name()],

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

                        'query' => [
                            'type' => 'String',
                        ],

                        'filters' => [
                            'type' => ['listOf' => DynamicSourceInputType::nameForInputType(DatabaseFilterType::TYPE_NAME)],
                            'defaultValue' => []
                        ],

                        'ordering' => [
                            'type' => ['listOf' => DynamicSourceInputType::nameForInputType(DatabaseOrderingType::TYPE_NAME)],
                            'defaultValue' => []
                        ],

                        'random_order' => [
                            'type' => 'Boolean',
                        ],

                        'cache' => [
                            'type' => 'Int'
                        ],
                    ],

                    'metadata' => [
                        'group' => 'Database',
                        'label' => $this->label(),
                        'fields' => [

                            '_filters' => [
                                'label' => 'Filters',
                                'type' => 'yooessentials-button-panel',
                                'text' => 'Filter by Fields',
                                'description' => 'Set conditions to filter the records depending on the content of a field.',
                                'panel' => [
                                    'title' => 'Filters',
                                    'name' => 'yooessentials-db-source-filter',
                                    'description' => 'Set conditions to filter the records depending on the content of a field.',
                                    'fields' => $this->filterFields(DatabaseFilter::operators(), [
                                        'mode' => [
                                            'label' => 'Mode',
                                            'type' => 'select',
                                            'description' => 'Structure the above filters to form a logic condition. Each filter is represented by it index surrounded by brackets, combine them with <code>AND|OR</code> operators and parenthesis to form more complex conditions.',
                                            'default' => 'AND',
                                            'enable' => 'filters.length > 1',
                                            'options' => [
                                                'AND' => DatabaseResolver::MODE_AND,
                                                'OR' => DatabaseResolver::MODE_OR,
                                                'Custom' => DatabaseResolver::MODE_CUSTOM,
                                            ]
                                        ],

                                        'query' => [
                                            'type' => 'yooessentials-simple-query',
                                            'connection' => 'filters',
                                            'show' => 'filters.length > 1 && mode === "custom"'
                                        ]
                                    ], [
                                        'relation' => [
                                            'label' => 'Table',
                                            'type' => 'select',
                                            'source' => true,
                                            'default' => $this->source()->table(),
                                            'options' => $tableOptions,
                                            'show' => count($tableOptions) > 1
                                        ],
                                        'field' => [
                                            'label' => 'Field',
                                            'type' => 'yooessentials-select-dropdown-async',
                                            'description' => 'The field name which value to evaluate.',
                                            'endpoint' => 'yooessentials/source/database/filter-fields',
                                            'params' => [
                                                'table_field_path' => 'relation',
                                                'source_id' => $this->source->id(),
                                            ]
                                        ],
                                    ])
                                ]
                            ],

                            '_orderings' => [
                                'label' => 'Order',
                                'type' => 'yooessentials-button-panel',
                                'text' => 'Order by Fields',
                                'description' => 'Set conditions to order the records depending on the content of a field.',
                                'enable' => '!random_order',
                                'panel' => [
                                    'title' => 'Ordering',
                                    'name' => 'yooessentials-db-source-ordering',
                                    'description' => 'Set conditions to order the records depending on the content of a field.',
                                    'fields' => $this->orderingFields([
                                        'table' => [
                                            'label' => 'Table',
                                            'type' => 'select',
                                            'default' => $this->source()->table(),
                                            'options' => $tableOptions,
                                            'show' => count($tableOptions) > 1
                                        ],
                                        'field' => [
                                            'label' => 'Field',
                                            'type' => 'yooessentials-select-dropdown-async',
                                            'description' => 'The field name which value to use as ordering.',
                                            'endpoint' => 'yooessentials/source/database/filter-fields',
                                            'params' => [
                                                'table_field_path' => 'table',
                                                'source_id' => $this->source->id(),
                                            ]
                                        ],
                                    ])
                                ]
                            ],

                            'random_order' => [
                                'type' => 'checkbox',
                                'text' => 'Random',
                            ],

                            '_offset_limit' => [
                                'type' => 'grid',
                                'width' => '1-2',
                                'description' => 'Set the starting point and limit the number of records.',
                                'fields' => [
                                    'offset' => [
                                        'label' => 'Start',
                                        'type' => 'yooessentials-number',
                                        'modifier' => 1,
                                        'default' => DatabaseResolver::DEFAULT_OFFSET,
                                        'attrs' => [
                                            'placeholder' => DatabaseResolver::DEFAULT_OFFSET + 1,
                                            'min' => 1
                                        ]
                                    ],

                                    'limit' => [
                                        'label' => 'Quantity',
                                        'type' => 'yooessentials-number',
                                        'default' => DatabaseResolver::DEFAULT_LIMIT,
                                        'attrs' => [
                                            'min' => 0
                                        ]
                                    ],
                                ]
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
                            'args' => $args
                        ]
                    ],

                ],

            ],

        ];
    }

    public static function resolve($root, array $args)
    {
        $source = self::loadSource($args, DatabaseSource::class);
        if (!$source) {
            return [];
        }

        return self::resolveFromCache($source, $args, $root, function () use ($source, $args, $root) {
            return (new DatabaseResolver($source, $args, $root))->resolve();
        });
    }

    protected function getListOfTables(?string $relationType = null): array
    {
        return array_reduce(array_filter((array) $this->source->relations(), function (Relation $relation) use ($relationType) {
            if ($relationType && $relation->type() !== $relationType) {
                return false;
            }

            return $relation;
        }), function ($carry, Relation $relation) {
            $table = $relation->table();
            $name = Str::titleCase(Str::snakeCase($relation->name(), ' '));

            $carry["$name ($table)"] = $relation->tableAlias();

            return $carry;
        }, []);
    }

    protected function getTableOptions(): array
    {
        return array_merge([
            "{$this->source->config('name')} ({$this->source->table()})" => $this->source()->table()
        ], $this->getListOfTables());
    }

    public static function getCacheKey(): string
    {
        return 'database-records';
    }

    protected static function resolveArgs(array $args, $root): array
    {
        $dynamicArgs = ['filters', 'orderings', 'ordering'];

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
