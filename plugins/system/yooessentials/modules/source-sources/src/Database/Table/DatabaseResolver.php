<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Database\Table;

use function YOOtheme\app;
use YOOtheme\Event;
use ZOOlanders\YOOessentials\DatabaseQuery;
use ZOOlanders\YOOessentials\Source\Resolver\AbstractResolver;
use ZOOlanders\YOOessentials\Source\Resolver\Filters\DatabaseFilter;
use ZOOlanders\YOOessentials\Source\Resolver\Filters\DatabaseFilters;
use ZOOlanders\YOOessentials\Source\Resolver\HasQueryMode;
use ZOOlanders\YOOessentials\Source\Resolver\Orders\DatabaseOrders;
use ZOOlanders\YOOessentials\Source\Resolver\QueryMode;
use ZOOlanders\YOOessentials\Source\Resolver\SourceResolver;
use ZOOlanders\YOOessentials\Source\SourceService;
use ZOOlanders\YOOessentials\Sources\Database\DatabaseSource;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\Cache\Adapter\FilesystemAdapter;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\Cache\CacheInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\Cache\ItemInterface;

class DatabaseResolver extends AbstractResolver implements QueryMode
{
    use HasQueryMode;

    /**
     * @var DatabaseSource
     */
    protected $source;

    private $eagerLoads = [];
    private $queryStructure = null;

    /** @var bool */
    private $randomOrdering = false;

    private $id;

    public function __construct(DatabaseSource $source, array $args = [], array $root = [])
    {
        parent::__construct($source, $args, $root);

        $this->id = $this->source->id();
    }

    public function fromArgs(array $args, $root): SourceResolver
    {
        if ($args['random_order'] ?? false) {
            $this->randomOrdering = true;
        }

        $this
            ->offset($args['offset'] ?? self::DEFAULT_OFFSET)
            ->limit($args['limit'] ?? self::DEFAULT_LIMIT)
            ->queryStructure($args['query'] ?? null)
            ->mode($args['mode'] ?? self::MODE_AND)
            ->filters($args['filters'] ?? [], $root)
            ->orders($args['ordering'] ?? [], $root);

        return $this;
    }

    protected function makeFilters(array $filters): DatabaseFilters
    {
        return new DatabaseFilters($filters, $this->source);
    }

    protected function makeOrders(array $orders): DatabaseOrders
    {
        return new DatabaseOrders($orders, $this->source);
    }

    public function queryStructure(?string $query = null): self
    {
        $this->queryStructure = $query;

        return $this;
    }

    public function id($id = null): self
    {
        $this->id = $id;

        return $this;
    }

    public function resolve(): array
    {
        $query = $this->buildQuery();

        if (app()->config->get('app.isCustomizer')) {
            Event::emit('yooessentials.info', [
                'addon' => 'source',
                'provider' => 'database',
                'query' => (string) $query,
            ]);
        }

        try {
            return $this->queryData($query);
        } catch (\Exception $e) {
            Event::emit('yooessentials.error', [
                'addon' => 'source',
                'action' => 'resolve',
                'source' => "{$this->source->id()} - {$this->source->name()}",
                'provider' => 'database',
                'error' => $e->getMessage(),
                'exception' => $e,
                'query' => (string) $query,
            ]);

            return [];
        }
    }

    public function buildQuery(): DatabaseQuery
    {
        /** @var DatabaseQuery $query */
        $query = app(DatabaseQuery::class)->createForDatabase($this->source->db());

        $tables = $this->tablesList();

        $fields = [];
        foreach ($tables as $tblAlias => $tbl) {
            $tableFields = $this->aliasedFieldsForTable($tbl, $tblAlias);
            $fields = array_merge($fields, $tableFields);
        }

        $query = $query
            ->select($fields)
            ->from($this->source->table())
            ->offset($this->offset)
            ->limit($this->limit);

        if ($this->source->hasRelations()) {
            $query = $this->addRelatedTables($query);
        }

        if ($this->hasOrders() || $this->randomOrdering) {
            $query = $this->addOrdering($query);
        }

        if (!$this->hasFilters()) {
            return $query;
        }

        return $query->whereRaw($this->buildFiltersWhere());
    }

    public function filtersOnMainTable(): array
    {
        return array_filter($this->filters->enabled(), function (DatabaseFilter $filter) {
            return $filter->tableAlias() === $this->source->table();
        });
    }

    public function filtersByRelationType(string $type): array
    {
        return array_filter($this->filters->enabled(), function (DatabaseFilter $filter) use ($type) {
            $relation = $this->source->relationFromTableAlias($filter->tableAlias());
            if (!$relation) {
                return false;
            }

            return $relation->type() === $type;
        });
    }

