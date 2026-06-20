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

class PivotGroup extends \ZOOlanders\YOOessentials\Vendor\Google\Collection
{
    protected $collection_key = 'valueMetadata';
    protected $dataSourceColumnReferenceType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DataSourceColumnReference::class;
    protected $dataSourceColumnReferenceDataType = '';
    protected $groupLimitType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\PivotGroupLimit::class;
    protected $groupLimitDataType = '';
    protected $groupRuleType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\PivotGroupRule::class;
    protected $groupRuleDataType = '';
    /**
     * @var string
     */
    public $label;
    /**
     * @var bool
     */
    public $repeatHeadings;
    /**
     * @var bool
     */
    public $showTotals;
    /**
     * @var string
     */
    public $sortOrder;
    /**
     * @var int
     */
    public $sourceColumnOffset;
    protected $valueBucketType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\PivotGroupSortValueBucket::class;
    protected $valueBucketDataType = '';
    protected $valueMetadataType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\PivotGroupValueMetadata::class;
    protected $valueMetadataDataType = 'array';
    /**
     * @param DataSourceColumnReference
     */
    public function setDataSourceColumnReference(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DataSourceColumnReference $dataSourceColumnReference)
    {
        $this->dataSourceColumnReference = $dataSourceColumnReference;
    }
    /**
     * @return DataSourceColumnReference
     */
    public function getDataSourceColumnReference()
    {
        return $this->dataSourceColumnReference;
    }
    /**
     * @param PivotGroupLimit
     */
    public function setGroupLimit(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\PivotGroupLimit $groupLimit)
    {
        $this->groupLimit = $groupLimit;
    }
    /**
     * @return PivotGroupLimit
     */
    public function getGroupLimit()
    {
        return $this->groupLimit;
    }
    /**
     * @param PivotGroupRule
     */
    public function setGroupRule(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\PivotGroupRule $groupRule)
    {
        $this->groupRule = $groupRule;
    }
    /**
     * @return PivotGroupRule
     */
    public function getGroupRule()
    {
        return $this->groupRule;
    }
    /**
     * @param string
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }
    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }
    /**
     * @param bool
     */
    public function setRepeatHeadings($repeatHeadings)
    {
        $this->repeatHeadings = $repeatHeadings;
    }
    /**
     * @return bool
     */
    public function getRepeatHeadings()
    {
        return $this->repeatHeadings;
    }
    /**
     * @param bool
     */
    public function setShowTotals($showTotals)
    {
        $this->showTotals = $showTotals;
    }
    /**
     * @return bool
     */
    public function getShowTotals()
    {
        return $this->showTotals;
    }
    /**
     * @param string
     */
    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;
    }
    /**
     * @return string
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }
    /**
     * @param int
     */
    public function setSourceColumnOffset($sourceColumnOffset)
    {
        $this->sourceColumnOffset = $sourceColumnOffset;
    }
    /**
     * @return int
     */
    public function getSourceColumnOffset()
    {
        return $this->sourceColumnOffset;
    }
    /**
     * @param PivotGroupSortValueBucket
     */
    public function setValueBucket(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\PivotGroupSortValueBucket $valueBucket)
    {
        $this->valueBucket = $valueBucket;
    }
    /**
     * @return PivotGroupSortValueBucket
     */
    public function getValueBucket()
    {
        return $this->valueBucket;
    }
    /**
     * @param PivotGroupValueMetadata[]
     */
    public function setValueMetadata($valueMetadata)
    {
        $this->valueMetadata = $valueMetadata;
    }
    /**
     * @return PivotGroupValueMetadata[]
     */
    public function getValueMetadata()
    {
        return $this->valueMetadata;
    }
}
// Adding a class alias for backwards compatibility with the previous class name.
\class_alias(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\PivotGroup::class, 'ZOOlanders\\YOOessentials\\Vendor\\Google_Service_Sheets_PivotGroup');
