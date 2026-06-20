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

class SlicerSpec extends \ZOOlanders\YOOessentials\Vendor\Google\Model
{
    /**
     * @var bool
     */
    public $applyToPivotTables;
    protected $backgroundColorType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\Color::class;
    protected $backgroundColorDataType = '';
    protected $backgroundColorStyleType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\ColorStyle::class;
    protected $backgroundColorStyleDataType = '';
    /**
     * @var int
     */
    public $columnIndex;
    protected $dataRangeType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\GridRange::class;
    protected $dataRangeDataType = '';
    protected $filterCriteriaType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\FilterCriteria::class;
    protected $filterCriteriaDataType = '';
    /**
     * @var string
     */
    public $horizontalAlignment;
    protected $textFormatType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\TextFormat::class;
    protected $textFormatDataType = '';
    /**
     * @var string
     */
    public $title;
    /**
     * @param bool
     */
    public function setApplyToPivotTables($applyToPivotTables)
    {
        $this->applyToPivotTables = $applyToPivotTables;
    }
    /**
     * @return bool
     */
    public function getApplyToPivotTables()
    {
        return $this->applyToPivotTables;
    }
    /**
     * @param Color
     */
    public function setBackgroundColor(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\Color $backgroundColor)
    {
        $this->backgroundColor = $backgroundColor;
    }
    /**
     * @return Color
     */
    public function getBackgroundColor()
    {
        return $this->backgroundColor;
    }
    /**
     * @param ColorStyle
     */
    public function setBackgroundColorStyle(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\ColorStyle $backgroundColorStyle)
    {
        $this->backgroundColorStyle = $backgroundColorStyle;
    }
    /**
     * @return ColorStyle
     */
    public function getBackgroundColorStyle()
    {
        return $this->backgroundColorStyle;
    }
    /**
     * @param int
     */
    public function setColumnIndex($columnIndex)
    {
        $this->columnIndex = $columnIndex;
    }
    /**
     * @return int
     */
    public function getColumnIndex()
    {
        return $this->columnIndex;
    }
    /**
     * @param GridRange
     */
    public function setDataRange(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\GridRange $dataRange)
    {
        $this->dataRange = $dataRange;
    }
    /**
     * @return GridRange
     */
    public function getDataRange()
    {
        return $this->dataRange;
    }
    /**
     * @param FilterCriteria
     */
    public function setFilterCriteria(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\FilterCriteria $filterCriteria)
    {
        $this->filterCriteria = $filterCriteria;
    }
    /**
     * @return FilterCriteria
     */
    public function getFilterCriteria()
    {
        return $this->filterCriteria;
    }
    /**
     * @param string
     */
    public function setHorizontalAlignment($horizontalAlignment)
    {
        $this->horizontalAlignment = $horizontalAlignment;
    }
    /**
     * @return string
     */
    public function getHorizontalAlignment()
    {
        return $this->horizontalAlignment;
    }
    /**
     * @param TextFormat
     */
    public function setTextFormat(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\TextFormat $textFormat)
    {
        $this->textFormat = $textFormat;
    }
    /**
     * @return TextFormat
     */
    public function getTextFormat()
    {
        return $this->textFormat;
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
\class_alias(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\SlicerSpec::class, 'ZOOlanders\\YOOessentials\\Vendor\\Google_Service_Sheets_SlicerSpec');
