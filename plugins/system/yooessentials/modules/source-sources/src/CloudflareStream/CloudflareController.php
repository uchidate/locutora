<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\CloudflareStream;

use function YOOtheme\app;
use YOOtheme\Http\Request;
use YOOtheme\Http\Response;
use ZOOlanders\YOOessentials\Api\Cloudflare\CloudflareApi;
use ZOOlanders\YOOessentials\Auth\AuthManager;

class CloudflareController
{
    public const GET_ACCOUNTS_ENDPOINT = 'yooessentials/cloudflare/accounts';

    public function getAccounts(Request $request, Response $response, AuthManager $authManager)
    {
        $form = $request->getParam('form') ?? [];

        try {
            $token = $form['token'] ?? null;
            $auth = $authManager->auth($token);

            if (!$token) {
                throw new \Exception('Token must be specified.');
            }

            if (!$auth) {
                throw new \Exception('Invalid Auth.');
            }

            if (!$auth->accessToken) {
                throw new \Exception('Access Token must be specified.');
            }

            $api = app(CloudflareApi::class)->withAuth($auth);

            $items = array_map(function ($account) {
                return [
                    'text' => $account['name'],
                    'value' => $account['id'],
                    'meta' => $account['id'],
                ];
            }, $api->accounts());

            if (empty($items)) {
                throw new \Exception('The API Token is missing the permissions for this operation. Input the value manually instead.');
            }

            return $response->withJson($items, 200);
        } catch (\Exception $e) {
            return $response->withJson($e->getMessage(), 400);
        }
    }
}
