<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Rss;

use YOOtheme\Http\Request;
use YOOtheme\Http\Response;

class RssController
{
    /**
     * @var string
     */
    public const PRESAVE_ENDPOINT = 'yooessentials/source/rss';

    public function presave(Request $request, Response $response)
    {
        $form = $request->getParam('form');
        $url = $form['url'] ?? null;

        if (!$url) {
            return $response->withJson('Missing RSS feed Url.', 400);
        }

        try {
            (new RssSource($form))->rss();
        } catch (\Exception $e) {
            return $response->withJson($e->getMessage(), 400);
        }

        return $response->withJson(200);
    }
}
