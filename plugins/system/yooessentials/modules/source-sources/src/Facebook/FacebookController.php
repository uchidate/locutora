<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Facebook;

use YOOtheme\Http\Request;
use YOOtheme\Http\Response;
use ZOOlanders\YOOessentials\Auth\AuthManager;

class FacebookController
{
    use HasApiRequest;

    public const PAGES_ENDPOINT = 'yooessentials/source/facebook/pages';
    public const PRESAVE_ENDPOINT = 'yooessentials/source/facebook';

    public function pages(Request $request, Response $response, AuthManager $authManager)
    {
        $form = $request->getParam('form');
        $account = $form['account'] ?? null;

        if (!$auth = $authManager->auth($account)) {
            return $response->withJson('Account not specified or invalid.', 400);
        }

        try {
            $pages = self::api($account)->pages($auth->userId());

            $pages = array_map(function ($page) {
                return [
                    'value' => $page['id'],
                    'meta' => $page['id'],
                    'text' => $page['name'] ?? $page['id']
                ];
            }, $pages);

            return $response->withJson($pages, 200);
        } catch (\Exception $e) {
            return $response->withJson($e->getMessage(), 400);
        }
    }

    public function presave(Request $request, Response $response, AuthManager $authManager)
    {
        $form = $request->getParam('form') ?? [];
        $account = $form['account'] ?? null;
        $page = $form['page_id'] ?? null;

        if (!$auth = $authManager->auth($account)) {
            return $response->withJson('Account must be specified.', 400);
        }

        if (!$page) {
            return $response->withJson('Page must be specified.', 400);
        }

        $pages = self::api($account)->pages($auth->userId());

        if (!in_array($page, array_column($pages, 'id'))) {
            return $response->withJson('Page must be owned by you.', 400);
        }

        return $response->withJson(200);
    }
}
