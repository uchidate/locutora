<?php

declare (strict_types=1);
namespace ZOOlanders\YOOessentials\Vendor\League\MimeTypeDetection;

use const PATHINFO_EXTENSION;
class ExtensionMimeTypeDetector implements \ZOOlanders\YOOessentials\Vendor\League\MimeTypeDetection\MimeTypeDetector
{
    /**
     * @var ExtensionToMimeTypeMap
     */
    private $extensions;
    public function __construct(\ZOOlanders\YOOessentials\Vendor\League\MimeTypeDetection\ExtensionToMimeTypeMap $extensions = null)
    {
        $this->extensions = $extensions ?: new \ZOOlanders\YOOessentials\Vendor\League\MimeTypeDetection\GeneratedExtensionToMimeTypeMap();
    }
    public function detectMimeType(string $path, $contents) : ?string
    {
        return $this->detectMimeTypeFromPath($path);
    }
    public function detectMimeTypeFromPath(string $path) : ?string
    {
        $extension = \strtolower(\pathinfo($path, \PATHINFO_EXTENSION));
        return $this->extensions->lookupMimeType($extension);
    }
    public function detectMimeTypeFromFile(string $path) : ?string
    {
        return $this->detectMimeTypeFromPath($path);
    }
    public function detectMimeTypeFromBuffer(string $contents) : ?string
    {
        return null;
    }
}
