<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Api\Cloudflare;

use YOOtheme\Http\Response;
use ZOOlanders\YOOessentials\Api\AbstractApi;
use ZOOlanders\YOOessentials\Auth\Auth;

class CloudflareApi extends AbstractApi
{
    protected $apiEndpoint = 'https://api.cloudflare.com/client/v4';

    protected $token;

    public function withAuth(Auth $auth): self
    {
        $this->token = $auth->accessToken;

        return $this;
    }

    public function accounts()
    {
        return $this->get('accounts');
    }

    public function verifyToken(string $token)
    {
        $this->token = $token;

        try {
            return $this->get('user/tokens/verify');
        } catch (\Exception $e) {
            throw new \Exception('Invalid Token.');
        }
    }

    protected function getHeaders(): array
    {
        return parent::getHeaders() + [
            'Authorization' => "Bearer {$this->token}"
        ];
    }

    protected function processResponse(Response $response): array
    {
        $result = json_decode($response->getBody(), true);

        if (!$result) {
            return (string) $response->getBody();
        }

        $success = $response->getStatusCode() >= 200 && $response->getStatusCode() <= 299 and $result['success'];

        if (!$success) {
            $code = $result['errors'][0]['code'] ?? $response->getStatusCode() ?? 400;
            $message = $result['errors'][0]['message'] ?? $response->getStatusCode() ?? 'Unknown Error';

            if ($code === 10000) {
                $message = 'The API Token is missing the permissions for this operation.';
            }

            throw new \Exception($message, $code);
        }

        return $result['result'];
    }
}
