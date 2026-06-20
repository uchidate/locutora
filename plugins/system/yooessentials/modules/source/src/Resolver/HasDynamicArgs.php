<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Source\Resolver;

use ZOOlanders\YOOessentials\Dynamic\DynamicResolver;
use function YOOtheme\app;

trait HasDynamicArgs
{
    public static function resolveDynamicArguments($node, array $root = []): array
    {
        /** @var DynamicResolver $dynamicResolver */
        $dynamicResolver = app(DynamicResolver::class);
        $node = (object) $node;

        if (isset($node->source)) {
            $node->source = json_decode($node->source);
            $dynamicResolver->resolveProps($node, $root);
        }

        return (array) ($node->props ?? $node ?? []);
    }
}
