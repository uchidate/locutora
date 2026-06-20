<?php

namespace ZOOlanders\YOOessentials\Vendor\League\Flysystem;

use RuntimeException;
final class CorruptedPathDetected extends \RuntimeException implements \ZOOlanders\YOOessentials\Vendor\League\Flysystem\FilesystemException
{
    public static function forPath(string $path) : \ZOOlanders\YOOessentials\Vendor\League\Flysystem\CorruptedPathDetected
    {
        return new \ZOOlanders\YOOessentials\Vendor\League\Flysystem\CorruptedPathDetected("Corrupted path detected: " . $path);
    }
}
