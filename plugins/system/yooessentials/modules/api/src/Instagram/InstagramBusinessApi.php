<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Api\Instagram;

use ZOOlanders\YOOessentials\Api\Facebook\FacebookBaseApi;

class InstagramBusinessApi extends FacebookBaseApi implements InstagramApiInterface
{
    use IteratesOverMedias;

    protected function getMediaFields(): string
    {
        return 'caption,comments_count,like_count,media_type,media_url,permalink,thumbnail_url,timestamp,username';
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
        $fields = str_replace('caption,comments_count,like_count,', '', $fields);

        $result = $this->get("$mediaId/children", compact('fields'));

        return $result['data'] ?? [];
    }

    // https://developers.facebook.com/docs/instagram-api/reference/ig-user/
    public function user(string $userId): array
    {
        $fields = 'biography,id,followers_count,follows_count,media_count,name,profile_picture_url,username,website';

        return $this->get("{$userId}", compact('fields'));
    }

    public function pages(string $userId): array
    {
        $accounts = $this->get("$userId/accounts");

        $pages = array_map(function ($page) {
            $pageId = $page['id'] ?? '';

            if (!$pageId) {
                return null;
            }

            $result = $this->get($pageId, [
                'fields' => 'name,instagram_business_account{id}'
            ]);

            $igAccountId = $result['instagram_business_account']['id'] ?? null;

            if (!$igAccountId) {
                return null;
            }

            return [
                'id' => $result['instagram_business_account']['id'] ?? '',
                'name' => $result['name'] ?? null
            ];
        }, $accounts['data'] ?? []);

        return array_values(array_filter($pages));
    }

    /**
     * https://developers.facebook.com/docs/instagram-api/reference/ig-hashtag
     *
     * @param string $edge 'top_media' | 'recent_media'
     */
    public function mediaByHashtag(string $pageId, string $hashtag, string $edge): array
    {
        $fields = 'caption,comments_count,like_count,media_type,media_url,permalink,timestamp';
        $hashtagId = $this->getHashtagId($pageId, $hashtag);

        $result = $this->get("{$hashtagId}/{$edge}", [
            'user_id' => $pageId,
            'fields' => $fields,
        ]);

        return $result['data'];
    }

    /**
     * https://developers.facebook.com/docs/instagram-api/reference/ig-hashtag-search
     */
    public function getHashtagId(string $pageId, string $hashtag): string
    {
        $result = $this->get('ig_hashtag_search', [
            'user_id' => $pageId,
            'q' => $hashtag,
        ]);

        return $result['data'][0]['id'] ?? '';
    }
}
