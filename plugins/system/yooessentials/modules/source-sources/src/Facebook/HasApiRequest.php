<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Facebook;

use function YOOtheme\app;
use YOOtheme\Event;
use ZOOlanders\YOOessentials\Api\Facebook\FacebookApi;
use ZOOlanders\YOOessentials\Auth\AuthManager;

trait HasApiRequest
{
    public static function api(string $authId): ?FacebookApi
    {
        static $api = null;

        if ($api) {
            return $api;
        }

        try {
            $auth = app(AuthManager::class)->auth($authId);

            if (!$auth) {
                return null;
            }

            return $api = app(FacebookApi::class)->withAccessToken($auth->accessToken());
        } catch (\Exception $e) {
            Event::emit('yooessentials.error', [
                'addon' => 'source-facebook',
                'error' => $e->getMessage(),
                'exception' => $e
            ]);

            return null;
        }
    }
}
