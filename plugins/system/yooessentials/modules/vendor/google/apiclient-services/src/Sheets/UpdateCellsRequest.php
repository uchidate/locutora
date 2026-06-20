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

class UpdateCellsRequest extends \ZOOlanders\YOOessentials\Vendor\Google\Collection
{
    protected $collection_key = 'rows';
    /**
     * @var string
     */
    public $fields;
    protected $rangeType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\GridRange::class;
    protected $rangeDataType = '';
    protected $rowsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\RowData::class;
    protected $rowsDataType = 'array';
    protected $startType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\GridCoordinate::class;
    protected $startDataType = '';
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
    /**
     * @param RowData[]
     */
    public function setRows($rows)
    {
        $this->rows = $rows;
    }
    /**
     * @return RowData[]
     */
    public function getRows()
    {
        return $this->rows;
    }
    /**
     * @param GridCoordinate
     */
    public function setStart(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\GridCoordinate $start)
    {
        $this->start = $start;
    }
    /**
     * @return GridCoordinate
     */
    public function getStart()
    {
        return $this->start;
    }
}
// Adding a class alias for backwards compatibility with the previous class name.
\class_alias(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\UpdateCellsRequest::class, 'ZOOlanders\\YOOessentials\\Vendor\\Google_Service_Sheets_UpdateCellsRequest');
