<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Dynamic;

use YOOtheme\Http\Request;
use YOOtheme\Http\Response;

class GlobalQueryController
{
    /**
     * @var string
     */
    public const PRESAVE_QUERY_ENDPOINT = 'yooessentials/source/query/save';

    public function presave(Request $request, Response $response)
    {
        $form = $request->getParam('form');

        if (!($form['name'] ?? false)) {
            return $response->withJson('Name must be specified.', 400);
        }

        if (!($form['source']['query']['name'] ?? false)) {
            return $response->withJson('Query must be selected.', 400);
        }

        return $response->withJson(200);
    }
}
