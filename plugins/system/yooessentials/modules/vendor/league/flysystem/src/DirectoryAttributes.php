<?php

declare (strict_types=1);
namespace ZOOlanders\YOOessentials\Vendor\League\Flysystem;

class DirectoryAttributes implements \ZOOlanders\YOOessentials\Vendor\League\Flysystem\StorageAttributes
{
    use ProxyArrayAccessToProperties;
    /**
     * @var string
     */
    private $type = \ZOOlanders\YOOessentials\Vendor\League\Flysystem\StorageAttributes::TYPE_DIRECTORY;
    /**
     * @var string
     */
    private $path;
    /**
     * @var string|null
     */
    private $visibility;
    /**
     * @var int|null
     */
    private $lastModified;
    /**
     * @var array
     */
    private $extraMetadata;
    public function __construct(string $path, ?string $visibility = null, ?int $lastModified = null, array $extraMetadata = [])
    {
        $this->path = $path;
        $this->visibility = $visibility;
        $this->lastModified = $lastModified;
        $this->extraMetadata = $extraMetadata;
    }
    public function path() : string
    {
        return $this->path;
    }
    public function type() : string
    {
        return \ZOOlanders\YOOessentials\Vendor\League\Flysystem\StorageAttributes::TYPE_DIRECTORY;
    }
    public function visibility() : ?string
    {
        return $this->visibility;
    }
    public function lastModified() : ?int
    {
        return $this->lastModified;
    }
    public function extraMetadata() : array
    {
        return $this->extraMetadata;
    }
    public function isFile() : bool
    {
        return \false;
    }
    public function isDir() : bool
    {
        return \true;
    }
    public function withPath(string $path) : \ZOOlanders\YOOessentials\Vendor\League\Flysystem\StorageAttributes
    {
        $clone = clone $this;
        $clone->path = $path;
        return $clone;
    }
    public static function fromArray(array $attributes) : \ZOOlanders\YOOessentials\Vendor\League\Flysystem\StorageAttributes
    {
        return new \ZOOlanders\YOOessentials\Vendor\League\Flysystem\DirectoryAttributes($attributes[\ZOOlanders\YOOessentials\Vendor\League\Flysystem\StorageAttributes::ATTRIBUTE_PATH], $attributes[\ZOOlanders\YOOessentials\Vendor\League\Flysystem\StorageAttributes::ATTRIBUTE_VISIBILITY] ?? null, $attributes[\ZOOlanders\YOOessentials\Vendor\League\Flysystem\StorageAttributes::ATTRIBUTE_LAST_MODIFIED] ?? null, $attributes[\ZOOlanders\YOOessentials\Vendor\League\Flysystem\StorageAttributes::ATTRIBUTE_EXTRA_METADATA] ?? []);
    }
    /**
     * @inheritDoc
     */
    public function jsonSerialize() : array
    {
        return [\ZOOlanders\YOOessentials\Vendor\League\Flysystem\StorageAttributes::ATTRIBUTE_TYPE => $this->type, \ZOOlanders\YOOessentials\Vendor\League\Flysystem\StorageAttributes::ATTRIBUTE_PATH => $this->path, \ZOOlanders\YOOessentials\Vendor\League\Flysystem\StorageAttributes::ATTRIBUTE_VISIBILITY => $this->visibility, \ZOOlanders\YOOessentials\Vendor\League\Flysystem\StorageAttributes::ATTRIBUTE_LAST_MODIFIED => $this->lastModified, \ZOOlanders\YOOessentials\Vendor\League\Flysystem\StorageAttributes::ATTRIBUTE_EXTRA_METADATA => $this->extraMetadata];
    }
}
