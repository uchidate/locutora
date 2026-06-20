<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Element\Chart;

use YOOtheme\Arr;

abstract class ChartHelper
{
    const chartDefaults = [
        'globals' => [
            'deferred' => false,
            'beginAtZero' => false,
            'fontFamily' => "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
        ],
        'legend' => [
            'display' => true
        ],
        'tooltips' => [
            'display' => true,
            'displayColors' => true,
            'backgroundColor' => 'rgba(0, 0, 0, 0.8)',
            'borderColor' => 'rgba(0, 0, 0, 0)',
            'borderWidth' => 0
        ],
        'animation' => [
            'duration' => 1000,
            'easing' => 'easeOutQuart'
        ],
        'title' => [
            'display' => true,
            'position' => 'top',
            'fontSize' => 12,
            'fontColor' => '#666',
            'fontFamily' => "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif"
        ],
        'labels' => [
            'display' => true,
            'fontSize' => 12,
            'fontColor' => '#666',
            'fontFamily' => "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif"
        ],
        'dataset' => [
            'type' => '',
            'fill' => true,
            'showLine' => true
        ]
    ];

    public static function filterEmpty(array &$values)
    {
        return Arr::filter($values, function ($v) {
            return is_array($v)
                ? count($v)
                : !is_null($v);
        });
    }

    public static function singlefy($v)
    {
        if ($unique = array_unique($v) and count($unique) === 1) {
            return $unique[0];
        }

        return $v;
    }
}
