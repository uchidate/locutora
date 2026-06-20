<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Config;

use YOOtheme\Http\Request;
use YOOtheme\Http\Response;
use ZOOlanders\YOOessentials\Config;
use ZOOlanders\YOOessentials\Vendor\Google\Exception;

class ConfigController
{
    public const CONFIG_SAVE_URL = 'yooessentials/config/save';
    public const CONFIG_IMPORT_URL = 'yooessentials/config/import';

    public static function save(Request $request, Response $response, Config $config, ConfigRepositoryInterface $repository)
    {
        try {
            if (!$repository->authorize()) {
                throw new Exception('Saving Config Failed: Insufficient User Rights', 403);
            }

            $config->replace($request('config', []));
            $repository->save($config);
        } catch (\Exception $e) {
            $request->abort($e->getCode(), $e->getMessage());
        }

        return $response->withJson(['data' => $config->toArray()], 200);
    }

    public static function import(Request $request, Response $response, ConfigUpdater $updater)
    {
        $config = $updater($request('config', []));

        return $response->withJson($config, 200);
    }
}
