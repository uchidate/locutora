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

class SortSpec extends \ZOOlanders\YOOessentials\Vendor\Google\Model
{
    protected $backgroundColorType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\Color::class;
    protected $backgroundColorDataType = '';
    protected $backgroundColorStyleType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\ColorStyle::class;
    protected $backgroundColorStyleDataType = '';
    protected $dataSourceColumnReferenceType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DataSourceColumnReference::class;
    protected $dataSourceColumnReferenceDataType = '';
    /**
     * @var int
     */
    public $dimensionIndex;
    protected $foregroundColorType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\Color::class;
    protected $foregroundColorDataType = '';
    protected $foregroundColorStyleType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\ColorStyle::class;
    protected $foregroundColorStyleDataType = '';
    /**
     * @var string
     */
    public $sortOrder;
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
     * @param int
     */
    public function setDimensionIndex($dimensionIndex)
    {
        $this->dimensionIndex = $dimensionIndex;
    }
    /**
     * @return int
     */
    public function getDimensionIndex()
    {
        return $this->dimensionIndex;
    }
    /**
     * @param Color
     */
    public function setForegroundColor(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\Color $foregroundColor)
    {
        $this->foregroundColor = $foregroundColor;
    }
    /**
     * @return Color
     */
    public function getForegroundColor()
    {
        return $this->foregroundColor;
    }
    /**
     * @param ColorStyle
     */
    public function setForegroundColorStyle(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\ColorStyle $foregroundColorStyle)
    {
        $this->foregroundColorStyle = $foregroundColorStyle;
    }
    /**
     * @return ColorStyle
     */
    public function getForegroundColorStyle()
    {
        return $this->foregroundColorStyle;
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
}
// Adding a class alias for backwards compatibility with the previous class name.
\class_alias(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\SortSpec::class, 'ZOOlanders\\YOOessentials\\Vendor\\Google_Service_Sheets_SortSpec');
