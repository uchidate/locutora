<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Api\Vimeo;

use YOOtheme\Http\Response;
use ZOOlanders\YOOessentials\Api\AbstractApi;
use ZOOlanders\YOOessentials\Auth\Auth;

// https://developer.vimeo.com/api/reference/v/3.4
class VimeoApi extends AbstractApi
{
    protected $apiEndpoint = 'https://api.vimeo.com';

    /**
     * @var string
     */
    protected $token = '';

    public function videos(array $args = []): array
    {
        $result = $this->get('videos', $args);

        return $result['data'] ?? [];
    }

    public function userVideos(string $userId, array $args = []): array
    {
        $result = $this->get("users/$userId/videos", $args);

        return $result['data'] ?? [];
    }

    public function myVideos(array $args = []): array
    {
        $result = $this->get('me/videos', $args);

        return $result['data'] ?? [];
    }

    public function myShowcaseVideos(string $showcaseId, array $args = []): array
    {
        $result = $this->get("me/albums/{$showcaseId}/videos", $args);

        return $result['data'] ?? [];
    }

    public function myFolderVideos(string $folderId, array $args = []): array
    {
        $result = $this->get("me/projects/{$folderId}/videos", $args);

        return $result['data'] ?? [];
    }

    public function withAuth(Auth $auth): self
    {
        $this->token = $auth->accessToken;

        return $this;
    }

    public function verifyToken(string $token)
    {
        $this->token = $token;

        try {
            return $this->get('oauth/verify');
        } catch (\Exception $e) {
            throw new \Exception('Invalid Token.');
        }
    }

    protected function getHeaders(): array
    {
        return parent::getHeaders() + [
            'Authorization' => "Bearer {$this->token}",
            'User-Agent' => 'YOOessentials/1.0.0',
            'Accept' => 'application/vnd.vimeo.*+json;version=3.4'
        ];
    }

    protected function processResponse(Response $response): array
    {
        $result = json_decode($response->getBody(), true);
        $success = $response->getStatusCode() >= 200 && $response->getStatusCode() <= 299 && ($result['message'] ?? '') !== 'error';

        if (!$success) {
            $code = $result['error_code'] ?? $response->getStatusCode() ?? 400;
            $message = $result['error'] ?? $response->getReasonPhrase() ?? 'Unknown Error';

            throw new \Exception($message, $code);
        }

        return $result;
    }
}
