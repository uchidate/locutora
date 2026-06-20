<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Access;

use ZOOlanders\YOOessentials\Logger;

class AccessTransform
{
    /**
     * @var AccessResolver
     */
    protected $resolver;

    public function __invoke(object $node, array $params = []): bool
    {
        $query = $node->props['yooessentials_access_mode'] ?? null;
        $conditions = $node->props['yooessentials_access_conditions'] ?? [];

        if (!$conditions) {
            return true;
        }

        // coerce to object
        $conditions = array_map(function ($condition) {
            return (object) $condition;
        }, $conditions);

        if ($query === Access::MODE_CUSTOM) {
            $query = $node->props['yooessentials_access_mode_query'] ?? null;
        }

        if (!$query) {
            $query = Access::MODE_AND;
        }

        $id = $node->id ?? null;

        if (!$id && isset($params['parent'], $params['index'])) {
            $id = $params['parent']->id . '-' . $params['index'];
        }

        /** @var Logger $logger */
        $logger = new Logger('access', ['node' => $id]);

        try {
            /** @var AccessResolver $resolver */
            $resolver = (new AccessResolver($conditions))
                ->withQuery($query)
                ->withLogger($logger);

            $logger->result = $resolver->resolve($node, $params);
        } catch (\Exception $e) {
            $logger->error = $e->getMessage();
        }

        return $logger->result ?? false;
    }
}
