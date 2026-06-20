<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Database;

use YOOtheme\Event;
use function YOOtheme\app;
use YOOtheme\Database;
use ZOOlanders\YOOessentials\DatabaseManager;
use ZOOlanders\YOOessentials\Source\Type\AbstractSourceType;
use ZOOlanders\YOOessentials\Source\Type\DynamicSourceInputType;
use ZOOlanders\YOOessentials\Source\Type\SourceInterface;
use ZOOlanders\YOOessentials\Sources\Database\Table\Relation;
use ZOOlanders\YOOessentials\Sources\Database\Type\DatabaseTableType;
use ZOOlanders\YOOessentials\Util;

class DatabaseSource extends AbstractSourceType implements SourceInterface
{
    public const MODE_ROW = 'row';
    public const MODE_LIST = 'list';

    /** @var array */
    protected $relationTypes = [];

    /** @var Database */
    protected $db;

    /** @var DatabaseManager */
    protected $manager;

    public function __construct(array $config = [])
    {
        $this->manager = app(DatabaseManager::class);

        parent::__construct($config);
    }

    public function bind(array $config): SourceInterface
    {
        $config['db_database'] = $config['db_name'] ?? null;
        unset($config['db_name']);

        parent::bind($config);

        return $this;
    }

    public function types(): array
    {
        $types = array_values($this->relationTypes());

        $objectType = $this->mainTableType();
        $filterType = new Type\DatabaseFilterType();
        $orderingType = new Type\DatabaseOrderingType();

        return array_merge($types, [
            $objectType,
            $filterType,
            $orderingType,
            new DynamicSourceInputType($filterType), // wrap for props
            new DynamicSourceInputType($orderingType), // wrap for props
            new Type\DatabaseRecordQueryType($this, $objectType),
            new Type\DatabaseRecordsQueryType($this, $objectType),
        ]);
    }

    public function mainTableType(): DatabaseTableType
    {
        return new Type\DatabaseTableType($this);
    }

    public function manager(): DatabaseManager
    {
        return $this->manager;
    }

    public function table(): string
    {
        return $this->config('table');
    }

    public function tableColumns(string $table = null): array
    {
        return $this->manager->getTableColumnsFromDb($this->db(), $table ?? $this->table());
    }

    public function mode(): string
    {
        return $this->config('mode', self::MODE_LIST);
    }

    public function primaryKey(): string
    {
        return $this->config('table_primary_key', $this->config('primary_key', 'id'));
    }

    public function hasRelations(): bool
    {
        return count($this->relationsConfig()) > 0;
    }

    public function hasHasManyRelations(): bool
    {
        if (!$this->hasRelations()) {
            return false;
        }

        return count($this->hasManyRelations()) > 0;
    }

    public function hasBelongsToRelations(): bool
    {
        if (!$this->hasRelations()) {
            return false;
        }

        return count($this->belongsToRelations()) > 0;
    }

    /** @return Relation[] */
    public function hasManyRelations(): array
    {
        return array_filter($this->relations(), function (Relation $relation) {
            return $relation->type() === Relation::HAS_MANY;
        });
    }

    /** @return Relation[] */
    public function belongsToRelations(): array
    {
        return array_filter($this->relations(), function (Relation $relation) {
            return $relation->type() === Relation::BELONGS_TO;
        });
    }

    /** @return DatabaseTableType[] */
    public function relationTypes(): array
    {
        if (!empty($this->relationTypes)) {
            return $this->relationTypes;
        }

        foreach ($this->relations() as $relation) {
            $this->relationTypes[] = $relation->relatedType();
        }

        return $this->relationTypes;
    }

    /** @return Relation[] */
    public function belongsToRelationMap(): array
    {
        $relationMap = [];
        foreach ($this->belongsToRelations() as $relation) {
            $relationMap[$relation->relationFieldName()] = $relation;
        }

        return $relationMap;
    }

    /** @return Relation[] */
    public function hasManyRelationMap(): array
    {
        $relationMap = [];
        foreach ($this->hasManyRelations() as $relation) {
            $relationMap[$relation->relationFieldName()] = $relation;
        }

        return $relationMap;
    }

    /** @return Relation[] */
    public function relations(): array
    {
        return array_filter(array_map(function ($relation) {
            try {
                return new Relation($this, $relation);
            } catch (InvalidRelationConfigException $e) {
                Event::emit('yooessentials.error', [
                    'addon' => 'source',
                    'action' => 'db-relation-config',
                    'args' => $relation,
                    'error' => $e->getMessage(),
                    'exception' => $e
                ]);

                return null;
            }
        }, $this->relationsConfig()));
    }

    public function relationFromTableAlias(string $tableAlias): ?Relation
    {
        foreach ($this->relations() as $relation) {
            if ($relation->tableAlias() === $tableAlias) {
                return $relation;
            }
        }

        return null;
    }

    public function relationsConfig(): array
    {
        return $this->config('table_relations', []);
    }

    public function db(): Database
    {
        if ($this->db) {
            return $this->db;
        }

        $options = Util\Prop::filterByPrefix($this->config, 'db_');
        $options = array_filter($options);

        $options['external'] = $this->config('external', false);

        return $this->db = app(DatabaseManager::class)->initialize($options);
    }
}
