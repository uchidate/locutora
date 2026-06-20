<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials;

use YOOtheme\Database;

interface DatabaseManager
{
    public function initialize(array $config): Database;

    public function getTableColumnsFromDb(Database $db, string $table): array;

    public function convertSqlTypeToSchemaType(string $type): string;

    public function getSchemaFiltersFromSqlType(string $type): array;

    public function type(): string;

    public function serverVersion(): string;

    public function collation(): string;

    public function connectionCollation(): string;
}
