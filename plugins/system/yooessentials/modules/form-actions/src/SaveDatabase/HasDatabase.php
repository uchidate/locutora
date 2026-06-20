<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form\Actions\SaveDatabase;

use function YOOtheme\app;
use YOOtheme\Database;
use ZOOlanders\YOOessentials\DatabaseManager;
use ZOOlanders\YOOessentials\Util;

trait HasDatabase
{
    /** @var Database */
    protected $db;

    public function db(array $config): Database
    {
        if ($this->db) {
            return $this->db;
        }

        $options = Util\Prop::filterByPrefix($config, 'db_');
        $options = array_filter($options);

        $options['external'] = (bool) ($config['external'] ?? false);

        $options['database'] = $options['name'] ?? '';
        unset($options['name']);

        return $this->db = app(DatabaseManager::class)->initialize($options);
    }
}
