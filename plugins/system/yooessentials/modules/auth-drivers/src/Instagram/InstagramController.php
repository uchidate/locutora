<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Auth\Driver\Instagram;

use function YOOtheme\app;
use YOOtheme\Http\Request;
use YOOtheme\Http\Response;
use ZOOlanders\YOOessentials\Api\Instagram\InstagramPersonalApi;

class InstagramController
{
    /**
     * @var string
     */
    public const PRE_SAVE_ENDPOINT = 'yooessentials/auth/instagram-basic';

    public function presave(Request $request, Response $response)
    {
        $form = $request('form');
        $custom = $form['custom'] ?? null;
        $accessToken = $form['accessToken'] ?? null;

        if (!$accessToken) {
            return $response->withJson('Access Token must be specified.', 400);
        }

        if ($custom) {
            try {
                $api = app(InstagramPersonalApi::class);
                $result = $api->debugToken($accessToken);

                $form['userId'] = $result['id'] ?? null;
            } catch (\Exception $e) {
                return $response->withJson('Invalid or expired Access Token', $e->getCode());
            }

            // api doesn't allow us to know the granted scopes,
            // assuming all scopes granted as alternative
            if ($scopes = $request->getParam('requiredScopes') ?? null) {
                $form['scopes'] = $scopes;
            }
        }

        return $response->withJson($form, 200);
    }
}
