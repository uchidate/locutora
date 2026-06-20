<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

use YOOtheme\Arr;
use YOOtheme\File;
use YOOtheme\Str;
use ZOOlanders\YOOessentials\Source\SourceService;
use ZOOlanders\YOOessentials\Sources\Csv\CsvSource;

return [

    'nodes' => [

        // convert filters source to source_extended custom prop query
        '1.7.0-beta.4' => function ($node) {
            if (!Str::startsWith($node->source->query->name ?? '', ['databaseRecord', 'fileCSV'])) {
                return;
            }

            foreach (['filters', 'ordering'] as $arg) {
                foreach ($node->source->query->arguments->{$arg} ?? [] as $condition) {
                    if (!isset($condition->source->query)) {
                        continue;
                    }

                    $condition->source_extended = (object) ['props' => (object) []];

                    foreach ($condition->source->props ?? [] as $name => $prop) {
                        $prop->query = $condition->source->query;
                        $condition->source_extended->props->{$name} = $prop;
                    }

                    unset($condition->source);
                }
            }
        }

    ],

    'config' => [

        '1.6.0-beta' => function ($config) {
            $sources = Arr::get($config, SourceService::SOURCES_CONFIG_KEY, []);

            if (empty($sources)) {
                return $config;
            }

            // remove corrupted data from source config
            foreach ($sources as $i => $sourceConfig) {
                $sources[$i] = array_filter($sourceConfig, function ($key) {
                    return !is_int($key);
                }, ARRAY_FILTER_USE_KEY);
            }

            // remove any invalid source
            $sources = array_values(array_filter($sources, function ($value) {
                return array_key_exists('provider', $value);
            }));

            // add ID to sources created before the id standard
            foreach ($sources as &$sourceConfig) {
                $createdOn = $sourceConfig['_meta']['created_on'] ?? null;

                if ($createdOn !== null) {
                    continue;
                }

                switch ($sourceConfig['provider']) {
                    case 'csv':
                        $source = new CsvSource($sourceConfig);

                        $file = $source->config('file');

                        if ($file and !Str::startsWith($file, '~')) {
                            $file = "~/$file";
                        }

                        if (!File::exists($file)) {
                            $file = null;
                        }

                        $sourceConfig['id'] = sha1($file);

                        break;
                    case 'instagram':
                        $sourceConfig['id'] = ($sourceConfig['user_id'] ?? '').($sourceConfig['page_id'] ?? '');

                        break;
                    case 'google_sheet':
                        $sourceConfig['id'] = $sourceConfig['sheet_id'] ?? '';

                        break;
                    case 'database':
                        $sourceConfig['id'] = sha1(json_encode($sourceConfig));

                        break;
                    default:
                        $sourceConfig['id'] = uniqid();

                        break;
                }
            }

            // rename user_id as account
            foreach ($sources as &$sourceConfig) {
                if (!in_array($sourceConfig['provider'], ['google_sheet', 'instagram'])) {
                    continue;
                }

                if (isset($sourceConfig['user_id'])) {
                    $sourceConfig['account'] = $sourceConfig['user_id'];
                    unset($sourceConfig['user_id']);
                }
            }

            Arr::set($config, SourceService::SOURCES_CONFIG_KEY, $sources);

            return $config;
        }

    ]

];
