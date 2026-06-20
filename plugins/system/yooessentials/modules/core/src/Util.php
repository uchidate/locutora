<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials;

class Util
{
    /**
     * Compiles a parsable string representation of a value.
     *
     * @param mixed    $value
     * @param callable $callback
     * @param int      $indent
     *
     * @return string
     */
    public static function compileValue($value, callable $callback = null, $indent = 0)
    {
        if (is_array($value)) {
            $array = [];
            $assoc = array_values($value) !== $value;
            $indention = str_repeat('  ', $indent);
            $indentlast = $assoc ? "\n" . $indention : '';

            foreach ($value as $key => $val) {
                $array[] = ($assoc ? "\n  " . $indention . var_export($key, true) . ' => ' : '') . self::compileValue($val, $callback, $indent + 1);
            }

            return '[' . join(', ', $array) . $indentlast . ']';
        }

        return $callback ? $callback($value) : var_export($value, true);
    }
}
