<?php

declare (strict_types=1);
namespace ZOOlanders\YOOessentials\Vendor\League\Flysystem;

use RuntimeException;
use Throwable;
final class UnableToMoveFile extends \RuntimeException implements \ZOOlanders\YOOessentials\Vendor\League\Flysystem\FilesystemOperationFailed
{
    /**
     * @var string
     */
    private $source;
    /**
     * @var string
     */
    private $destination;
    public function source() : string
    {
        return $this->source;
    }
    public function destination() : string
    {
        return $this->destination;
    }
    public static function fromLocationTo(string $sourcePath, string $destinationPath, \Throwable $previous = null) : \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToMoveFile
    {
        $e = new static("Unable to move file from {$sourcePath} to {$destinationPath}", 0, $previous);
        $e->source = $sourcePath;
        $e->destination = $destinationPath;
        return $e;
    }
    public function operation() : string
    {
        return \ZOOlanders\YOOessentials\Vendor\League\Flysystem\FilesystemOperationFailed::OPERATION_MOVE;
    }
}
