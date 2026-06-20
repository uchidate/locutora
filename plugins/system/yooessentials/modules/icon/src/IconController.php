<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Icon;

use YOOtheme\Http\Request;
use YOOtheme\Http\Response;

class IconController
{
    public function getIcons(Request $request, Response $response, IconApi $api)
    {
        try {
            $offset = (int) $request->getParam('offset', 0);
            $length = (int) $request->getParam('length', 200);
            $search = $request->getParam('search');
            $group = $request->getParam('group');
            $collection = $request->getParam('collection');

            $result = $api->fetchIcons($offset, $length, $search, $collection, $group);

            return $response->withJson($result);
        } catch (\Exception $e) {
            $request->abort(400, $e->getMessage());
        }
    }

    public function addCollection(Request $request, Response $response, IconApi $api, IconLoader $loader)
    {
        $collection = $request->getParam('collection');

        if (!$collection) {
            $request->abort(400, 'Collection name not provided.');
        }

        try {
            $api->loadCollection($collection);

            return $response->withJson([
                'collections' => array_values($loader->collections())
            ]);
        } catch (\Exception $e) {
            $request->abort(400, $e->getMessage());
        }
    }

    public function removeCollection(Request $request, Response $response, IconApi $api, IconLoader $loader)
    {
        $collection = $request->getParam('collection');

        if (!$collection) {
            $request->abort(400, 'Collection name not provided.');
        }

        try {
            $api->removeCollection($collection);

            $collections = $loader->collections();
            unset($collections[$collection]->data['installed']);

            return $response->withJson([
                'collections' => array_values($collections)
            ]);
        } catch (\Exception $e) {
            $request->abort(400, $e->getMessage());
        }
    }
}
