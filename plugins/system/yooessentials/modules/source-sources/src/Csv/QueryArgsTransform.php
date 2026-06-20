<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Csv;

use YOOtheme\Str;

class QueryArgsTransform
{
    /**
     * Render callback.
     *
     * @param object $node
     * @param array  $params
     */
    public function __invoke($node, array $params = []): bool
    {
        $queryName = $node->source->query->name ?? '';

        if (!Str::startsWith($queryName, 'fileCSV')) {
            return true;
        }

        foreach ($node->source->query->arguments->filters ?? [] as &$condition) {
            if (isset($condition->source)) {
                $condition->source = json_encode($condition->source);
            }
        }

        foreach ($node->source->query->arguments->ordering ?? [] as &$condition) {
            if (isset($condition->source)) {
                $condition->source = json_encode($condition->source);
            }
        }

        return true;
    }
}
