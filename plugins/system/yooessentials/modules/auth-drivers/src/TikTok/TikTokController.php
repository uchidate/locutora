<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Auth\Driver\TikTok;

use function YOOtheme\app;
use YOOtheme\Http\Request;
use YOOtheme\Http\Response;
use ZOOlanders\YOOessentials\Api\TikTok\TikTokApi;

class TikTokController
{
    /**
     * @var string
     */
    public const PRE_SAVE_ENDPOINT = 'yooessentials/auth/tiktok';

    public function presave(Request $request, Response $response)
    {
        $auth = $request->getParam('form');
        $refreshToken = $auth['refreshToken'] ?? null;

        if (!$refreshToken) {
            return $response->withJson('Missing Refresh Token or no access has been granted.', 400);
        }

        try {
            /** @var TikTokApi $api */
            $api = app(TikTokApi::class);
            $data = $api->refreshAccessToken($refreshToken);

            $auth = array_merge($auth, [
                'userId' => $data['open_id'],
                'scopes' => explode(',', $data['scope']),
                'accessToken' => $data['access_token'],
                'refreshToken' => $data['refresh_token'],
                'expiresIn' => $data['expires_in'],
                'refreshExpiresIn' => $data['refresh_expires_in'],
            ]);
        } catch (\Exception $e) {
            return $response->withJson($e->getMessage(), 400);
        }

        return $response->withJson($auth, 200);
    }
}
