<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form\Actions\SaveGoogleSheet;

use function YOOtheme\app;
use ZOOlanders\YOOessentials\Api\Google\Sheet\GoogleSheetApiInteface;
use ZOOlanders\YOOessentials\Auth\AuthManager;

trait HasApiRequest
{
    public static function api(string $authId): ?GoogleSheetApiInteface
    {
        $auth = app(AuthManager::class)->auth($authId);

        if (!$auth) {
            throw new \Exception('Invalid Account.');
        }

        return app(GoogleSheetApiInteface::class)->forAccount($auth);
    }
}
