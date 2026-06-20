<?php

declare (strict_types=1);
namespace ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnixVisibility;

use ZOOlanders\YOOessentials\Vendor\League\Flysystem\PortableVisibilityGuard;
use ZOOlanders\YOOessentials\Vendor\League\Flysystem\Visibility;
class PortableVisibilityConverter implements \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnixVisibility\VisibilityConverter
{
    /**
     * @var int
     */
    private $filePublic;
    /**
     * @var int
     */
    private $filePrivate;
    /**
     * @var int
     */
    private $directoryPublic;
    /**
     * @var int
     */
    private $directoryPrivate;
    /**
     * @var string
     */
    private $defaultForDirectories;
    public function __construct(int $filePublic = 0644, int $filePrivate = 0600, int $directoryPublic = 0755, int $directoryPrivate = 0700, string $defaultForDirectories = \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Visibility::PRIVATE)
    {
        $this->filePublic = $filePublic;
        $this->filePrivate = $filePrivate;
        $this->directoryPublic = $directoryPublic;
        $this->directoryPrivate = $directoryPrivate;
        $this->defaultForDirectories = $defaultForDirectories;
    }
    public function forFile(string $visibility) : int
    {
        \ZOOlanders\YOOessentials\Vendor\League\Flysystem\PortableVisibilityGuard::guardAgainstInvalidInput($visibility);
        return $visibility === \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Visibility::PUBLIC ? $this->filePublic : $this->filePrivate;
    }
    public function forDirectory(string $visibility) : int
    {
        \ZOOlanders\YOOessentials\Vendor\League\Flysystem\PortableVisibilityGuard::guardAgainstInvalidInput($visibility);
        return $visibility === \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Visibility::PUBLIC ? $this->directoryPublic : $this->directoryPrivate;
    }
    public function inverseForFile(int $visibility) : string
    {
        if ($visibility === $this->filePublic) {
            return \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Visibility::PUBLIC;
        } elseif ($visibility === $this->filePrivate) {
            return \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Visibility::PRIVATE;
        }
        return \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Visibility::PUBLIC;
        // default
    }
    public function inverseForDirectory(int $visibility) : string
    {
        if ($visibility === $this->directoryPublic) {
            return \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Visibility::PUBLIC;
        } elseif ($visibility === $this->directoryPrivate) {
            return \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Visibility::PRIVATE;
        }
        return \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Visibility::PUBLIC;
        // default
    }
    public function defaultForDirectories() : int
    {
        return $this->defaultForDirectories === \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Visibility::PUBLIC ? $this->directoryPublic : $this->directoryPrivate;
    }
    /**
     * @param array<mixed>  $permissionMap
     */
    public static function fromArray(array $permissionMap, string $defaultForDirectories = \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Visibility::PRIVATE) : \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnixVisibility\PortableVisibilityConverter
    {
        return new \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnixVisibility\PortableVisibilityConverter($permissionMap['file']['public'] ?? 0644, $permissionMap['file']['private'] ?? 0600, $permissionMap['dir']['public'] ?? 0755, $permissionMap['dir']['private'] ?? 0700, $defaultForDirectories);
    }
}
