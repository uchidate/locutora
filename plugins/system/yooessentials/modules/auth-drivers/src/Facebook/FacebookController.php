<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Auth\Driver\Facebook;

use function YOOtheme\app;
use YOOtheme\Http\Request;
use YOOtheme\Http\Response;
use YOOtheme\HttpClientInterface;
use ZOOlanders\YOOessentials\Api\Facebook\FacebookBaseApi;

class FacebookController
{
    /**
     * @var string
     */
    public const PRE_SAVE_ENDPOINT = 'yooessentials/auth/facebook';

    public function presave(Request $request, Response $response, HttpClientInterface $client)
    {
        $form = $request('form');
        $custom = $form['custom'] ?? null;
        $accessToken = $form['accessToken'] ?? null;

        if ($custom) {
            if (!$accessToken) {
                return $response->withJson('Access Token must be specified.', 400);
            }

            try {
                $api = app(FacebookBaseApi::class);
                $result = $api->debugToken($accessToken);

                $scopes = $result['scopes'] ?? [];
                $userId = $result['user_id'] ?? null;
                $expiresAt = $result['data_access_expires_at'] ?? null;
            } catch (\Exception $e) {
                return $response->withJson($e->getMessage(), $e->getCode());
            }

            return $response->withJson(compact('scopes', 'userId', 'expiresAt'), 200);
        }

        if (!$accessToken) {
            return $response->withJson('No access has been granted.', 400);
        }

        return $response->withJson(200);
    }
}
