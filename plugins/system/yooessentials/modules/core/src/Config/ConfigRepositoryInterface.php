<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Config;

use YOOtheme\Http\Request;

interface ConfigRepositoryInterface
{
    public function authorize(): bool;
    public function load(ConfigInterface $config): void;
    public function save(ConfigInterface $config): void;
    public function fromRequest(Request $request): ?array;
}
