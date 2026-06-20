<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials;

use YOOtheme\Arr;
use YOOtheme\Config;
use YOOtheme\Metadata;
use YOOtheme\Str;

class ConsoleLogger
{
    protected static $LOGS = [];

    public static function info(Config $config, $log)
    {
        self::log($config, array_merge(['type' => 'info', 'group' => 'YOOessentials'], $log));

        return false;
    }

    public static function error(Config $config, $log)
    {
        self::log($config, array_merge(['type' => 'error'], $log));

        return false;
    }

    public static function print(Metadata $metadata)
    {
        if ($script = self::buildPrintScript()) {
            $metadata->set('script:yooessentials-logs', $script);
        }
    }

    public static function alert(Metadata $metadata)
    {
        if ($script = self::buildAlertScripts()) {
            $metadata->set('script:yooessentials-logs-alert', $script);
        }
    }

    protected static function log(Config $config, array $log)
    {
        if ($config('app.isCustomizer')) {
            self::$LOGS[] = $log;
        }
    }

    /**
     * Function that groups an array of associative arrays by some key.
     */
    protected static function groupBy(array $data, string $key)
    {
        $result = [];

        foreach ($data as $val) {
            if (array_key_exists($key, $val)) {
                $result[$val[$key]][] = $val;
            } else {
                $result[''][] = $val;
            }
        }

        return $result;
    }

    protected static function buildPrintScript(): ?string
    {
        if (empty(self::$LOGS)) {
            return null;
        }

        $script = '';

        foreach (self::groupBy(self::$LOGS, 'group') as $group => $logs) {
            if ($group) {
                $script .= "console.groupCollapsed('$group');";
            }

            foreach ($logs as $log) {
                $script .= sprintf("console.%s('%s', %s);", $log['type'], $log['label'] ?? Str::upperFirst($log['type']), json_encode(Arr::omit($log, [
                    'type',
                    'label',
                    'group'
                ])));
            }

            if ($group) {
                $script .= 'console.groupEnd();';
            }
        }

        return $script;
    }

    protected static function buildAlertScripts(): ?string
    {
        $errors = array_filter(self::$LOGS, function ($log) {
            return $log['type'] === 'error';
        });

        if (empty($errors)) {
            return null;
        }

        $error = array_shift($errors);

        $script = "document.addEventListener('DOMContentLoaded', function() {
            UIkit.modal.alert(`
                <p class=\"uk-text-lead\">Sorry, there is an error executing an Essentials feature.</p>
                <p class=\"uk-text-danger\">%s</p>
                <div class=\"uk-overflow-auto\">
                    <pre class=\"uk-height-medium\" style=\"background-color: white;\">%s</pre>
                </div>
            `);
        });";

        $errorRef = $error['error'] ?? '';
        $errorDump = json_encode(Arr::omit($error, [
            'error',
            'type',
            'group'
        ]), JSON_PRETTY_PRINT);

        $errorDump = str_replace('`', '\'', $errorDump);

        return sprintf($script, $errorRef, $errorDump);
    }
}
