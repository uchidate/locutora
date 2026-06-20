<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Legacy\FormAction\SaveCsvLegacy;

use YOOtheme\File;
use YOOtheme\Path;
use YOOtheme\Str;
use ZOOlanders\YOOessentials\Form\Actions\StandardAction;
use ZOOlanders\YOOessentials\Form\Http\FormSubmissionResponse;
use ZOOlanders\YOOessentials\Legacy\FormAction\HasColumnConfig;
use ZOOlanders\YOOessentials\Util\Prop;

class SaveCsvAction extends StandardAction
{
    use HasColumnConfig;

    public const NAME = 'save-csv-legacy';

    public function __invoke(FormSubmissionResponse $response, callable $next): FormSubmissionResponse
    {
        $form = $response->submission()->form();
        $config = (object) $this->getConfig();
        $path = $config->path ?? null;
        $file = $config->file ?? null;

        if (!$path || !$file) {
            throw new \RuntimeException("SaveToCSV Legacy Action: missing 'path' and/or 'file' configuration.");
        }

        if (!Str::startsWith($path, '~')) {
            $path = "~/$path";
        }

        if (!File::exists($path) && !File::makeDir($path, 0755, true)) {
            throw new \RuntimeException('SaveToCSV Legacy Action: Cannot create directory ' . $path);
        }

        $config->enclosure = Prop::parseString($config, 'enclosure', '"', 1);
        $config->separator = Prop::parseString($config, 'separator', ',', 1);

        $controls = $form->controls();
        $columnsConfig = self::columnsConfig($config, $controls);
        $formData = self::flattenFormData($response->submission()->data());

        // map formData with columns order and configuration
        $data = array_reduce($columnsConfig['fields'], function ($carry, $field) use ($formData) {
            return array_merge($carry, [$formData[$field] ?? '']);
        }, []);

        $fileid = hash('crc32b', json_encode($columnsConfig['headers']));
        $filename = trim(basename($file ?? $form->id(), '.csv'), ' /');
        $filepath = Path::resolve($path, "$filename-$fileid.csv");

        self::writeHeader($filepath, $columnsConfig['headers'], $config->separator, $config->enclosure);

        $handle = fopen($filepath, 'a');
        fputcsv($handle, $data, $config->separator, $config->enclosure);
        fclose($handle);

        return $next($response->withDataLog([
            self::NAME => compact('config', 'filepath', 'columnsConfig', 'data')
        ]));
    }

    protected static function writeHeader(string $fullFileName, array $header, string $separator, string $enclosure): void
    {
        $handle = fopen($fullFileName, 'a+');
        $oldHeader = fgetcsv($handle);

        // empty file, just write header
        if (!$oldHeader) {
            fputcsv($handle, $header, $separator, $enclosure);
        }

        fclose($handle);
    }
}
