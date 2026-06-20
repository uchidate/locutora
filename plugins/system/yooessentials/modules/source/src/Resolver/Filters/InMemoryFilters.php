<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Source\Resolver\Filters;

use ZOOlanders\YOOessentials\Source\Resolver\QueryMode;
use ZOOlanders\YOOessentials\Util\Arr;

class InMemoryFilters extends Filters
{
    /**
     * @var string
     */
    protected $mode;

    public function __construct(array $filters, string $mode = QueryMode::MODE_AND)
    {
        parent::__construct($filters);

        $this->mode = $mode;
    }

    public function apply(array $record): bool
    {
        if ($this->mode === QueryMode::MODE_AND) {
            return Arr::every($this->enabled(), function (InMemoryFilter $filter) use ($record) {
                return $filter->apply($record);
            });
        }

        return Arr::some($this->enabled(), function (InMemoryFilter $filter) use ($record) {
            return $filter->apply($record);
        });
    }
}
