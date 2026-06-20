<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Auth\Driver\Google;

use function YOOtheme\app;
use ZOOlanders\YOOessentials\Auth\AuthDriver;
use ZOOlanders\YOOessentials\Auth\AuthOAuth;
use ZOOlanders\YOOessentials\Auth\RenewTokenInterface;
use ZOOlanders\YOOessentials\Vendor\Google\Client;
use ZOOlanders\YOOessentials\Vendor\GuzzleHttp\Exception\ClientException;

class GoogleDriver extends AuthDriver implements RenewTokenInterface
{
    public function renewToken(AuthOAuth $auth): AuthOAuth
    {
        /** @var Client $client */
        $client = app(Client::class);

        if ($auth->custom()) {
            $client->setScopes($auth->scopes());
            $client->setClientId($auth->clientId());
            $client->setClientSecret($auth->clientSecret());
        }

        try {
            $client->fetchAccessTokenWithRefreshToken($auth->refreshToken());
            $token = $client->getAccessToken();
        } catch (ClientException $e) {
            if ($body = json_decode($e->getResponse()->getBody())) {
                throw new \Exception($body->error);
            }

            throw new \Exception($e->getMessage());
        }

        return $auth
            ->setAccessToken($token['access_token'] ?? '')
            ->setExpiresIn($token['expires_in'] ?? 0);
    }
}
