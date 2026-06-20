<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials;

use YOOtheme\Database;

abstract class AbstractDatabaseManager
{
    public function getTableColumnsFromDb(Database $db, string $table): array
    {
        $columns = $db->fetchAll('SHOW FULL COLUMNS FROM ' . $table);

        $data = [];
        foreach ($columns as $column) {
            $field = $column['Field'] ?? null;
            $type = $column['Type'] ?? 'String';

            if ($field) {
                $data[$field] = $type;
            }
        }

        return $data;
    }

    public function convertSqlTypeToSchemaType(string $type): string
    {
        switch ($type) {
            case 'int':
                return 'Int';
            case 'string':
            case 'String':
            case 'varchar':
            case 'text':
            case 'longtext':
            case 'mediumtext':
            case 'char':
            default:
                return 'String';
        }
    }

    public function getSchemaFiltersFromSqlType(string $type): array
    {
        switch ($type) {
            case 'datetime':
            case 'date':
                return ['date'];
            case 'string':
            case 'String':
            case 'varchar':
            case 'text':
            case 'longtext':
            case 'mediumtext':
            case 'char':
                return ['limit'];
        }

        return [];
    }
}
