<?php

declare (strict_types=1);
namespace ZOOlanders\YOOessentials\Vendor\League\Flysystem;

use RuntimeException;
use Throwable;
class UnableToCheckFileExistence extends \RuntimeException implements \ZOOlanders\YOOessentials\Vendor\League\Flysystem\FilesystemOperationFailed
{
    public static function forLocation(string $path, \Throwable $exception = null) : \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToCheckFileExistence
    {
        return new \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToCheckFileExistence("Unable to check file existence for: {$path}", 0, $exception);
    }
    public function operation() : string
    {
        return \ZOOlanders\YOOessentials\Vendor\League\Flysystem\FilesystemOperationFailed::OPERATION_FILE_EXISTS;
    }
}
