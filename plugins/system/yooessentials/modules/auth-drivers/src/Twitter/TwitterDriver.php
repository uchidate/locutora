<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Auth\Driver\Twitter;

use function YOOtheme\app;
use YOOtheme\HttpClientInterface;
use ZOOlanders\YOOessentials\Auth\AuthDriver;
use ZOOlanders\YOOessentials\Auth\AuthOAuth;
use ZOOlanders\YOOessentials\Auth\RenewTokenInterface;

class TwitterDriver extends AuthDriver implements RenewTokenInterface
{
    public const CLIENT_ID = 'WUJ4MFJzUWJNQ2E1RzQ0aC1jTFM6MTpjaQ';

    // https://developer.twitter.com/en/docs/authentication/oauth-2-0/authorization-code
    public function renewToken(AuthOAuth $auth): AuthOAuth
    {
        /** @var HttpClientInterface $client */
        $client = app(HttpClientInterface::class);

        $clientId = self::CLIENT_ID;
        $refreshToken = $auth->refreshToken();

        if ($auth->custom()) {
            $clientId = $auth->clientId();
        }

        $response = $client->post('https://api.twitter.com/2/oauth2/token', [
            'refresh_token' => $refreshToken,
            'grant_type' => 'refresh_token',
            'client_id' => $clientId,
        ], [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        if (isset($data['error'])) {
            throw new \RuntimeException($data['error_description']);
        }

        if (!isset($data['access_token'])) {
            return $auth;
        }

        return $auth
            ->setAccessToken($data['access_token'])
            ->setRefreshToken($data['refresh_token'])
            ->setExpiresIn($data['expires_in']);
    }
}
