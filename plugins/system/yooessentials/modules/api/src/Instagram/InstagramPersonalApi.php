<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Api\Instagram;

use ZOOlanders\YOOessentials\Api\Facebook\FacebookBaseApi;

class InstagramPersonalApi extends FacebookBaseApi implements InstagramApiInterface
{
    use IteratesOverMedias;

    protected $apiEndpoint = 'https://graph.instagram.com';

    protected function getMediaFields(): string
    {
        return 'caption,media_type,media_url,permalink,thumbnail_url,timestamp,username';
    }

    protected function getMediaMaxLimit(): int
    {
        return 100;
    }

    public function media(string $mediaId): array
    {
        $fields = $this->getMediaFields();

        return $this->get("$mediaId", compact('fields'));
    }

    public function children(string $mediaId): array
    {
        $fields = $this->getMediaFields();
        $fields = str_replace('caption,', '', $fields);

        $result = $this->get("$mediaId/children", compact('fields'));

        return $result['data'] ?? [];
    }

    public function debugToken(string $token): array
    {
        $this->withAccessToken($token);

        return $this->get('me', [
            'fields' => 'id'
        ]);
    }

    public function refreshAccessToken(string $token): array
    {
        return $this->get('refresh_access_token', [
            'grant_type' => 'ig_refresh_token',
            'access_token' => $token
        ]);
    }
}
