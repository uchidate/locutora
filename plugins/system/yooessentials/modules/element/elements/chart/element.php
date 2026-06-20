<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Element\Chart;

require_once __DIR__ . '/helper.php';

use function YOOtheme\app;
use YOOtheme\Arr;
use YOOtheme\Metadata;
use ZOOlanders\YOOessentials\Util\Prop;

return [

    'transforms' => [

        'render' => function ($node) {

            /**
             * @var Metadata $metadata
             */
            $metadata = app(Metadata::class);

            $metadata->set('script:yooessentials-chart', ['src' => '~yooessentials_url/modules/element/elements/chart/assets/chart.min.js', 'defer' => true]);
            $metadata->set('style:yooessentials-chart', ['href' => '~yooessentials_url/modules/element/elements/chart/assets/chart.css']);

            // get filtered props, without prefix and
            $props = Prop::filterByPrefix($node->props, ['chart_', 'title_', 'legend_', 'labels_', 'tooltips_', 'animation_']);

            // filter out any default or empty value
            $props['chart'] = array_diff_assoc($props['chart'], ChartHelper::chartDefaults['globals']);
            $props['title'] = array_diff_assoc($props['title'], ChartHelper::chartDefaults['title']);
            $props['legend'] = array_diff_assoc($props['legend'], ChartHelper::chartDefaults['legend']);
            $props['labels'] = array_diff_assoc($props['labels'], ChartHelper::chartDefaults['labels']);
            $props['tooltips'] = array_diff_assoc($props['tooltips'], ChartHelper::chartDefaults['tooltips']);
            $props['animation'] = array_diff_assoc($props['animation'], ChartHelper::chartDefaults['animation']);

            foreach ($props as $key => $values) {
                $props[$key] = ChartHelper::filterEmpty($values);
            }

            // fix title display
            if ($props['title']['enabled'] ?? false) {
                $props['title']['display'] = $props['title']['enabled'];
                unset($props['title']['enabled']);
            }

            $labels = [];
            $datasets = [];

            foreach ($node->children as $datasetNode) {
                $data = [];
                $borderColors = [];
                $backgroundColors = [];

                $dataset = Prop::filterByPrefix($datasetNode->props, 'dataset_');
                $dataset = ChartHelper::filterEmpty($dataset);
                $dataset = array_diff_assoc($dataset, ChartHelper::chartDefaults['dataset']);

                $datasetType = $dataset['type'] ?? $props['chart']['type'];

                foreach ($datasetNode->children ?? [] as $index => $dataNode) {
                    $label = $dataNode->props['label'];
                    $data[$label] = (float) $dataNode->props['data'];
                    $labels[$label] = trim($label);

                    $borderColors[$index] = (string) ($dataNode->props['borderColor'] ?? $dataset['borderColor'] ?? null);
                    $backgroundColors[$index] = (string) ($dataNode->props['backgroundColor'] ?? $dataset['backgroundColor'] ?? null);
                }

                if ($datasetType === 'line') {
                    // line chart does not support multi colors
                    $borderColors = $dataset['borderColor'] ?? null;
                    $backgroundColors = $dataset['backgroundColor'] ?? null;
                } else {
                    // if no color variations, set as single value
                    $borderColors = ChartHelper::singlefy($borderColors);
                    $backgroundColors = ChartHelper::singlefy($backgroundColors);
                }

                $dataset = array_merge($dataset, [
                    'data' => $data,
                    'label' => $dataset['label'] ?? '',
                    'borderColor' => !empty($borderColors) ? $borderColors : null,
                    'backgroundColor' => !empty($backgroundColors) ? $backgroundColors : null
                ]);

                $datasets[] = ChartHelper::filterEmpty($dataset);
            }

            // Key data by their labels
            foreach ($datasets as &$dataset) {
                $data = array_fill_keys(array_values($labels), null);

                foreach ($dataset['data'] ?? [] as $label => $value) {
                    $data[trim($label)] = $value;
                }

                $dataset['data'] = array_values($data);
            }

            $props = ChartHelper::filterEmpty($props);

            $node->chart = (object) [
                'config' => array_merge($props['chart'], Arr::pick($props, ['tooltips', 'animation', 'title', 'legend', 'labels'])),
                'datasets' => $datasets,
                'labels' => array_values($labels)
            ];
        },

    ],
];
