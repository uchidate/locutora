<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Icon\Joomla;

use function YOOtheme\app;

class IconCacheTransform
{
    public function __invoke($node, array $params)
    {
        $article = $params['article'] ?? null;

        if (!$article) {
            return $this;
        }

        /** @var IconCacheHelper $cacheHelper */
        $cacheHelper = app(IconCacheHelper::class);
        $cacheHelper->store($article->id);
    }
}
