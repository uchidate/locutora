<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Source\Resolver\Filters;

use ZOOlanders\YOOessentials\Sources\Database\DatabaseSource;

class DatabaseFilters extends Filters
{
    /**
     * @var DatabaseSource
     */
    private $source;

    public function __construct(array $filters, DatabaseSource $source)
    {
        $this->source = $source;

        parent::__construct($filters);
    }

    protected function createFilter(array $filter): DatabaseFilter
    {
        return new DatabaseFilter($filter, $this->source);
    }
}