    private function eagerLoadRelation(Relation $relation, DatabaseQuery $query, array $data): array
    {
        $eagerLoadQuery = $query->createForDatabase($this->source->db());

        // Take all the primary keys from the queried data (the main table)
        $ids = $this->pluckMainTablePrimaryKeys($relation, $data);

        if (count($ids) <= 0) {
            return [];
        }

        $tableFields = $this->aliasedFieldsForTable($relation->table(), $relation->tableAlias());

        try {
            $eagerLoadQuery = $eagerLoadQuery
                ->select($tableFields)
                ->from(self::quoteNameStr([$relation->table()]) . ' AS ' . self::quoteNameStr([$relation->tableAlias()]))
                ->whereIn(self::quoteNameStr([$relation->tableAlias(), $relation->relatedTableKey()]), $ids);

            if (app()->config->get('app.isCustomizer')) {
                Event::emit('yooessentials.info', [
                    'addon' => 'source',
                    'provider' => 'database',
                    'query' => (string) $eagerLoadQuery,
                ]);
            }

            $data = $eagerLoadQuery->get();

            return array_map(function ($relatedRow) use ($relation) {
                return $this->removeTablePrefixFromData((array) $relatedRow, $relation->relationFieldName());
            }, $data);
        } catch (\Exception $e) {
            Event::emit('yooessentials.error', [
                'addon' => 'source',
                'action' => 'load-relation',
                'source' => "{$this->source->id()} - {$this->source->name()}",
                'provider' => 'database',
                'error' => $e->getMessage(),
                'exception' => $e,
                'relation' => $relation->name(),
                'query' => (string) $query,
            ]);

            return [];
        }
    }

    public static function quoteNameStr(array $strArr): string
    {
        $parts = [];
        $q = '`';

        foreach ($strArr as $part) {
            if (is_null($part)) {
                continue;
            }

            if (strlen($q) == 1) {
                $parts[] = $q . str_replace($q, $q . $q, $part) . $q;
            } else {
                $parts[] = $q[0] . str_replace($q[1], $q[1] . $q[1], $part) . $q[1];
            }
        }

        return implode('.', $parts);
    }

    private function quote($text)
    {
        if (is_array($text)) {
            foreach ($text as $k => $v) {
                $text[$k] = $this->quote($v);
            }

            return $text;
        }

        if (is_numeric($text)) {
            if (is_float($text)) {
                return (float) $text;
            }

            return (int) $text;
        }

        return $this->source->db()->escape($text);
    }

    private function addRelatedTables(DatabaseQuery $query): DatabaseQuery
    {
        foreach ($this->source->hasManyRelations() as $relation) {
            $this->eagerLoads[] = $relation;
        }

        /** @var Relation $relation */
        foreach ($this->source->belongsToRelations() as $relation) {
            $relatedField = self::quoteNameStr([
                $this->source->table(),
                $relation->mainTableKey()
            ]);

            $relatedTableField = self::quoteNameStr([
                $relation->tableAlias(),
                $relation->relatedTableKey()
            ]);

            $query->leftJoin(
                self::quoteNameStr([$relation->table()]) . ' AS ' . self::quoteNameStr([$relation->tableAlias()]),
                $relatedField,
                '=',
                $relatedTableField
            );
        }

        return $query;
    }

    private function replaceTablePrefix(array $data): array
    {
        if (!$this->source->hasRelations()) {
            return $this->removeTablePrefixFromData($data, $this->source->table());
        }

        // each relation "field" is actually the array representation of the related object
        $return = $this->replaceBelongsToFieldWithObject($data);

        return $this->removeTablePrefixFromData($data, $this->source->table(), $return);
    }

    private function queryData(DatabaseQuery $query): array
    {
        $data = $query->get();

        $eagerLoadedData = [];
        /** @var Relation $eagerLoad */
        foreach ($this->eagerLoads as $eagerLoad) {
            $eagerLoadedData[$eagerLoad->relationFieldName()] = $this->eagerLoadRelation($eagerLoad, $query, $data);
        }

        $data = array_map(function ($row) {
            return $this->replaceTablePrefix((array) $row);
        }, $data);

        $data = array_map(function ($row) use ($eagerLoadedData) {
            foreach ($eagerLoadedData as $relatedField => $relatedData) {
                $row[$relatedField] = $relatedData;
            }

            $values = [];
            foreach ($row as $key => $value) {
                $values[SourceService::encodeField($key)] = $value;
            }

            return $values;
        }, $data);

        return $data;
    }

    private function tablesList(): array
    {
        $tables = [$this->source->table() => $this->source->table()];

        // No relation set, just SELECT FROM the main table
        if (!$this->source->hasBelongsToRelations()) {
            return $tables;
        }

        // Belongs To needs a LEFT JOIN for each of the tables, with a dedicated alias
        foreach ($this->source->belongsToRelations() as $relation) {
            $tables[$relation->tableAlias()] = $relation->table();
        }

        return $tables;
    }

