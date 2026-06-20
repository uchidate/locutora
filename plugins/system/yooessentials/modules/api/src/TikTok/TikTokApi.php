<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Api\TikTok;

use YOOtheme\Http\Response;
use ZOOlanders\YOOessentials\Api\AbstractApi;
use ZOOlanders\YOOessentials\Auth\AuthOAuth;

class TikTokApi extends AbstractApi
{
    protected const CLIENT_KEY = 'aw7gb56h2gkhl8a9';

    protected $apiEndpoint = 'https://open-api.tiktok.com';

    protected $account;

    public function videos(array $filter = []): array
    {
        $fields = ['create_time', 'cover_image_url', 'share_url', 'video_description', 'duration', 'height', 'width', 'id', 'title', 'embed_html', 'embed_link', 'like_count', 'comment_count', 'share_count', 'view_count'];

        $result = $this->post('video/list', array_merge([
            'open_id' => $this->account->userId(),
            'access_token' => $this->account->accessToken(),
            'fields' => $fields
        ], $filter));

        return $result['videos'] ?? [];
    }

    public function refreshAccessToken(string $refreshToken): array
    {
        return $this->processResponse($this->client->post($this->apiEndpoint . '/oauth/refresh_token/', [
            'client_key' => self::CLIENT_KEY,
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
        ], [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ]));
    }

    public function forAccount(AuthOAuth $account): self
    {
        $this->account = $account;

        return $this;
    }

    protected function processResponse(Response $response): array
    {
        $result = json_decode($response->getBody(), true);
        $success = $response->getStatusCode() >= 200 && $response->getStatusCode() <= 299 && ($result['message'] ?? '') !== 'error';

        if (!$success) {
            $code = $result['error']['code'] ?? $result['data']['error_code'] ?? $response->getStatusCode() ?? 400;
            $message = $result['error']['message'] ?? $result['data']['description'] ?? $response->getReasonPhrase() ?? 'Unknown Error';

            throw new \Exception($message, $code);
        }

        return $result['data'];
    }
}
