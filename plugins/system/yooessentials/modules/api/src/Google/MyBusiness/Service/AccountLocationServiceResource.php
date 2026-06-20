<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Api\Google\MyBusiness\Service;

use ZOOlanders\YOOessentials\Vendor\Google_Service_MyBusiness_Location;
use ZOOlanders\YOOessentials\Vendor\Google\Service\Resource;

class AccountLocationServiceResource extends Resource
{
    public function get(string $name, array $optParams = []): Google_Service_MyBusiness_Location
    {
        $params = ['name' => $name, 'readMask' => implode(',', AccountLocationsServiceResource::LOCATION_FIELDS)];
        $params = array_merge($params, $optParams);

        return $this->call('get', [$params], "ZOOlanders\YOOessentials\Vendor\Google_Service_MyBusiness_Location");
    }
}
