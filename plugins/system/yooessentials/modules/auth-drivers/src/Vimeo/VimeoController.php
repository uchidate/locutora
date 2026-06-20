<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Auth\Driver\Vimeo;

use YOOtheme\Http\Request;
use YOOtheme\Http\Response;
use ZOOlanders\YOOessentials\Api\Vimeo\VimeoApi;

class VimeoController
{
    /**
     * @var string
     */
    public const PRE_SAVE_ENDPOINT = 'yooessentials/auth/vimeo';

    public function presave(Request $request, Response $response, VimeoApi $api)
    {
        $auth = $request->getParam('form');
        $accessToken = $auth['accessToken'] ?? null;

        if (!$accessToken) {
            return $response->withJson('Missing Access Token or no access has been granted.', 400);
        }

        try {
            $api->verifyToken($accessToken);
        } catch (\Exception $e) {
            return $response->withJson($e->getMessage(), 400);
        }

        return $response->withJson($auth, 200);
    }
}
