<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Auth\Driver\TikTok;

use function YOOtheme\app;
use ZOOlanders\YOOessentials\Api\TikTok\TikTokApi;
use ZOOlanders\YOOessentials\Auth\AuthDriver;
use ZOOlanders\YOOessentials\Auth\AuthOAuth;
use ZOOlanders\YOOessentials\Auth\RenewTokenInterface;

class TikTokDriver extends AuthDriver implements RenewTokenInterface
{
    public function renewToken(AuthOAuth $auth): AuthOAuth
    {
        /** @var TikTokApi $api */
        $api = app(TikTokApi::class);

        try {
            $data = $api->refreshAccessToken($auth->refreshToken());
        } catch (\Exception $e) {
            return $auth;
        }

        return $auth
            ->setAccessToken($data['access_token'])
            ->setRefreshToken($data['refresh_token'])
            ->setExpiresIn($data['expires_in']);
    }
}
