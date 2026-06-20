<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Api\Facebook;

interface FacebookApiInterface
{
    public function page(string $pageId): array;

    public function pages(string $userId): array;

    public function posts(string $userOrPageId, ?int $limit = 20): array;
}
