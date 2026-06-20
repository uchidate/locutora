<?php

declare (strict_types=1);
namespace ZOOlanders\YOOessentials\Vendor\League\Flysystem;

final class PortableVisibilityGuard
{
    public static function guardAgainstInvalidInput(string $visibility) : void
    {
        if ($visibility !== \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Visibility::PUBLIC && $visibility !== \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Visibility::PRIVATE) {
            $className = \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Visibility::class;
            throw \ZOOlanders\YOOessentials\Vendor\League\Flysystem\InvalidVisibilityProvided::withVisibility($visibility, "either {$className}::PUBLIC or {$className}::PRIVATE");
        }
    }
}
