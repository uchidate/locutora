<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Rss\Type;

use ZOOlanders\YOOessentials\Source\GraphQL\TypeInterface;
use ZOOlanders\YOOessentials\Source\Type\InMemoryFilterType;

class RssFilterType extends InMemoryFilterType implements TypeInterface
{
    public const TYPE_LABEL = 'Rss Filter';
    public const TYPE_NAME = 'RssFilter';

    public function type(): string
    {
        return TypeInterface::TYPE_INPUT;
    }

    public function name(): string
    {
        return self::TYPE_NAME;
    }

    public function label(): string
    {
        return self::TYPE_LABEL;
    }
}
