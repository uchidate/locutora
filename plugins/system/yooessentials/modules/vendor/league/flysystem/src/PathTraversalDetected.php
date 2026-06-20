<?php

declare (strict_types=1);
namespace ZOOlanders\YOOessentials\Vendor\League\Flysystem;

use RuntimeException;
class PathTraversalDetected extends \RuntimeException implements \ZOOlanders\YOOessentials\Vendor\League\Flysystem\FilesystemException
{
    /**
     * @var string
     */
    private $path;
    public function path() : string
    {
        return $this->path;
    }
    public static function forPath(string $path) : \ZOOlanders\YOOessentials\Vendor\League\Flysystem\PathTraversalDetected
    {
        $e = new \ZOOlanders\YOOessentials\Vendor\League\Flysystem\PathTraversalDetected("Path traversal detected: {$path}");
        $e->path = $path;
        return $e;
    }
}
