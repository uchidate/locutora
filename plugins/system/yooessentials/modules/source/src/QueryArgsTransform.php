<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Source;

use YOOtheme\Str;

class QueryArgsTransform
{
    /**
     * @var string
     */
    private $prefix;
    /**
     * @var array
     */
    private $args;

    public function __construct(string $prefix, array $args = ['filters', 'ordering'])
    {
        $this->prefix = $prefix;
        $this->args = $args;
    }

    /**
     * Render callback.
     *
     * @param object $node
     * @param array $params
     */
    public function __invoke($node, array $params = []): bool
    {
        $queryName = $node->source->query->name ?? '';

        if (!Str::startsWith($queryName, $this->prefix)) {
            return true;
        }

        foreach ($this->args as $arg) {
            foreach ($node->source->query->arguments->{$arg} ?? [] as &$condition) {
                if (isset($condition->source_extended)) {
                    $condition->source = json_encode($condition->source_extended);
                }
            }
        }

        return true;
    }
}
