<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Source\Resolver\Orders;

use ZOOlanders\YOOessentials\DatabaseQuery;
use ZOOlanders\YOOessentials\Source\Type\SourceInterface;
use ZOOlanders\YOOessentials\Sources\Database\DatabaseSource;
use ZOOlanders\YOOessentials\Sources\Database\Table\DatabaseResolver;

class DatabaseOrder extends Order
{
    /** @var SourceInterface|DatabaseSource */
    protected $source;

    public function __construct(array $config, DatabaseSource $source)
    {
        $this->source = $source;

        parent::__construct($config);
    }

    public function tableAlias(): string
    {
        return $this->config('table', $this->source->table());
    }

    public function apply(DatabaseQuery $query): DatabaseQuery
    {
        $field = DatabaseResolver::quoteNameStr([
            $this->tableAlias(),
            $this->field()
        ]);

        return $query->orderBy($field, $this->direction());
    }
}
