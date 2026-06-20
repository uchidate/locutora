<?php

declare (strict_types=1);
namespace ZOOlanders\YOOessentials\Vendor\League\Flysystem;

use LogicException;
class UnableToMountFilesystem extends \LogicException implements \ZOOlanders\YOOessentials\Vendor\League\Flysystem\FilesystemException
{
    /**
     * @param mixed $key
     */
    public static function becauseTheKeyIsNotValid($key) : \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToMountFilesystem
    {
        return new \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToMountFilesystem('Unable to mount filesystem, key was invalid. String expected, received: ' . \gettype($key));
    }
    /**
     * @param mixed $filesystem
     */
    public static function becauseTheFilesystemWasNotValid($filesystem) : \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToMountFilesystem
    {
        $received = \is_object($filesystem) ? \get_class($filesystem) : \gettype($filesystem);
        return new \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToMountFilesystem('Unable to mount filesystem, filesystem was invalid. Instance of ' . \ZOOlanders\YOOessentials\Vendor\League\Flysystem\FilesystemOperator::class . ' expected, received: ' . $received);
    }
}
