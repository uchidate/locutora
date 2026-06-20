<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Source\GraphQL;

abstract class AbstractQueryType extends AbstractType implements TypeInterface
{
    public const DEFAULT_CACHE_TIME = 3600;

    public function type(): string
    {
        return TypeInterface::TYPE_QUERY;
    }

    public function label(): string
    {
        return $this->source()->name();
    }
}
