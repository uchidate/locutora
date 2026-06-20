<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Database\Type;

use ZOOlanders\YOOessentials\Source\Resolver\Filters\DatabaseFilter;
use ZOOlanders\YOOessentials\Source\Type\DynamicSourceInputType;
use ZOOlanders\YOOessentials\Sources\Database\Table\DatabaseResolver;

class DatabaseRecordQueryType extends DatabaseRecordsQueryType
{
    public function name(): string
    {
        $id = $this->source()->id();

        return "databaseRecord_{$id}_query";
    }

    public function label(): string
    {
        return "{$this->source()->name()} Record";
    }

    public function config(): array
    {
        $tableOptions = $this->getTableOptions();

        return [
            'fields' => [
                $this->name() => [
                    'type' => $this->objectType->name(),

                    'args' => [

                        'offset' => [
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
                                'label' => 'Filter by Fields',
                                'type' => 'yooessentials-button-panel',
                                'text' => 'Filters',
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
                                'label' => 'Order by Fields',
                                'type' => 'yooessentials-button-panel',
                                'text' => 'Ordering',
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

                            'offset' => [
                                'label' => 'Start',
                                'type' => 'yooessentials-number',
                                'description' => 'Set the starting point to specify which record is loaded.',
                                'modifier' => 1,
                                'default' => DatabaseResolver::DEFAULT_OFFSET,
                                'attrs' => [
                                    'placeholder' => DatabaseResolver::DEFAULT_OFFSET + 1,
                                    'min' => 1
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
                            'args' => [
                                'source_id' => $this->source->id()
                            ]
                        ]
                    ],

                ],

            ],

        ];
    }

    public static function resolve($root, array $args)
    {
        // force limit
        $args['limit'] = 1;

        $records = parent::resolve($root, $args);

        return array_shift($records) ?? [];
    }
}
