<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Icon;

use function YOOtheme\app;

class IconTransform
{
    /**
     * Transform callback.
     *
     * @param object $node
     * @param array  $params
     */
    public function __invoke($node, array $params)
    {
        /** @var IconLoader $icon */
        $loader = app(IconLoader::class);

        foreach ($loader->retrieveIcons($node, $params['type']) as $icon) {
            $loader->loadIcon($icon);
        }
    }
}
