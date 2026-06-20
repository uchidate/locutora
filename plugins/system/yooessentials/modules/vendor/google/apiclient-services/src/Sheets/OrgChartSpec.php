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

class OrgChartSpec extends \ZOOlanders\YOOessentials\Vendor\Google\Model
{
    protected $labelsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\ChartData::class;
    protected $labelsDataType = '';
    protected $nodeColorType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\Color::class;
    protected $nodeColorDataType = '';
    protected $nodeColorStyleType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\ColorStyle::class;
    protected $nodeColorStyleDataType = '';
    /**
     * @var string
     */
    public $nodeSize;
    protected $parentLabelsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\ChartData::class;
    protected $parentLabelsDataType = '';
    protected $selectedNodeColorType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\Color::class;
    protected $selectedNodeColorDataType = '';
    protected $selectedNodeColorStyleType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\ColorStyle::class;
    protected $selectedNodeColorStyleDataType = '';
    protected $tooltipsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\ChartData::class;
    protected $tooltipsDataType = '';
    /**
     * @param ChartData
     */
    public function setLabels(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\ChartData $labels)
    {
        $this->labels = $labels;
    }
    /**
     * @return ChartData
     */
    public function getLabels()
    {
        return $this->labels;
    }
    /**
     * @param Color
     */
    public function setNodeColor(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\Color $nodeColor)
    {
        $this->nodeColor = $nodeColor;
    }
    /**
     * @return Color
     */
    public function getNodeColor()
    {
        return $this->nodeColor;
    }
    /**
     * @param ColorStyle
     */
    public function setNodeColorStyle(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\ColorStyle $nodeColorStyle)
    {
        $this->nodeColorStyle = $nodeColorStyle;
    }
    /**
     * @return ColorStyle
     */
    public function getNodeColorStyle()
    {
        return $this->nodeColorStyle;
    }
    /**
     * @param string
     */
    public function setNodeSize($nodeSize)
    {
        $this->nodeSize = $nodeSize;
    }
    /**
     * @return string
     */
    public function getNodeSize()
    {
        return $this->nodeSize;
    }
    /**
     * @param ChartData
     */
    public function setParentLabels(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\ChartData $parentLabels)
    {
        $this->parentLabels = $parentLabels;
    }
    /**
     * @return ChartData
     */
    public function getParentLabels()
    {
        return $this->parentLabels;
    }
    /**
     * @param Color
     */
    public function setSelectedNodeColor(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\Color $selectedNodeColor)
    {
        $this->selectedNodeColor = $selectedNodeColor;
    }
    /**
     * @return Color
     */
    public function getSelectedNodeColor()
    {
        return $this->selectedNodeColor;
    }
    /**
     * @param ColorStyle
     */
    public function setSelectedNodeColorStyle(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\ColorStyle $selectedNodeColorStyle)
    {
        $this->selectedNodeColorStyle = $selectedNodeColorStyle;
    }
    /**
     * @return ColorStyle
     */
    public function getSelectedNodeColorStyle()
    {
        return $this->selectedNodeColorStyle;
    }
    /**
     * @param ChartData
     */
    public function setTooltips(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\ChartData $tooltips)
    {
        $this->tooltips = $tooltips;
    }
    /**
     * @return ChartData
     */
    public function getTooltips()
    {
        return $this->tooltips;
    }
}
// Adding a class alias for backwards compatibility with the previous class name.
\class_alias(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\OrgChartSpec::class, 'ZOOlanders\\YOOessentials\\Vendor\\Google_Service_Sheets_OrgChartSpec');
