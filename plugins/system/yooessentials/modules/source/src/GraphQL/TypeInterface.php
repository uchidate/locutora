<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Source\GraphQL;

interface TypeInterface
{
    public const TYPE_QUERY = 'query';
    public const TYPE_OBJECT = 'object';
    public const TYPE_INPUT = 'input';

    public function name(): string;

    public function label(): string;

    public function type(): string;

    public function config(): array;
}
