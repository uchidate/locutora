<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Api\Google\MyBusiness\Service;

use ZOOlanders\YOOessentials\Vendor\Google\Service;

class BusinessInformationService extends Service
{
    /** @var AccountLocationsServiceResource */
    public $accounts_locations;

    /** @var AccountLocationServiceResource */
    public $account_location;

    public function __construct($clientOrConfig = [])
    {
        parent::__construct($clientOrConfig);

        $this->rootUrl = 'https://mybusinessbusinessinformation.googleapis.com/';
        $this->servicePath = '';
        $this->batchPath = 'batch';
        $this->version = 'v1';
        $this->serviceName = 'mybusinessbusinessinformation';

        $this->accounts_locations = new AccountLocationsServiceResource(
            $this,
            $this->serviceName,
            'locations',
            [
                'methods' => [
                    'list' => [
                        'path' => 'v1/{+parent}/locations',
                        'httpMethod' => 'GET',
                        'parameters' => [
                            'parent' => [
                                'location' => 'path',
                                'type' => 'string',
                                'required' => true,
                            ],
                            'pageSize' => [
                                'location' => 'query',
                                'type' => 'integer',
                            ],
                            'pageToken' => [
                                'location' => 'query',
                                'type' => 'string',
                            ],
                            'filter' => [
                                'location' => 'query',
                                'type' => 'string',
                            ],
                            'languageCode' => [
                                'location' => 'query',
                                'type' => 'string',
                            ],
                            'orderBy' => [
                                'location' => 'query',
                                'type' => 'string',
                            ],
                            'readMask' => [
                                'location' => 'query',
                                'type' => 'string',
                                'required' => true,
                            ]
                        ],
                    ]
                ]
            ]
        );

        $this->account_location = new AccountLocationServiceResource(
            $this,
            $this->serviceName,
            'locations',
            [
                'methods' => [
                    'get' => [
                        'path' => 'v1/{+name}',
                        'httpMethod' => 'GET',
                        'parameters' => [
                            'name' => [
                                'location' => 'path',
                                'type' => 'string',
                                'required' => true,
                            ],
                            'readMask' => [
                                'location' => 'query',
                                'type' => 'string',
                                'required' => true,
                            ]
                        ],
                    ]
                ]
            ]
        );
    }
}
