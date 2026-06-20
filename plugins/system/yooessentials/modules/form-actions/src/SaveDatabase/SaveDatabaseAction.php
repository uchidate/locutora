<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form\Actions\SaveDatabase;

use ZOOlanders\YOOessentials\Form\Actions\SaveToAction;
use ZOOlanders\YOOessentials\Form\Http\FormSubmissionResponse;

class SaveDatabaseAction extends SaveToAction
{
    use HasDatabase;

    public const NAME = 'save-database';

    public function __invoke(FormSubmissionResponse $response, callable $next): FormSubmissionResponse
    {
        $config = (object) $this->getConfig();

        $db = self::db((array) $config);
        $data = self::resolveData($config->content ?? []);

        self::updateOrInsert($config, $db, $data);

        return $next($response->withDataLog([
            self::NAME => [
                'config' => $config,
                'data' => $data
            ]
        ]));
    }

    private static function updateOrInsert(object $config, \YOOtheme\Database $db, array $data)
    {
        $shouldUpdate = $config->update_if_exists ?? false;

        if (!$shouldUpdate) {
            return $db->insert($config->table, $data);
        }

        if (!isset($config->table_key, $config->table_key_value)) {
            throw new \RuntimeException('Could not update data, incomplete configuration.');
        }

        $result = $db->fetchArray('SELECT COUNT(*) as results FROM ' . $config->table . ' where ' . $config->table_key . ' = :table_value', [
            'table_value' => $config->table_key_value
        ]);

        $count = (int) ($result['results'] ?? $result[0] ?? 0);

        if ($count > 1) {
            throw new \RuntimeException('Could not update data, more than one match found.');
        }

        if ($count === 0) {
            return $db->insert($config->table, $data);
        }

        $result = $db->update($config->table, $data, [
            $config->table_key => $config->table_key_value
        ]);

        if (!$result) {
            throw new \RuntimeException('Could not insert or update data.');
        }
    }
}
