<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Instagram;

use function YOOtheme\app;
use YOOtheme\Event;
use ZOOlanders\YOOessentials\Api\Instagram\InstagramBusinessApi;
use ZOOlanders\YOOessentials\Api\Instagram\InstagramPersonalApi;
use ZOOlanders\YOOessentials\Auth\AuthManager;

trait HasApiRequest
{
    public static function api(string $authId)
    {
        try {
            $auth = app(AuthManager::class)->auth($authId);

            if ($auth->driverName() === 'instagrambasic') {
                return app(InstagramPersonalApi::class)->withAccessToken($auth->accessToken());
            }

            return app(InstagramBusinessApi::class)->withAccessToken($auth->accessToken());
        } catch (\Exception $e) {
            Event::emit('yooessentials.error', [
                'addon' => 'source-instagram',
                'error' => $e->getMessage(),
                'exception' => $e
            ]);

            return null;
        }
    }
}
