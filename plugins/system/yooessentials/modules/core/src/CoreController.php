<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials;

use YOOtheme\Builder\Source;
use YOOtheme\Config;
use YOOtheme\File;
use YOOtheme\Http\Message\Stream;
use YOOtheme\Http\Response;
use ZOOlanders\YOOessentials\Config as EssentialsConfig;
use ZOOlanders\YOOessentials\Util\Arr;

class CoreController
{
    public const GET_CHANGELOG_URL = 'yooessentials/changelog';
    public const GET_TABLE_COLUMNS_ENDPOINT = 'yooessentials/core/table/columns';
    public const DOWNLOAD_DEBUG_DATA_URL = 'yooessentials/debug/data';

    public function getChangelog(Response $response): Response
    {
        return $response->withFile(File::get('~yooessentials/CHANGELOG.md'));
    }

    public function downloadDebugData(Config $config, Source $source, EssentialsConfig $essentialsConfig, DatabaseManager $db): BinaryFileResponse
    {
        $filename = 'debug.zip';
        $filepath = $config->get('app.tempDir') . '/' . $filename;

        $zip = new \ZipArchive();
        $zip->open($filepath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        $zip->addFromString('config.json', json_encode($this->config($config), JSON_PRETTY_PRINT));
        $zip->addFromString('essentials-config.json', json_encode($essentialsConfig->toArray(), JSON_PRETTY_PRINT));
        $zip->addFromString('server.json', json_encode($this->serverInfo($config, $db), JSON_PRETTY_PRINT));
        $zip->addFromString('schema.json', json_encode($this->jsonSchema($source), JSON_PRETTY_PRINT));
        $zip->addFromString('schema.gql', $this->schemaFile($config));

        $zip->close();

        $contents = file_get_contents($filepath);
        unlink($filepath);

        $body = Stream::create($contents);

        return (new BinaryFileResponse())
            ->withHeader('Content-Type', 'application/zip')
            ->withHeader('Content-Length', $body->getSize())
            ->setContentDisposition(BinaryFileResponse::DISPOSITION_ATTACHMENT, $filename)
            ->withBody($body);
    }

    private function jsonSchema(Source $source): array
    {
        $result = $source->queryIntrospection()->toArray();

        return $result['data']['__schema'] ?? $result;
    }

    private function schemaFile(Config $config): string
    {
        $dir = $config('image.cacheDir');
        $id = $config('source.id');

        $file = "{$dir}/schema-{$id}.gql";

        if (!File::exists($file)) {
            $file = "{$dir}/schema-{$id}.error.gql";
        }

        if (!File::exists($file)) {
            return '';
        }

        return file_get_contents($file);
    }

    private function serverInfo(Config $config, DatabaseManager $db): array
    {
        return [
            'php' => [
                'version' => php_sapi_name(),
                'safe_mode' => ini_get('safe_mode') == '1',
                'display_errors' => ini_get('display_errors') == '1',
                'short_open_tag' => ini_get('short_open_tag') == '1',
                'file_uploads' => ini_get('file_uploads') == '1',
                'magic_quotes_gpc' => ini_get('magic_quotes_gpc') == '1',
                'register_globals' => ini_get('register_globals') == '1',
                'output_buffering' => (int) ini_get('output_buffering') !== 0,
                'open_basedir' => ini_get('open_basedir'),
                'session.save_path' => ini_get('session.save_path'),
                'session.auto_start' => ini_get('session.auto_start'),
                'disable_functions' => ini_get('disable_functions'),
                'xml' => extension_loaded('xml'),
                'zlib' => extension_loaded('zlib'),
                'zip' => function_exists('zip_open') && function_exists('zip_read'),
                'mbstring' => extension_loaded('mbstring'),
                'iconv' => function_exists('iconv'),
                'max_input_vars' => ini_get('max_input_vars'),
            ],
            'db' => [
                'server' => $db->type(),
                'version' => $db->serverVersion(),
                'collation' => $db->collation(),
                'connectioncollation' => $db->connectionCollation(),
            ],
            'server' => Arr::pick($config->get('server', []), [
                'HTTPS',
                'SERVER_SOFTWARE',
                'GATEWAY_INTERFACE',
                'SERVER_PROTOCOL',
                'SERVER_NAME',
                'SERVER_PORT',
                'SERVER_ADDR',
                'REMOTE_PORT',
                'REMOTE_ADDR',
                'SERVER_SOFTWARE',
                'GATEWAY_INTERFACE',
                'SERVER_PROTOCOL',
                'DOCUMENT_ROOT',
                'DOCUMENT_URI',
            ]),
        ];
    }

    private function config(Config $config): array
    {
        return [
            'app' => Arr::omit($config('app'), [
                'secret',
                'apikey'
            ]) + [
                'apikey' => (bool) $config('app.apikey')
            ],
            'locale' => $config('locale'),
            'yooessentials' => $config('yooessentials'),
            'theme' => $config('theme'),
            '~theme' => $config('~theme'),
        ];
    }
}
