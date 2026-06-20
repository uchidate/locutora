<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Api\Google\YouTube;

use ZOOlanders\YOOessentials\Auth\Auth;

interface YouTubeApiInterface
{
    public function channels(array $filters): array;

    public function playlists(array $filters): array;

    public function searchVideos(array $filters): array;

    public function videos(array $ids): array;

    public function channelVideos(string $channel, array $filters = []): array;

    public function playlistVideos(string $channel, array $filters = []): array;

    public function forAccount(Auth $account): YouTubeApiInterface;

    public function withApiKey(Auth $key): YouTubeApiInterface;
}
