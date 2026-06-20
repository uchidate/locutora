<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Config;

interface ConfigInterface
{
    public function has(string $key): bool;

    public function get(string $key, $default = null);

    public function set(string $key, $value);

    public function del(string $key);

    public function add(array $values);

    public function replace(array $values);

    public function toArray(): array;
}
