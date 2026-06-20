<?php

namespace ZOOlanders\YOOessentials\Vendor\League\MimeTypeDetection;

class OverridingExtensionToMimeTypeMap implements \ZOOlanders\YOOessentials\Vendor\League\MimeTypeDetection\ExtensionToMimeTypeMap
{
    /**
     * @var ExtensionToMimeTypeMap
     */
    private $innerMap;
    /**
     * @var string[]
     */
    private $overrides;
    /**
     * @param array<string, string>  $overrides
     */
    public function __construct(\ZOOlanders\YOOessentials\Vendor\League\MimeTypeDetection\ExtensionToMimeTypeMap $innerMap, array $overrides)
    {
        $this->innerMap = $innerMap;
        $this->overrides = $overrides;
    }
    public function lookupMimeType(string $extension) : ?string
    {
        return $this->overrides[$extension] ?? $this->innerMap->lookupMimeType($extension);
    }
}
