<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials;

use YOOtheme\Database;

interface DatabaseQuery
{
    public function createForDatabase(Database $database): self;

    public function select($fields = '*'): self;
    public function from($table): self;
    public function leftJoin($table, $firstColumn, $operator = '=', $secondColumn = null): self;
    public function where($column, $operator = '=', $value = null): self;
    public function whereRaw($query, $glue = 'AND'): self;
    public function whereIn($column, $values): self;
    public function limit($limit): self;
    public function offset($offset): self;
    public function orderBy(string $field, string $direction = 'ASC'): self;

    public function get(): array;
}
