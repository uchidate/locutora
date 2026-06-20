<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Api\Facebook;

class FacebookApi extends FacebookBaseApi implements FacebookApiInterface
{
    public function page(string $pageId): array
    {
        $fields = 'id,name,username,link,website,about,category,whatsapp_number,description,description_html,general_info,fan_count,followers_count,birthday,personal_info,personal_interests,affiliation';

        return $this->get("{$pageId}", ['fields' => $fields]);
    }

    public function pages(string $userId): array
    {
        $accounts = $this->get("$userId/accounts", ['limit' => 100]);

        $pages = array_map(function ($page) {
            $pageId = $page['id'] ?? '';

            if (!$pageId) {
                return null;
            }

            // You can't manage the page, so no sense displaying it
            $token = $page['access_token'] ?? null;
            if (!$token) {
                return null;
            }

            return [
                'id' => $pageId,
                'name' => $page['name'] ?? null,
            ];
        }, $accounts['data'] ?? []);

        return array_values(array_filter($pages));
    }

    public function posts(string $userOrPageId, ?int $limit = 20): array
    {
        $fields = 'id,parent_id,created_time,updated_time,from{name},actions,is_expired,is_hidden,is_popular,is_published,full_picture,reactions.summary(true),comments.summary(true),message,message_tags{name},permalink_url,likes.summary(true),shares';

        $this->withAccessToken($this->getPageAccessToken($userOrPageId));

        $result = $this->get("{$userOrPageId}/feed", [
            'fields' => $fields,
            'limit' => $limit
        ]);

        return $result['data'] ?? [];
    }

    public function getPageAccessToken(string $pageId): ?string
    {
        return $this->get($pageId, ['fields' => 'access_token'])['access_token'] ?? null;
    }
}
