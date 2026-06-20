<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form\Actions\SaveDatabase;

use YOOtheme\Http\Request;
use YOOtheme\Http\Response;
use YOOtheme\Str;
use ZOOlanders\YOOessentials\DatabaseManager;

class SaveDatabaseController
{
    use HasDatabase;

    public const GET_TABLE_LIST_ENDPOINT = 'yooessentials/form-action/savedb/tables';
    public const GET_TABLE_COLUMNS_ENDPOINT = 'yooessentials/form-action/savedb/columns';
    public const GET_TABLE_FIELDS_ENDPOINT = 'yooessentials/form-action/savedb/fields';

    public function getTableList(Request $request, Response $response)
    {
        $config = $request->getParam('form') ?? [];

        try {
            $db = self::db($config);

            $prefix = $db->prefix;
            $tables = $db->fetchAll('SHOW TABLES');

            $items = array_map(function ($table) use ($prefix) {
                $id = array_values($table)[0] ?? null;

                return [
                    'value' => $id,
                    'text' => Str::titleCase(Str::snakeCase(preg_replace("/^$prefix/", '', $id), ' ')),
                    'meta' => $id
                ];
            }, $tables);

            return $response->withJson($items, 200);
        } catch (\Exception $e) {
            return $response->withJson($e->getMessage(), 400);
        }
    }

    public function getTableColumns(Request $request, Response $response, DatabaseManager $database)
    {
        $config = $request->getParam('form') ?? [];
        $table = $config['table'] ?? '';

        try {
            if (!$table) {
                throw new \Exception('Table must be specified.');
            }

            $db = self::db($config);
            $result = $db->fetchAll("SHOW FULL COLUMNS FROM $table");

            $columns = array_reduce($result, function ($carry, $col) {
                if ($col['Extra'] === 'auto_increment') {
                    return $carry;
                }

                $carry[] = [
                    'id' => $col['Field'],
                    'meta' => $col['Type'],
                    'title' => Str::titleCase($col['Field'])
                ];

                return $carry;
            }, []);
        } catch (\Exception $e) {
            return $response->withJson($e->getMessage(), 400);
        }

        return $response->withJson($columns);
    }

    public function getTableFields(Request $request, Response $response)
    {
        $config = $request->getParam('form') ?? [];
        $table = $config['table'] ?? '';

        try {
            if (!$table) {
                throw new \Exception('Table must be specified.');
            }

            $db = self::db($config);

            $columns = $db->fetchAll("SHOW FULL COLUMNS FROM $table");

            $fields = array_filter(array_map(function ($column) {
                $id = $column['Field'] ?? null;

                return [
                    'value' => $id,
                    'meta' => $id,
                    'text' => Str::titleCase(Str::snakeCase($id, ' '))
                ];
            }, $columns));

            return $response->withJson($fields, 200);
        } catch (\Exception $e) {
            return $response->withJson($e->getMessage(), 400);
        }
    }
}
