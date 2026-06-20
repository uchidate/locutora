<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Api\Facebook;

use YOOtheme\Http\Response;
use YOOtheme\HttpClientInterface;
use ZOOlanders\YOOessentials\Auth\AuthOAuth;
use ZOOlanders\YOOessentials\Api\AbstractApi;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\Cache\CacheInterface;

class FacebookBaseApi extends AbstractApi
{
    /** @var null|string */
    protected $accessToken = null;

    /** @var null|CacheInterface */
    protected $cache = null;

    protected $apiEndpoint = 'https://graph.facebook.com';

    public function __construct(CacheInterface $cache, HttpClientInterface $client)
    {
        parent::__construct($client);

        $this->cache = $cache;
    }

    public function forAccount(AuthOAuth $account): self
    {
        $this->accessToken = $account->accessToken();

        return $this;
    }

    public function withAccessToken(string $accessToken): AbstractApi
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    public function debugToken(string $token): array
    {
        $this->withAccessToken($token);

        $result = $this->get('debug_token', [
            'input_token' => $token
        ]);

        return $result['data'] ?? [];
    }

    protected function getUrl(string $name): string
    {
        if ($this->accessToken) {
            return parent::getUrl("{$name}?access_token={$this->accessToken}");
        }

        return parent::getUrl($name);
    }

    protected function processResponse(Response $response): array
    {
        $result = json_decode($response->getBody(), true);
        $success = $response->getStatusCode() >= 200 && $response->getStatusCode() <= 299;

        if (!$success) {
            $code = $response->getStatusCode() ?? 400;
            $message = $result['error']['message'] ?? $response->getReasonPhrase() ?? 'Unknown Error';

            throw new \Exception($message, $code);
        }

        return $result;
    }
}
