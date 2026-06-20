<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Database\Type;

use YOOtheme\Event;
use YOOtheme\Str;
use ZOOlanders\YOOessentials\Source\GraphQL\AbstractObjectType;
use ZOOlanders\YOOessentials\Source\GraphQL\HasSourceInterface;
use ZOOlanders\YOOessentials\Source\SourceService;
use ZOOlanders\YOOessentials\Source\Type\SourceInterface;
use ZOOlanders\YOOessentials\Sources\Database\DatabaseSource;
use ZOOlanders\YOOessentials\Sources\Database\Table\Relation;

class DatabaseTableType extends AbstractObjectType implements HasSourceInterface
{
    /** @var Relation|null */
    protected $relation;

    /** @var DatabaseSource */
    protected $source;

    public function __construct(SourceInterface $source, ?Relation $relation = null)
    {
        parent::__construct($source);

        $this->relation = $relation;
    }

    public function name(): string
    {
        $parts = [
            'database',
            $this->source->id(),
            $this->replaceTablePrefix($this->currentTable())
        ];

        return implode('_', $parts);
    }

    public function label(): string
    {
        $label = parent::label();

        if ($this->isRelatedTable()) {
            $label = $this->relation()->name() ?: $label . ' - ' . $this->relation()->table();
        }

        return $label;
    }

    public function isRelatedTable(): bool
    {
        return (bool) $this->relation();
    }

    public function relation(): ?Relation
    {
        return $this->relation;
    }

    public function config(): array
    {
        $fields = [];
        $table = $this->currentTable();

        try {
            $columns = $this->source->tableColumns($table);
        } catch (\Exception $e) {
            Event::emit('yooessentials.error', [
                'addon' => 'source',
                'provider' => 'database',
                'error' => $e->getMessage(),
                'exception' => $e
            ]);

            return [];
        }

        foreach ($columns as $field => $type) {
            if (!$field) {
                continue;
            }

            $field = SourceService::encodeField($field);

            // map the single field
            $fields[$field] = [
                'type' => $this->source->manager()->convertSqlTypeToSchemaType($type),
                'metadata' => [
                    'label' => Str::titleCase($field),
                    'filters' => $this->source->manager()->getSchemaFiltersFromSqlType($type),
                ]
            ];
        }

        if (!$this->isRelatedTable()) {
            foreach ($this->source->hasManyRelationMap() as $relationField => $relation) {
                $relatedType = $relation->relatedType();
                $relatedTypeName = $relatedType->name();

                // Add a new field with the related object
                $fields[$relationField] = [
                    'type' => ['listOf' => $relatedTypeName],
                    'metadata' => [
                        'label' => $relatedType->label(),
                    ]
                ];
            }

            // Add belongs to relation fields
            foreach ($this->source->belongsToRelationMap() as $relationField => $relation) {
                $relatedType = $relation->relatedType();
                $relatedTypeName = $relatedType->name();

                // Add a new field with the related object
                $fields[$relation->relationFieldName()] = [
                    'type' => $relatedTypeName,
                    'metadata' => [
                        'label' => $relatedType->label(),
                    ]
                ];
            }
        }

        return [
            'fields' => $fields,
            'metadata' => [
                'type' => true,
                'label' => $this->label(),
            ],
        ];
    }

    public static function resolveRelation($row, $args)
    {
        $field = $args['fieldName'] ?? 'id';

        return $row[$field] ?? [];
    }

    private function replaceTablePrefix(string $table): string
    {
        return str_replace($this->source->db()->prefix, '', $table);
    }

    private function currentTable(): string
    {
        return $this->isRelatedTable() ? $this->relation()->table() : $this->source()->table();
    }
}
