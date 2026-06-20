<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Source\Resolver\Filters;

use YOOtheme\Event;
use ZOOlanders\YOOessentials\Util\Arr;

abstract class Filters
{
    /**
     * @var Filter[]
     */
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = Arr::map(Arr::filter($filters), function (array $filter) {
            return $this->createFilter($filter);
        });
    }

    public function enabled(): array
    {
        return Arr::filter($this->filters, function (Filter $filter) {
            try {
                $filter->validate();
            } catch (InvalidFilterException $e) {
                Event::emit('yooessentials.info', [
                    'group' => 'YOOessentials Invalid Filter - Disabled',
                    'addon' => 'source',
                    'error' => $e->getMessage(),
                ]);

                return false;
            }

            return $filter->enabled();
        });
    }

    /**
     * @param array $filter
     * @return Filter
     */
    protected function createFilter(array $filter)
    {
        return new InMemoryFilter($filter);
    }
}
