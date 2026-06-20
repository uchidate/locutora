<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Joomla;

use Joomla\CMS\Factory;
use YOOtheme\Arr;
use YOOtheme\Database;

class DatabaseQuery implements \ZOOlanders\YOOessentials\DatabaseQuery
{
    /**
     * @var Database|\JDatabaseDriverMysqli
     */
    protected $db;

    /**
     * @var \JDatabaseQuery
     */
    protected $query;
    protected $offset = 0;
    protected $limit = 20;

    public function __construct(Database $db)
    {
        $this->db = $db;
        $this->query = Factory::getDbo()->getQuery(true);
    }

    public function createForDatabase(Database $database): \ZOOlanders\YOOessentials\DatabaseQuery
    {
        return new DatabaseQuery($database);
    }

    public function __call($name, $arguments)
    {
        call_user_func_array([$this->db, $name], $arguments);

        return $this;
    }

    public function select($fields = '*'): \ZOOlanders\YOOessentials\DatabaseQuery
    {
        $this->query->select($fields);

        return $this;
    }

    public function from($table): \ZOOlanders\YOOessentials\DatabaseQuery
    {
        $this->query->from($table);

        return $this;
    }

    public function leftJoin($table, $firstColumn, $operator = '=', $secondColumn = null): \ZOOlanders\YOOessentials\DatabaseQuery
    {
        $this->query->leftJoin("{$table} ON {$firstColumn} {$operator} {$secondColumn}");

        return $this;
    }

    public function where($column, $operator = '=', $value = null): \ZOOlanders\YOOessentials\DatabaseQuery
    {
        $this->query->where("{$column} {$operator} {$value}");

        return $this;
    }

    public function whereRaw($query, $glue = 'AND'): \ZOOlanders\YOOessentials\DatabaseQuery
    {
        if (strtoupper($glue) === 'OR') {
            $this->query->orWhere($query, $glue);

            return $this;
        }

        $this->query->where($query, $glue);

        return $this;
    }

    public function whereIn($column, $values): \ZOOlanders\YOOessentials\DatabaseQuery
    {
        $values = implode(',', Arr::wrap($values));
        $this->query->where("{$column} IN ( {$values} )");

        return $this;
    }

    public function limit($limit): \ZOOlanders\YOOessentials\DatabaseQuery
    {
        $this->limit = $limit;

        return $this;
    }

    public function offset($offset): \ZOOlanders\YOOessentials\DatabaseQuery
    {
        $this->offset = $offset;

        return $this;
    }

    public function get(): array
    {
        return $this->db->fetchAll((string) $this);
    }

    public function orderBy(string $field, string $direction = 'ASC'): \ZOOlanders\YOOessentials\DatabaseQuery
    {
        $this->query->order($field . ' ' . $direction);

        return $this;
    }

    public function __toString()
    {
        return (string) $this->query  . " LIMIT {$this->offset}, {$this->limit}";
    }
}
