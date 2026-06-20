<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Api\Google\MyBusiness\Service;

use ZOOlanders\YOOessentials\Vendor\Google_Service_MyBusiness_ListLocationsResponse;
use ZOOlanders\YOOessentials\Vendor\Google\Service\Resource;

class AccountLocationsServiceResource extends Resource
{
    public const LOCATION_FIELDS = ['name', 'languageCode', 'storeCode', 'title', 'categories', 'storefrontAddress', 'phoneNumbers', 'websiteUri', 'labels', 'latlng', 'metadata', 'regularHours'];

    public function listAccountsLocations(string $parent, array $optParams = []): Google_Service_MyBusiness_ListLocationsResponse
    {
        $params = ['parent' => $parent, 'readMask' => implode(',', self::LOCATION_FIELDS)];
        $params = array_merge($params, $optParams);

        return $this->call('list', [$params], "ZOOlanders\YOOessentials\Vendor\Google_Service_MyBusiness_ListLocationsResponse");
    }
}
