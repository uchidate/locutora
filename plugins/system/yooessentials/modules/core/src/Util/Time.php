<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Util;

abstract class Time
{
    public static function humanize(int $duration): string
    {
        $parsed = [
            's' => $duration % 60,
            'm' => floor(($duration % 3600) / 60),
            'h' => floor(($duration % 86400) / 3600),
            'd' => floor(($duration % 2592000) / 86400),
            'M' => floor($duration / 2592000),
        ];

        $result = array_filter($parsed);

        $result = array_map(function ($key, $v) {
            return "$v$key";
        }, array_keys($result), $result);

        return implode(' ', array_reverse($result));
    }
}
