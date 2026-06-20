<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form\Actions\SaveCsv;

use YOOtheme\File;
use YOOtheme\Path;
use YOOtheme\Str;
use ZOOlanders\YOOessentials\Util;

trait InteractsWithCsv
{
    private static function resolveCsvPath(object $config): string
    {
        $file = $config->file ?? null;

        if (!$file) {
            throw new \RuntimeException('File is not set.');
        }

        if (!Str::startsWith($file, '~') && !Str::startsWith($file, '/')) {
            $file = "~/$file";
        }

        if (!File::exists($file)) {
            throw new \RuntimeException('Specified File does not exists.');
        }

        return Path::resolve($file);
    }

    private static function readCsvHeader(object $config)
    {
        $filepath = self::resolveCsvPath($config);

        $separator = self::separator($config);
        $enclosure = self::enclosure($config);

        $handle = fopen($filepath, 'r');
        $header = fgetcsv($handle, null, $separator, $enclosure);

        fclose($handle);

        if (!$header) {
            throw new \RuntimeException('File is missing header.');
        }

        return $header;
    }

    private static function writeCsv(array $data, object $config): void
    {
        $filepath = self::resolveCsvPath($config);
        $separator = self::separator($config);
        $enclosure = self::enclosure($config);

        self::checkLastLineEnding($filepath);

        $handle = fopen($filepath, 'a+');

        fputcsv($handle, $data, $separator, $enclosure);
        fclose($handle);
    }

    private static function separator(object $config): string
    {
        return Util\Prop::parseString($config, 'separator', ',', 1);
    }

    private static function enclosure(object $config): string
    {
        return Util\Prop::parseString($config, 'enclosure', '"', 1);
    }

    private static function checkLastLineEnding(string $filepath): void
    {
        $file = fopen($filepath, 'r');
        fseek($file, -1, SEEK_END);

        $char = fgetc($file);

        if ($char === "\n" || $char === "\r") {
            return;
        }

        $file = fopen($filepath, 'a+');
        fwrite($file, "\n");
        fclose($file);
    }
}
