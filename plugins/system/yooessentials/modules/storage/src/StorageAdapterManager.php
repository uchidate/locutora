<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Storage;

class StorageAdapterManager
{
    protected $adapters = [];

    public function adapter(string $adapter): ?StorageAdapterInterface
    {
        return $this->adapters[$adapter] ?? null;
    }

    public function adapters(): array
    {
        return $this->adapters;
    }

    public function reset(): self
    {
        $this->adapters = [];

        return $this;
    }

    public function addAdapter(string $name, string $class, array $data): self
    {
        $this->adapters[$name] = new $class($data);

        return $this;
    }
}
