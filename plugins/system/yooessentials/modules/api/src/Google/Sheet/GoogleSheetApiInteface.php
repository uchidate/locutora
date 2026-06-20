<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Api\Google\Sheet;

use ZOOlanders\YOOessentials\Auth\AuthOAuth;

interface GoogleSheetApiInteface
{
    public function forAccount(AuthOAuth $account): GoogleSheetApiInteface;
}
