<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials;

use function YOOtheme\app;

class Logger extends Data
{
    /**
     * @var array
     */
    public static $logs = [];

    public function __construct(string $group, array $args = [])
    {
        parent::__construct([
            'logs' => []
        ] + $args);

        self::$logs[$group] = self::$logs[$group] ?? [];
        self::$logs[$group][] = $this;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function log(string $id, array $args): void
    {
        if (!app()->config->get('app.isCustomizer')) {
            return;
        }

        $logs = $this->logs;
        $key = array_search($id, array_column($logs, 'id'));

        if ($key !== false) {
            $logs[$key] = $logs[$key] + $args;
        } else {
            $args['id'] = $id;
            $logs[] = $args;
        }

        $this->logs = $logs;
    }

    public function logError(string $id, string $error, array $args = []): void
    {
        $this->log($id, compact('error') + $args);
    }
}
