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
namespace ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets;

class UpdateDimensionGroupRequest extends \ZOOlanders\YOOessentials\Vendor\Google\Model
{
    protected $dimensionGroupType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DimensionGroup::class;
    protected $dimensionGroupDataType = '';
    /**
     * @var string
     */
    public $fields;
    /**
     * @param DimensionGroup
     */
    public function setDimensionGroup(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DimensionGroup $dimensionGroup)
    {
        $this->dimensionGroup = $dimensionGroup;
    }
    /**
     * @return DimensionGroup
     */
    public function getDimensionGroup()
    {
        return $this->dimensionGroup;
    }
    /**
     * @param string
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
    }
    /**
     * @return string
     */
    public function getFields()
    {
        return $this->fields;
    }
}
// Adding a class alias for backwards compatibility with the previous class name.
\class_alias(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\UpdateDimensionGroupRequest::class, 'ZOOlanders\\YOOessentials\\Vendor\\Google_Service_Sheets_UpdateDimensionGroupRequest');
