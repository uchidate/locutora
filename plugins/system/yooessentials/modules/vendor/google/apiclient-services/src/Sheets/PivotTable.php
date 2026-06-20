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

class PivotTable extends \ZOOlanders\YOOessentials\Vendor\Google\Collection
{
    protected $collection_key = 'values';
    protected $columnsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\PivotGroup::class;
    protected $columnsDataType = 'array';
    protected $criteriaType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\PivotFilterCriteria::class;
    protected $criteriaDataType = 'map';
    protected $dataExecutionStatusType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DataExecutionStatus::class;
    protected $dataExecutionStatusDataType = '';
    /**
     * @var string
     */
    public $dataSourceId;
    protected $filterSpecsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\PivotFilterSpec::class;
    protected $filterSpecsDataType = 'array';
    protected $rowsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\PivotGroup::class;
    protected $rowsDataType = 'array';
    protected $sourceType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\GridRange::class;
    protected $sourceDataType = '';
    /**
     * @var string
     */
    public $valueLayout;
    protected $valuesType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\PivotValue::class;
    protected $valuesDataType = 'array';
    /**
     * @param PivotGroup[]
     */
    public function setColumns($columns)
    {
        $this->columns = $columns;
    }
    /**
     * @return PivotGroup[]
     */
    public function getColumns()
    {
        return $this->columns;
    }
    /**
     * @param PivotFilterCriteria[]
     */
    public function setCriteria($criteria)
    {
        $this->criteria = $criteria;
    }
    /**
     * @return PivotFilterCriteria[]
     */
    public function getCriteria()
    {
        return $this->criteria;
    }
    /**
     * @param DataExecutionStatus
     */
    public function setDataExecutionStatus(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DataExecutionStatus $dataExecutionStatus)
    {
        $this->dataExecutionStatus = $dataExecutionStatus;
    }
    /**
     * @return DataExecutionStatus
     */
    public function getDataExecutionStatus()
    {
        return $this->dataExecutionStatus;
    }
    /**
     * @param string
     */
    public function setDataSourceId($dataSourceId)
    {
        $this->dataSourceId = $dataSourceId;
    }
    /**
     * @return string
     */
    public function getDataSourceId()
    {
        return $this->dataSourceId;
    }
    /**
     * @param PivotFilterSpec[]
     */
    public function setFilterSpecs($filterSpecs)
    {
        $this->filterSpecs = $filterSpecs;
    }
    /**
     * @return PivotFilterSpec[]
     */
    public function getFilterSpecs()
    {
        return $this->filterSpecs;
    }
    /**
     * @param PivotGroup[]
     */
    public function setRows($rows)
    {
        $this->rows = $rows;
    }
    /**
     * @return PivotGroup[]
     */
    public function getRows()
    {
        return $this->rows;
    }
    /**
     * @param GridRange
     */
    public function setSource(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\GridRange $source)
    {
        $this->source = $source;
    }
    /**
     * @return GridRange
     */
    public function getSource()
    {
        return $this->source;
    }
    /**
     * @param string
     */
    public function setValueLayout($valueLayout)
    {
        $this->valueLayout = $valueLayout;
    }
    /**
     * @return string
     */
    public function getValueLayout()
    {
        return $this->valueLayout;
    }
    /**
     * @param PivotValue[]
     */
    public function setValues($values)
    {
        $this->values = $values;
    }
    /**
     * @return PivotValue[]
     */
    public function getValues()
    {
        return $this->values;
    }
}
// Adding a class alias for backwards compatibility with the previous class name.
\class_alias(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\PivotTable::class, 'ZOOlanders\\YOOessentials\\Vendor\\Google_Service_Sheets_PivotTable');
