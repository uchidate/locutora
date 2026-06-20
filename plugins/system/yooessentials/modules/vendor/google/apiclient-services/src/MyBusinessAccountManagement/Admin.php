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

class Admin extends \ZOOlanders\YOOessentials\Vendor\Google\Model
{
    /**
     * @var string
     */
    public $account;
    /**
     * @var string
     */
    public $admin;
    /**
     * @var string
     */
    public $name;
    /**
     * @var bool
     */
    public $pendingInvitation;
    /**
     * @var string
     */
    public $role;
    /**
     * @param string
     */
    public function setAccount($account)
    {
        $this->account = $account;
    }
    /**
     * @return string
     */
    public function getAccount()
    {
        return $this->account;
    }
    /**
     * @param string
     */
    public function setAdmin($admin)
    {
        $this->admin = $admin;
    }
    /**
     * @return string
     */
    public function getAdmin()
    {
        return $this->admin;
    }
    /**
     * @param string
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @param bool
     */
    public function setPendingInvitation($pendingInvitation)
    {
        $this->pendingInvitation = $pendingInvitation;
    }
    /**
     * @return bool
     */
    public function getPendingInvitation()
    {
        return $this->pendingInvitation;
    }
    /**
     * @param string
     */
    public function setRole($role)
    {
        $this->role = $role;
    }
    /**
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }
}
// Adding a class alias for backwards compatibility with the previous class name.
\class_alias(\ZOOlanders\YOOessentials\Vendor\Google\Service\MyBusinessAccountManagement\Admin::class, 'ZOOlanders\\YOOessentials\\Vendor\\Google_Service_MyBusinessAccountManagement_Admin');
