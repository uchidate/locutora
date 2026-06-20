<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Database\Table;

use YOOtheme\Str;
use ZOOlanders\YOOessentials\HasLocalConfig;
use ZOOlanders\YOOessentials\Source\GraphQL\HasSourceInterface;
use ZOOlanders\YOOessentials\Source\SourceService;
use ZOOlanders\YOOessentials\Source\Type\SourceInterface;
use ZOOlanders\YOOessentials\Sources\Database\DatabaseSource;
use ZOOlanders\YOOessentials\Sources\Database\InvalidRelationConfigException;
use ZOOlanders\YOOessentials\Sources\Database\Type\DatabaseTableType;

class Relation
{
    use HasLocalConfig;

    public const BELONGS_TO = '1-1';
    public const HAS_MANY = '1-n';

    /** @var SourceInterface|DatabaseSource */
    protected $source;

    public function __construct(SourceInterface $source, array $config)
    {
        $this->source = $source;
        $this->config = $config;

        $this->validate();
    }

    public function name(): ?string
    {
        return $this->config('relation_name', $this->table());
    }

    public function relationFieldName(): string
    {
        return SourceService::encodeField($this->name());
    }

    public function type(): ?string
    {
        return $this->config('relation_type', self::BELONGS_TO);
    }

    public function table(): ?string
    {
        return $this->config('related_table');
    }

    public function tableAlias(): ?string
    {
        return Str::snakeCase($this->name());
    }

    public function mainTableKey(): ?string
    {
        return $this->config('main_table_key');
    }

    public function relatedTableKey(): ?string
    {
        return $this->config('related_table_key');
    }

    public function mainTableType(): HasSourceInterface
    {
        return $this->source->mainTableType();
    }

    public function relatedType(): HasSourceInterface
    {
        return new DatabaseTableType($this->source, $this);
    }

    public static function types(): array
    {
        return [
            self::BELONGS_TO,
            self::HAS_MANY,
        ];
    }

    private function validate(): void
    {
        if ($this->table() === null) {
            throw new InvalidRelationConfigException('Table cannot be empty', $this->config);
        }

        if ($this->type() === null) {
            throw new InvalidRelationConfigException('Relation Type cannot be empty', $this->config);
        }

        if ($this->relatedTableKey() === null) {
            throw new InvalidRelationConfigException('Related Table Key cannot be empty', $this->config);
        }

        if ($this->mainTableKey() === null) {
            throw new InvalidRelationConfigException('Main Table Key cannot be empty', $this->config);
        }
    }
}
