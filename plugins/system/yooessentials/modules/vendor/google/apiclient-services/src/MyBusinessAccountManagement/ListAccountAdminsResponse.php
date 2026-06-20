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

class ListAccountAdminsResponse extends \ZOOlanders\YOOessentials\Vendor\Google\Collection
{
    protected $collection_key = 'accountAdmins';
    protected $accountAdminsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\MyBusinessAccountManagement\Admin::class;
    protected $accountAdminsDataType = 'array';
    /**
     * @param Admin[]
     */
    public function setAccountAdmins($accountAdmins)
    {
        $this->accountAdmins = $accountAdmins;
    }
    /**
     * @return Admin[]
     */
    public function getAccountAdmins()
    {
        return $this->accountAdmins;
    }
}
// Adding a class alias for backwards compatibility with the previous class name.
\class_alias(\ZOOlanders\YOOessentials\Vendor\Google\Service\MyBusinessAccountManagement\ListAccountAdminsResponse::class, 'ZOOlanders\\YOOessentials\\Vendor\\Google_Service_MyBusinessAccountManagement_ListAccountAdminsResponse');
