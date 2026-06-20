<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Legacy\FormAction;

use function YOOtheme\app;
use ZOOlanders\YOOessentials\Form\FormService;

trait HasColumnConfig
{
    protected static function columnsConfig(\stdClass $config, array $controls): array
    {
        $formService = app(FormService::class);

        $controls = array_filter($controls, function ($control) use ($formService) {
            return $formService->getControlType($control)->submittable ?? false;
        });

        $columns = !empty($config->columns)
            ? $config->columns
            : array_map(function ($control) {
                return [
                    'title' => $control['name'],
                    'field' => $control['name'],
                ];
            }, $controls);

        $columns = array_map(function ($control) {
            return (array) $control;
        }, array_filter($columns));

        return array_reduce($columns, function (array $carry, array $col) {
            $carry['headers'][] = !empty($col['title']) ? $col['title'] : ($col['field'] ?? $col);
            $carry['fields'][] = $col['field'] ?? $col;

            return $carry;
        }, ['headers' => [], 'fields' => []]);
    }

    protected static function flattenFormData(array $formData, string $rootKey = ''): array
    {
        $data = [];

        array_walk($formData, function ($value, $key) use (&$data, $rootKey) {
            $newKey = $key;
            if ($rootKey) {
                $newKey = $rootKey . ' ' . $newKey;
            }

            if (is_array($value)) {
                $data[$newKey] = implode(', ', self::flattenFormData($value));

                return;
            }

            $data[$newKey] = $value;
        });

        return $data;
    }

    protected static function fillEmptyKeys(array $columns, array $data): array
    {
        foreach ($columns as $column) {
            if (!isset($data[$column])) {
                $data[$column] = '';
            }
        }

        return $data;
    }
}
