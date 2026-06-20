<?php

declare (strict_types=1);
namespace ZOOlanders\YOOessentials\Vendor\League\Flysystem;

use InvalidArgumentException;
use function var_export;
class InvalidVisibilityProvided extends \InvalidArgumentException implements \ZOOlanders\YOOessentials\Vendor\League\Flysystem\FilesystemException
{
    public static function withVisibility(string $visibility, string $expectedMessage) : \ZOOlanders\YOOessentials\Vendor\League\Flysystem\InvalidVisibilityProvided
    {
        $provided = \var_export($visibility, \true);
        $message = "Invalid visibility provided. Expected {$expectedMessage}, received {$provided}";
        throw new \ZOOlanders\YOOessentials\Vendor\League\Flysystem\InvalidVisibilityProvided($message);
    }
}
