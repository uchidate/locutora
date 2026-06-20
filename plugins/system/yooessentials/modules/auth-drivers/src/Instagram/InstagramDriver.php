<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Auth\Driver\Instagram;

use function YOOtheme\app;
use ZOOlanders\YOOessentials\Api\Instagram\InstagramPersonalApi;
use ZOOlanders\YOOessentials\Auth\AuthDriver;
use ZOOlanders\YOOessentials\Auth\AuthOAuth;
use ZOOlanders\YOOessentials\Auth\RenewTokenInterface;

class InstagramDriver extends AuthDriver implements RenewTokenInterface
{
    public function renewToken(AuthOAuth $auth): AuthOAuth
    {
        /** @var InstagramPersonalApi $api */
        $api = app(InstagramPersonalApi::class);

        $data = $api->refreshAccessToken($auth->accessToken());

        return $auth
            ->setAccessToken($data['access_token'])
            ->setRefreshToken($data['access_token'])
            ->setExpiresIn($data['expires_in']);
    }
}
