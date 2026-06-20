<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Util;

class Arr extends \YOOtheme\Arr
{
    public static function map(array $array, $callback): array
    {
        return array_map($callback, $array);
    }

    public static function explodeList(string $value): array
    {
        return array_filter(explode(',', str_replace([' ', "\r", "\n"], ['', '', ','], $value)));
    }

    /**
     * Index an array by a key
     *
     * @param array|\ArrayAccess $array
     * @param string|callable $key
     *
     * @return array
     */
    public static function keyBy(array $array, $keyBy): array
    {
        $results = [];

        foreach ($array as $item) {
            $resolvedKey = self::resolveKey($item, $keyBy);

            if (is_null($resolvedKey)) {
                continue;
            }

            if (is_object($resolvedKey)) {
                $resolvedKey = (string) $resolvedKey;
            }

            $results[$resolvedKey] = $item;
        }

        return $results;
    }

    private static function resolveKey($item, $key)
    {
        if (is_callable($key)) {
            return $key($item);
        }

        if (is_array($item)) {
            return $item[$key] ?? null;
        }

        if (is_object($item)) {
            return $item->{$key} ?? null;
        }

        return null;
    }

    public static function trim(array $arr): array
    {
        return array_filter(array_map('trim', array_filter($arr)));
    }
}
