<?php

/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */
namespace ZOOlanders\YOOessentials\Vendor\Google\Service\MyBusinessAccountManagement;

class OrganizationInfo extends \ZOOlanders\YOOessentials\Vendor\Google\Model
{
    protected $addressType = \ZOOlanders\YOOessentials\Vendor\Google\Service\MyBusinessAccountManagement\PostalAddress::class;
    protected $addressDataType = '';
    /**
     * @var string
     */
    public $phoneNumber;
    /**
     * @var string
     */
    public $registeredDomain;
    /**
     * @param PostalAddress
     */
    public function setAddress(\ZOOlanders\YOOessentials\Vendor\Google\Service\MyBusinessAccountManagement\PostalAddress $address)
    {
        $this->address = $address;
    }
    /**
     * @return PostalAddress
     */
    public function getAddress()
    {
        return $this->address;
    }
    /**
     * @param string
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }
    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }
    /**
     * @param string
     */
    public function setRegisteredDomain($registeredDomain)
    {
        $this->registeredDomain = $registeredDomain;
    }
    /**
     * @return string
     */
    public function getRegisteredDomain()
    {
        return $this->registeredDomain;
    }
}
// Adding a class alias for backwards compatibility with the previous class name.
\class_alias(\ZOOlanders\YOOessentials\Vendor\Google\Service\MyBusinessAccountManagement\OrganizationInfo::class, 'ZOOlanders\\YOOessentials\\Vendor\\Google_Service_MyBusinessAccountManagement_OrganizationInfo');
