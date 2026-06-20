<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Auth\Driver\AWS;

use YOOtheme\Http\Request;
use YOOtheme\Http\Response;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\StsClient;

class AWSController
{
    /**
     * @var string
     */
    public const PRE_SAVE_ENDPOINT = 'yooessentials/auth/aws';

    public function presave(Request $request, Response $response)
    {
        $auth = $request->getParam('form');
        $accessKeyId = $auth['access_key_id'] ?? null;
        $accessKeySecret = $auth['access_key_secret'] ?? null;

        if (!$accessKeyId) {
            return $response->withJson('Access Key ID is required.', 400);
        }

        if (!$accessKeySecret) {
            return $response->withJson('Access Key Secret is required.', 400);
        }

        try {
            (new StsClient(compact('accessKeyId', 'accessKeySecret')))->getCallerIdentity([]);
        } catch (\Exception $e) {
            return $response->withJson($e->getMessage(), 400);
        }

        return $response->withJson($auth, 200);
    }
}