    private function aliasedFieldsForTable(string $tbl, string $tblAlias): array
    {
        /** @var FilesystemAdapter $cache */
        $cache = app(CacheInterface::class);
        $cacheKey = 'database-table-fields-' . sha1(json_encode($this->source->config() + ['fields_for_table' => $tbl]));

        $tableFields = $cache->get($cacheKey, function (ItemInterface $item) use ($tbl, $tblAlias) {

            // Get the list of fields for the table
            $tableFields = array_keys($this->source->manager()->getTableColumnsFromDb($this->source->db(), $tbl));

            // build a list of `field` AS `alias` to avoid naming conflicts
            return array_map(function ($field) use ($tbl, $tblAlias) {
                $alias = self::quoteNameStr([$tblAlias . '_' . $field]);
                $field = self::quoteNameStr([
                    $tblAlias,
                    $field
                ]);

                return $field . ' AS ' . $alias;
            }, $tableFields);
        });

        // avoid caching empty list
        if (!$tableFields || empty($tableFields)) {
            $cache->delete($cacheKey);
        }

        return $tableFields;
    }

    private function buildQueryStructure(): string
    {
        if ($this->mode === self::MODE_CUSTOM && $this->queryStructure) {
            return $this->queryStructure;
        }

        if ($this->mode === self::MODE_CUSTOM) {
            $this->mode = self::MODE_AND;
        }

        $numberOfFilters = count($this->filters->enabled());
        $queryParts = [];
        for ($i = 1; $i <= $numberOfFilters; $i++) {
            $queryParts[] = "({{$i}})";
        }

        return implode(" {$this->mode} ", $queryParts);
    }

    private function buildHasManyFilter($filter)
    {
        $filterTable = $filter->tableAlias();
        $relation = $this->source->relationFromTableAlias($filter->tableAlias());
        if ($relation) {
            $filterTable = $relation->table();
        }

        $hasManyQuery = app(DatabaseQuery::class)->createForDatabase($this->source->db());

        $filterField = self::quoteNameStr([
            $filterTable,
            $filter->field()
        ]);

        return $hasManyQuery->select('*')->from($filterTable)->where($filterField, $filter->operator(), $this->quote($filter->value()));
    }

    private function buildFiltersWhere(): string
    {
        $queryStructure = $this->buildQueryStructure();

        foreach ($this->filters->enabled() as $i => $filter) {
            // Query will be radically different based on the relation type
            $relation = $this->source->relationFromTableAlias($filter->tableAlias());
            $type = $relation ? $relation->type() : Relation::BELONGS_TO;

            // User inputs {1} or {n}
            $k = $i + 1;
            $field = self::quoteNameStr([
                $filter->tableAlias(),
                $filter->field()
            ]);

            // Has many, use WHERE EXISTS (subquery on the related table)
            if ($type === Relation::HAS_MANY) {
                $hasManyQuery = $this->buildHasManyFilter($filter);
                $queryStructure = str_replace("{{$k}}", 'EXISTS(' . $hasManyQuery . ')', $queryStructure);

                continue;
            }

            // Belongs to, simple WHERE related_field
            $value = $filter->value() === null ? 'NULL' : $this->quote($filter->value());
            $queryStructure = str_replace("{{$k}}", "({$field} {$filter->operator()} $value)", $queryStructure);
        }

        return $queryStructure;
    }

    private function pluckMainTablePrimaryKeys(Relation $relation, array $data): array
    {
        $ids = array_filter(array_map(function ($row) use ($relation) {
            $alias = $this->source->table() . '_' . $this->source->primaryKey();

            return $row[$alias] ?? null;
        }, $data));

        return $ids;
    }

    private function replaceBelongsToFieldWithObject(array &$data): array
    {
        $return = [];
        /** @var Relation $relation */
        foreach ($this->source->belongsToRelations() as $relation) {
            $return[$relation->relationFieldName()] = [];
            foreach ($data as $key => $value) {
                if ($relation->tableAlias() && stripos($key, $relation->tableAlias()) === 0) {
                    $fieldKey = substr($key, strlen($relation->tableAlias()) + 1);
                    $return[$relation->relationFieldName()][$fieldKey] = $value;
                    unset($data[$key]);
                }
            }
        }

        return $return;
    }

    private function removeTablePrefixFromData(array $data, string $table, array $return = []): array
    {
        foreach ($data as $key => $value) {
            // remove the prefixed table name added previously
            $key = str_replace($table . '_', '', $key);
            $return[$key] = $return[$key] ?? $value;
        }

        return $return;
    }

    private function addOrdering(DatabaseQuery $query): DatabaseQuery
    {
        if ($this->randomOrdering) {
            return $query->orderBy('RAND()');
        }

        foreach ($this->orders->enabled() as $order) {
            $query = $order->apply($query);
        }

        return $query;
    }
}
