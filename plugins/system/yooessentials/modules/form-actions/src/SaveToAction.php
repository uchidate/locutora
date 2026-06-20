<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form\Actions;

abstract class SaveToAction extends StandardAction
{
    protected const DISABLED_STATUS = 'disabled';
    protected const DISABLED_VALUE = null;

    protected static function resolveData(array $content): array
    {
        $data = [];

        foreach ($content as $row) {
            $row = (array) $row;
            $col = $row['id'] ?? '';
            $value = $row['props']['value'] ?? '';
            $status = $row['props']['status'] ?? '';

            if ($status === self::DISABLED_STATUS) {
                $value = static::DISABLED_VALUE;
            }

            $data[$col] = $value;
        }

        $mapped = array_filter($data, function ($value) {
            return $value !== static::DISABLED_VALUE;
        });

        if (count($mapped) === 0) {
            throw new \RuntimeException('No data mapped, skipping action execution.');
        }

        foreach ($data as $col => $val) {
            if (is_array($val)) {
                throw new \RuntimeException(
                    sprintf("Invalid mapping for column '%s', multi values are not supported.", $col)
                );
            }
        }

        return $data;
    }

    protected static function sortDataFromHeaders(array $headers, array $data): array
    {
        $orderedData = [];
        $keysOrder = array_values($headers);

        foreach ($data as $key => $value) {
            $index = array_search($key, $keysOrder);
            $orderedData[$index ?? $key] = $value;
        }

        ksort($orderedData);

        return $orderedData;
    }
}
