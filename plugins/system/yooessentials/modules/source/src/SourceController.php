<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Source;

use YOOtheme\Builder\Source;
use YOOtheme\Http\Request;
use YOOtheme\Http\Response;
use ZOOlanders\YOOessentials\Config;

class SourceController
{
    public const REBUILD_SCHEMA_URL = 'yooessentials/source/rebuild-schema';

    public function rebuildSchema(Request $request, Response $response, Source $source, Config $config)
    {
        // extract schema
        $result = $source->queryIntrospection()->toArray();
        $schema = $result['data']['__schema'] ?? $result;

        return $response->withJson(compact('schema'));
    }
}
