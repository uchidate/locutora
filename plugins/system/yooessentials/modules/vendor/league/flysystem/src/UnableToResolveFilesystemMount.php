<?php

declare (strict_types=1);
namespace ZOOlanders\YOOessentials\Vendor\League\Flysystem;

use RuntimeException;
class UnableToResolveFilesystemMount extends \RuntimeException implements \ZOOlanders\YOOessentials\Vendor\League\Flysystem\FilesystemException
{
    public static function becauseTheSeparatorIsMissing(string $path) : \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToResolveFilesystemMount
    {
        return new \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToResolveFilesystemMount("Unable to resolve the filesystem mount because the path ({$path}) is missing a separator (://).");
    }
    public static function becauseTheMountWasNotRegistered(string $mountIdentifier) : \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToResolveFilesystemMount
    {
        return new \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToResolveFilesystemMount("Unable to resolve the filesystem mount because the mount ({$mountIdentifier}) was not registered.");
    }
}
