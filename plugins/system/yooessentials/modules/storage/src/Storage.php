<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Storage;

use ZOOlanders\YOOessentials\Data;
use ZOOlanders\YOOessentials\Vendor\League\Flysystem\Filesystem;

class Storage extends Data
{
    /** @var StorageAdapterInterface|null */
    protected $adapter = null;

    /** @var Filesystem|null */
    protected $filesystem = null;

    public function id(): string
    {
        return $this->data['id'] ?? uniqid();
    }

    public function writable(): bool
    {
        return $this->data['writable'] ?? true;
    }

    public function withAdapter(StorageAdapterInterface $adapter): self
    {
        $this->adapter = $adapter;

        return $this;
    }

    public function filesystem(): ?Filesystem
    {
        if ($this->filesystem) {
            return $this->filesystem;
        }

        if ($this->adapter()) {
            $this->filesystem = $this->adapter()->filesystem($this->data);
        }

        return $this->filesystem;
    }

    public function adapter(): ?StorageAdapterInterface
    {
        return $this->adapter;
    }

    public function adapterName(): string
    {
        return $this->adapter() ? $this->adapter()->name() : $this->data['adapter'] ?? '';
    }

    public function cacheKey(): string
    {
        $configHash = sha1(json_encode($this->data));

        return "yooessentials-storage-{$this->id()}-{$configHash}";
    }
}
