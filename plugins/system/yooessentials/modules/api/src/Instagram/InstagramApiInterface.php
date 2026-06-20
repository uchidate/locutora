<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Api\Instagram;

interface InstagramApiInterface
{
    public function medias(string $userOrPageId, int $limit = 20, array $filters = []): array;

    public function media(string $mediaId): array;

    public function children(string $mediaId): array;
}
