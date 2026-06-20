<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Source\Resolver;

use ZOOlanders\YOOessentials\Source\Type\SourceInterface;

abstract class AbstractResolver implements SourceResolver, WithPagination
{
    use HasOffsetAndLimit, HasFilterAndOrderConditions;

    /**
     * @var SourceInterface
     */
    protected $source;

    public function __construct(SourceInterface $source, array $args = [], array $root = [])
    {
        $this->source = $source;

        $this->fromArgs($args, $root);
    }

    public function source(): SourceInterface
    {
        return $this->source;
    }
}
