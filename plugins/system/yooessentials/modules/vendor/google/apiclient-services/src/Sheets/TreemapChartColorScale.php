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

class TreemapChartColorScale extends \ZOOlanders\YOOessentials\Vendor\Google\Model
{
    protected $maxValueColorType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\Color::class;
    protected $maxValueColorDataType = '';
    protected $maxValueColorStyleType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\ColorStyle::class;
    protected $maxValueColorStyleDataType = '';
    protected $midValueColorType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\Color::class;
    protected $midValueColorDataType = '';
    protected $midValueColorStyleType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\ColorStyle::class;
    protected $midValueColorStyleDataType = '';
    protected $minValueColorType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\Color::class;
    protected $minValueColorDataType = '';
    protected $minValueColorStyleType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\ColorStyle::class;
    protected $minValueColorStyleDataType = '';
    protected $noDataColorType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\Color::class;
    protected $noDataColorDataType = '';
    protected $noDataColorStyleType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\ColorStyle::class;
    protected $noDataColorStyleDataType = '';
    /**
     * @param Color
     */
    public function setMaxValueColor(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\Color $maxValueColor)
    {
        $this->maxValueColor = $maxValueColor;
    }
    /**
     * @return Color
     */
    public function getMaxValueColor()
    {
        return $this->maxValueColor;
    }
    /**
     * @param ColorStyle
     */
    public function setMaxValueColorStyle(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\ColorStyle $maxValueColorStyle)
    {
        $this->maxValueColorStyle = $maxValueColorStyle;
    }
    /**
     * @return ColorStyle
     */
    public function getMaxValueColorStyle()
    {
        return $this->maxValueColorStyle;
    }
    /**
     * @param Color
     */
    public function setMidValueColor(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\Color $midValueColor)
    {
        $this->midValueColor = $midValueColor;
    }
    /**
     * @return Color
     */
    public function getMidValueColor()
    {
        return $this->midValueColor;
    }
    /**
     * @param ColorStyle
     */
    public function setMidValueColorStyle(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\ColorStyle $midValueColorStyle)
    {
        $this->midValueColorStyle = $midValueColorStyle;
    }
    /**
     * @return ColorStyle
     */
    public function getMidValueColorStyle()
    {
        return $this->midValueColorStyle;
    }
    /**
     * @param Color
     */
    public function setMinValueColor(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\Color $minValueColor)
    {
        $this->minValueColor = $minValueColor;
    }
    /**
     * @return Color
     */
    public function getMinValueColor()
    {
        return $this->minValueColor;
    }
    /**
     * @param ColorStyle
     */
    public function setMinValueColorStyle(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\ColorStyle $minValueColorStyle)
    {
        $this->minValueColorStyle = $minValueColorStyle;
    }
    /**
     * @return ColorStyle
     */
    public function getMinValueColorStyle()
    {
        return $this->minValueColorStyle;
    }
    /**
     * @param Color
     */
    public function setNoDataColor(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\Color $noDataColor)
    {
        $this->noDataColor = $noDataColor;
    }
    /**
     * @return Color
     */
    public function getNoDataColor()
    {
        return $this->noDataColor;
    }
    /**
     * @param ColorStyle
     */
    public function setNoDataColorStyle(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\ColorStyle $noDataColorStyle)
    {
        $this->noDataColorStyle = $noDataColorStyle;
    }
    /**
     * @return ColorStyle
     */
    public function getNoDataColorStyle()
    {
        return $this->noDataColorStyle;
    }
}
// Adding a class alias for backwards compatibility with the previous class name.
\class_alias(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\TreemapChartColorScale::class, 'ZOOlanders\\YOOessentials\\Vendor\\Google_Service_Sheets_TreemapChartColorScale');
