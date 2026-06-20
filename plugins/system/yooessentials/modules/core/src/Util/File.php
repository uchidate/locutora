<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Util;

use function YOOtheme\app;
use YOOtheme\HttpClientInterface;
use YOOtheme\Path;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\Mime\MimeTypes;

abstract class File
{
    public static function getMimeType(string $path): ?string
    {
        $mimeTypes = new MimeTypes();
        $mimeType = $mimeTypes->guessMimeType($path);
        $extensionMimeTypes = $mimeTypes->getMimeTypes(\YOOtheme\File::getExtension($path));

        // If we have a better match using the guessed mime type, but it's still a valid one
        if ($mimeType !== null && in_array($mimeType, $extensionMimeTypes)) {
            return $mimeType;
        }

        // We can't guess, let YTP guess
        if (count($extensionMimeTypes) <= 0) {
            return \YOOtheme\File::getMimetype($path);
        }

        // based on file estension
        return array_shift($extensionMimeTypes);
    }

    /**
     * @param mixed $size
     */
    public static function toBytes($size): float
    {
        $value = $size;
        $units = ['b', 'kb', 'mb', 'gb', 'tb', 'pb', 'eb', 'zb', 'yb'];

        foreach ($units as $exponent => $unit) {
            if (!preg_match('/^(\d+(.\d+)?)' . $unit . '$/i', (string) $size, $matches)) {
                continue;
            }
            $value = $matches[1] * 1024 ** $exponent;

            break;
        }

        return (float) $value;
    }

    /**
     * Get the next available file name under a certain path
     */
    public static function getUniqueFilepath(string $path): string
    {
        $count = 0;

        while (\YOOtheme\File::exists($path)) {
            if ($p = '/_(\d+)(\.[^\/]+)$/' and preg_match($p, $path, $matches)) {
                $count = (int) $matches[1];
                $path = preg_replace($p, '\2', $path);
            }

            $count++;
            $path = preg_replace('/([^\/]+)(\.[^\/]+)$/', '\1_' . $count . '\2', $path);
        }

        return $path;
    }

    /**
     * Download and cache locally an image from url
     */
    public static function cacheMedia(string $url, string $cacheKey = null): string
    {
        if (empty($url)) {
            return $url;
        }

        $cacheKey = $cacheKey ?: 'media-' . sha1($url);
        $rootDir = app()->config->get('app.rootDir');
        $cacheDir = app()->config->get('image.cacheDir') . '/yooessentials';
        $extension = Path::extname(parse_url($url, PHP_URL_PATH)) ?? '';

        $filename = "{$cacheDir}/{$cacheKey}{$extension}";

        if (!\YOOtheme\File::exists($filename)) {
            $client = app(HttpClientInterface::class);

            if (!\YOOtheme\File::makeDir($cacheDir, 0777, true)) {
                throw new \Exception('Failed to create temp folder.');
            }

            $result = $client->get($url);

            try {
                \YOOtheme\File::putContents($filename, (string) $result->getBody());
            } catch (\Exception $e) {
                // Some connection exception happened (Ig unavailable, local img, whatever)
                return $url;
            }
        }

        return Path::relative($rootDir, $filename);
    }

    /**
     * Format bytes to kb, mb, gb, tb
     */
    public static function formatBytes(int $size, int $precision = 2): string
    {
        if ($size <= 0) {
            return $size;
        }

        $size = (int) $size;
        $base = log($size) / log(1024);
        $suffixes = [' bytes', ' KB', ' MB', ' GB', ' TB'];

        return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
    }
}
