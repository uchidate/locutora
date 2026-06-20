<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Source\Type;

use ZOOlanders\YOOessentials\Source\GraphQL\TypeInterface;

interface SourceInterface
{
    public function bind(array $config): SourceInterface;

    public function name(): string;

    /** @return array|TypeInterface[] */
    public function types(): array;

    public function config(?string $key = null, $default = null);

    public function metadata(): object;

    public function id(): string;
}
