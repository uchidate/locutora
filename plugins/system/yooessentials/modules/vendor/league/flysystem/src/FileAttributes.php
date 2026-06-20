<?php

declare (strict_types=1);
namespace ZOOlanders\YOOessentials\Vendor\League\Flysystem;

class FileAttributes implements \ZOOlanders\YOOessentials\Vendor\League\Flysystem\StorageAttributes
{
    use ProxyArrayAccessToProperties;
    /**
     * @var string
     */
    private $type = \ZOOlanders\YOOessentials\Vendor\League\Flysystem\StorageAttributes::TYPE_FILE;
    /**
     * @var string
     */
    private $path;
    /**
     * @var int|null
     */
    private $fileSize;
    /**
     * @var string|null
     */
    private $visibility;
    /**
     * @var int|null
     */
    private $lastModified;
    /**
     * @var string|null
     */
    private $mimeType;
    /**
     * @var array
     */
    private $extraMetadata;
    public function __construct(string $path, ?int $fileSize = null, ?string $visibility = null, ?int $lastModified = null, ?string $mimeType = null, array $extraMetadata = [])
    {
        $this->path = $path;
        $this->fileSize = $fileSize;
        $this->visibility = $visibility;
        $this->lastModified = $lastModified;
        $this->mimeType = $mimeType;
        $this->extraMetadata = $extraMetadata;
    }
    public function type() : string
    {
        return $this->type;
    }
    public function path() : string
    {
        return $this->path;
    }
    public function fileSize() : ?int
    {
        return $this->fileSize;
    }
    public function visibility() : ?string
    {
        return $this->visibility;
    }
    public function lastModified() : ?int
    {
        return $this->lastModified;
    }
    public function mimeType() : ?string
    {
        return $this->mimeType;
    }
    public function extraMetadata() : array
    {
        return $this->extraMetadata;
    }
    public function isFile() : bool
    {
        return \true;
    }
    public function isDir() : bool
    {
        return \false;
    }
    public function withPath(string $path) : \ZOOlanders\YOOessentials\Vendor\League\Flysystem\StorageAttributes
    {
        $clone = clone $this;
        $clone->path = $path;
        return $clone;
    }
    public static function fromArray(array $attributes) : \ZOOlanders\YOOessentials\Vendor\League\Flysystem\StorageAttributes
    {
        return new \ZOOlanders\YOOessentials\Vendor\League\Flysystem\FileAttributes($attributes[\ZOOlanders\YOOessentials\Vendor\League\Flysystem\StorageAttributes::ATTRIBUTE_PATH], $attributes[\ZOOlanders\YOOessentials\Vendor\League\Flysystem\StorageAttributes::ATTRIBUTE_FILE_SIZE] ?? null, $attributes[\ZOOlanders\YOOessentials\Vendor\League\Flysystem\StorageAttributes::ATTRIBUTE_VISIBILITY] ?? null, $attributes[\ZOOlanders\YOOessentials\Vendor\League\Flysystem\StorageAttributes::ATTRIBUTE_LAST_MODIFIED] ?? null, $attributes[\ZOOlanders\YOOessentials\Vendor\League\Flysystem\StorageAttributes::ATTRIBUTE_MIME_TYPE] ?? null, $attributes[\ZOOlanders\YOOessentials\Vendor\League\Flysystem\StorageAttributes::ATTRIBUTE_EXTRA_METADATA] ?? []);
    }
    public function jsonSerialize() : array
    {
        return [\ZOOlanders\YOOessentials\Vendor\League\Flysystem\StorageAttributes::ATTRIBUTE_TYPE => self::TYPE_FILE, \ZOOlanders\YOOessentials\Vendor\League\Flysystem\StorageAttributes::ATTRIBUTE_PATH => $this->path, \ZOOlanders\YOOessentials\Vendor\League\Flysystem\StorageAttributes::ATTRIBUTE_FILE_SIZE => $this->fileSize, \ZOOlanders\YOOessentials\Vendor\League\Flysystem\StorageAttributes::ATTRIBUTE_VISIBILITY => $this->visibility, \ZOOlanders\YOOessentials\Vendor\League\Flysystem\StorageAttributes::ATTRIBUTE_LAST_MODIFIED => $this->lastModified, \ZOOlanders\YOOessentials\Vendor\League\Flysystem\StorageAttributes::ATTRIBUTE_MIME_TYPE => $this->mimeType, \ZOOlanders\YOOessentials\Vendor\League\Flysystem\StorageAttributes::ATTRIBUTE_EXTRA_METADATA => $this->extraMetadata];
    }
}
