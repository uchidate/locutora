<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Auth\Driver\Twitter;

use YOOtheme\Config;
use YOOtheme\Http\Request;
use YOOtheme\Http\Response;
use ZOOlanders\YOOessentials\Api\Twitter\TwitterApiInterface;
use ZOOlanders\YOOessentials\Auth\AuthManager;
use ZOOlanders\YOOessentials\Data;

class TwitterController
{
    /**
     * @var string
     */
    public const PRE_SAVE_ENDPOINT = 'yooessentials/auth/twitter';
    public const GENERATE_ID_ENDPOINT = 'yooessentials/auth/twitter/id';

    public function generateId(Response $response, Config $config)
    {
        return $response->withJson([
            'id' => md5(uniqid('twitter-') . $config->get('app.secret'))
        ]);
    }

    public function presave(Request $request, Response $response, AuthManager $authManager, TwitterApiInterface $api)
    {
        $form = new Data($request('form'));
        $scopes = $form->scopes ?? $request('requiredScopes');

        try {
            if (!$form->refreshToken) {
                throw new \RuntimeException('No access has been granted.', 400);
            }

            $auth = $authManager
                ->initAuth($form->toArray())
                ->forDriver($authManager->driver('twitter'))
                ->setScopes($scopes);

            $api->withAccessToken($form->accessToken)->account();
        } catch (\Exception $e) {
            return $response->withJson($e->getMessage(), 400);
        }

        return $response->withJson($auth->toArray(), 200);
    }
}
