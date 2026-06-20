<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Joomla;

use Joomla\CMS\Factory;
use function YOOtheme\app;
use YOOtheme\Arr;
use YOOtheme\Config;
use YOOtheme\Database;

use ZOOlanders\YOOessentials\AbstractDatabaseManager;

class DatabaseManager extends AbstractDatabaseManager implements \ZOOlanders\YOOessentials\DatabaseManager
{
    public function initialize(array $options): Database
    {
        $isExternal = $options['external'] ?? false;
        $database = $options['database'] ?? false;

        if (!$isExternal and !$database) {
            return app(Database::class);
        }

        // support for local connection with custom database
        if (!$isExternal and $database) {
            $options = Arr::pick($options, ['database']);
        }

        $config = app(Config::class);
        $defaults = array_merge($config->get('yooessentials.db', []), [
            'user' => $config->get('joomla.config.user'),
            'password' => $config->get('joomla.config.password')
        ]);

        $options = array_merge($defaults, $options);

        $driver = \JDatabaseDriver::getInstance($options);

        return new \YOOtheme\Joomla\Database($driver);
    }

    public function type(): string
    {
        return Factory::getDbo()->getServerType();
    }

    public function serverVersion(): string
    {
        return Factory::getDbo()->getVersion();
    }

    public function collation(): string
    {
        return Factory::getDbo()->getCollation();
    }

    public function connectionCollation(): string
    {
        return Factory::getDbo()->getConnectionCollation();
    }
}
