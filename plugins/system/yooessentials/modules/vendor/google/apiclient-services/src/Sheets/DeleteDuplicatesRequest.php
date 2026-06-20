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

class DeleteDuplicatesRequest extends \ZOOlanders\YOOessentials\Vendor\Google\Collection
{
    protected $collection_key = 'comparisonColumns';
    protected $comparisonColumnsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DimensionRange::class;
    protected $comparisonColumnsDataType = 'array';
    protected $rangeType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\GridRange::class;
    protected $rangeDataType = '';
    /**
     * @param DimensionRange[]
     */
    public function setComparisonColumns($comparisonColumns)
    {
        $this->comparisonColumns = $comparisonColumns;
    }
    /**
     * @return DimensionRange[]
     */
    public function getComparisonColumns()
    {
        return $this->comparisonColumns;
    }
    /**
     * @param GridRange
     */
    public function setRange(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\GridRange $range)
    {
        $this->range = $range;
    }
    /**
     * @return GridRange
     */
    public function getRange()
    {
        return $this->range;
    }
}
// Adding a class alias for backwards compatibility with the previous class name.
\class_alias(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DeleteDuplicatesRequest::class, 'ZOOlanders\\YOOessentials\\Vendor\\Google_Service_Sheets_DeleteDuplicatesRequest');
