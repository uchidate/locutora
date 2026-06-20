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

class FilterView extends \ZOOlanders\YOOessentials\Vendor\Google\Collection
{
    protected $collection_key = 'sortSpecs';
    protected $criteriaType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\FilterCriteria::class;
    protected $criteriaDataType = 'map';
    protected $filterSpecsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\FilterSpec::class;
    protected $filterSpecsDataType = 'array';
    /**
     * @var int
     */
    public $filterViewId;
    /**
     * @var string
     */
    public $namedRangeId;
    protected $rangeType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\GridRange::class;
    protected $rangeDataType = '';
    protected $sortSpecsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\SortSpec::class;
    protected $sortSpecsDataType = 'array';
    /**
     * @var string
     */
    public $title;
    /**
     * @param FilterCriteria[]
     */
    public function setCriteria($criteria)
    {
        $this->criteria = $criteria;
    }
    /**
     * @return FilterCriteria[]
     */
    public function getCriteria()
    {
        return $this->criteria;
    }
    /**
     * @param FilterSpec[]
     */
    public function setFilterSpecs($filterSpecs)
    {
        $this->filterSpecs = $filterSpecs;
    }
    /**
     * @return FilterSpec[]
     */
    public function getFilterSpecs()
    {
        return $this->filterSpecs;
    }
    /**
     * @param int
     */
    public function setFilterViewId($filterViewId)
    {
        $this->filterViewId = $filterViewId;
    }
    /**
     * @return int
     */
    public function getFilterViewId()
    {
        return $this->filterViewId;
    }
    /**
     * @param string
     */
    public function setNamedRangeId($namedRangeId)
    {
        $this->namedRangeId = $namedRangeId;
    }
    /**
     * @return string
     */
    public function getNamedRangeId()
    {
        return $this->namedRangeId;
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
     * @param SortSpec[]
     */
    public function setSortSpecs($sortSpecs)
    {
        $this->sortSpecs = $sortSpecs;
    }
    /**
     * @return SortSpec[]
     */
    public function getSortSpecs()
    {
        return $this->sortSpecs;
    }
    /**
     * @param string
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
}
// Adding a class alias for backwards compatibility with the previous class name.
\class_alias(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\FilterView::class, 'ZOOlanders\\YOOessentials\\Vendor\\Google_Service_Sheets_FilterView');
