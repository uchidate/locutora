<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Layout;

use YOOtheme\Http\Request;
use YOOtheme\Http\Response;
use ZOOlanders\YOOessentials\Storage\StorageService;

class LayoutController
{
    public const PRESAVE_ENDPOINT = 'yooessentials/layout/presave';

    public static function presave(Request $request, Response $response, StorageService $storageService)
    {
        $form = $request->getParam('form');
        $name = $form['name'] ?? null;
        $storage = $form['storage'] ?? null;
        $path = $form['path'] ?? '/';

        if (!$name) {
            return $response->withJson('Name is required.', 400);
        }

        if (!$storage) {
            return $response->withJson('Storage is required.', 400);
        }

        $storage = $storageService->storage($storage);
        if (!$storage) {
            return $response->withJson('Cannot load Storage.', 400);
        }

        try {
            $storage->filesystem()->listContents($path);
        } catch (\Exception $e) {
            return $response->withJson('Unable to load contents from path: ' . $e->getMessage(), 400);
        }

        return $response;
    }
}
