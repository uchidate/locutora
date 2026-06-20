<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Instagram;

use YOOtheme\Http\Request;
use YOOtheme\Http\Response;
use ZOOlanders\YOOessentials\Auth\AuthManager;

class InstagramController
{
    use HasApiRequest;

    /**
     * @var string
     */
    public const PAGES_ENDPOINT = 'yooessentials/source/instagram/pages';

    /**
     * @var string
     */
    public const PRESAVE_ENDPOINT = 'yooessentials/source/instagram';

    public function pages(Request $request, Response $response, AuthManager $authManager)
    {
        $form = $request->getParam('form');
        $account = $form['account'] ?? null;

        if (!$auth = $authManager->auth($account)) {
            return $response->withJson('Account not specified or invalid.', 400);
        }

        if ($auth->driverName() !== 'facebook') {
            return [];
        }

        try {
            $pages = self::api($account)->pages($auth->userId());

            $pages = array_map(function ($page) {
                return [
                    'text' => $page['name'] ?? $page['id'],
                    'value' => $page['id'],
                    'meta' => $page['id']
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

        try {
            if (!$account) {
                throw new \Exception('Account must be specified.');
            }

            $page = $form['page_id'] ?? null;
            $auth = $authManager->auth($account);

            if (!$auth) {
                throw new \Exception('Invalid Auth.');
            }

            if ($auth->driverName() === 'facebook' and !$page) {
                throw new \Exception('Page must be specified.');
            }
        } catch (\Exception $e) {
            return $response->withJson($e->getMessage(), 400);
        }

        return $response->withJson(200);
    }
}
