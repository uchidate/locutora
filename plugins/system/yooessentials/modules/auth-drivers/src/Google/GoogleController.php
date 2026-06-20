<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Auth\Driver\Google;

use YOOtheme\Http\Request;
use YOOtheme\Http\Response;
use ZOOlanders\YOOessentials\Auth\AuthManager;
use ZOOlanders\YOOessentials\Data;

class GoogleController
{
    /**
     * @var string
     */
    public const PRESAVE_ENDPOINT = 'yooessentials/auth/google/oauth';

    /**
     * @var string
     */
    public const PRESAVE_KEY_ENDPOINT = 'yooessentials/auth/google/api';

    public function presave(Request $request, Response $response, AuthManager $authManager)
    {
        $form = new Data($request('form'));
        $scopes = $form->scopes ?? [];
        $requiredScopes = $request('requiredScopes') ?? [];

        try {
            if (!$form->refreshToken) {
                throw new \RuntimeException('Refresh Token is required.');
            }

            if ($form->custom && (!$form->clientId || !$form->clientSecret)) {
                throw new \RuntimeException('Missing Client ID/Secret.');
            }

            $driver = $authManager->driver('google');

            if (!$driver) {
                throw new \RuntimeException('Driver Not Found.');
            }

            $auth = $authManager
                ->initAuth($form->toArray())
                ->forDriver($driver)
                ->setScopes($scopes)
                ->renewToken();

            if (!$auth->scopes() || !$auth->accessToken()) {
                return $response->withJson('Grant Failed', 400);
            }

            if ($requiredScopes && !in_array($requiredScopes[0], $scopes)) {
                $scope = $driver->scopes[$requiredScopes[0]];

                return $response->withJson(sprintf("Missing authorization for '%s' scope.", $scope), 400);
            }
        } catch (\Exception $e) {
            return $response->withJson($e->getMessage(), 400);
        }

        return $response->withJson([
            'scopes' => $auth->scopes(),
            'accessToken' => $auth->accessToken(),
            'expiresAt' => $auth->expiresAt(),
        ], 200);
    }

    public function presaveKey(Request $request, Response $response)
    {
        $form = $request->getParam('form');
        $key = $form['key'] ?? null;

        if (!$key) {
            return $response->withJson('API Key is required.', 400);
        }

        return $response->withJson(200);
    }
}
