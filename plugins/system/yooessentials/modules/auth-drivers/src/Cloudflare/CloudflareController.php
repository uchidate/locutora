<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Auth\Driver\Cloudflare;

use function YOOtheme\app;
use YOOtheme\Http\Request;
use YOOtheme\Http\Response;
use ZOOlanders\YOOessentials\Api\Cloudflare\CloudflareApi;

class CloudflareController
{
    public const PRE_SAVE_API_TOKEN_ENDPOINT = 'yooessentials/cloudflare/presave-api-token';

    public function verifyApiToken(Request $request, Response $response)
    {
        $form = $request->getParam('form') ?? [];
        $token = $form['accessToken'] ?? null;

        if (!$token) {
            return $response->withJson('Token must be specified.', 400);
        }

        try {
            $api = app(CloudflareApi::class);
            $tokenInfo = $api->verifyToken($token);
        } catch (\Exception $e) {
            return $response->withJson($e->getMessage(), 400);
        }

        return $response->withJson($tokenInfo, 200);
    }
}
