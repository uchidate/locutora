<?php

declare (strict_types=1);
namespace ZOOlanders\YOOessentials\Vendor\League\Flysystem;

use RuntimeException;
use Throwable;
use function rtrim;
final class UnableToSetVisibility extends \RuntimeException implements \ZOOlanders\YOOessentials\Vendor\League\Flysystem\FilesystemOperationFailed
{
    /**
     * @var string
     */
    private $location;
    /**
     * @var string
     */
    private $reason;
    public function reason() : string
    {
        return $this->reason;
    }
    public static function atLocation(string $filename, string $extraMessage = '', \Throwable $previous = null) : self
    {
        $message = "Unable to set visibility for file {$filename}. {$extraMessage}";
        $e = new static(\rtrim($message), 0, $previous);
        $e->reason = $extraMessage;
        $e->location = $filename;
        return $e;
    }
    public function operation() : string
    {
        return \ZOOlanders\YOOessentials\Vendor\League\Flysystem\FilesystemOperationFailed::OPERATION_SET_VISIBILITY;
    }
    public function location() : string
    {
        return $this->location;
    }
}
