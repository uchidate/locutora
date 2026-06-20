<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Auth\Driver\ApiKey;

use YOOtheme\Http\Request;
use YOOtheme\Http\Response;

class ApiKeyController
{
    /**
     * @var string
     */
    public const PRESAVE_ENDPOINT = 'yooessentials/auth/api-key';

    public function presave(Request $request, Response $response)
    {
        $form = $request->getParam('form');
        $key = $form['key'] ?? null;

        if (!$key) {
            return $response->withJson('The API Key cannot be omitted.', 400);
        }

        return $response->withJson(200);
    }
}
