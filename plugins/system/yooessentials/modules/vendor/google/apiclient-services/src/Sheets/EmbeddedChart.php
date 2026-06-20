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

class EmbeddedChart extends \ZOOlanders\YOOessentials\Vendor\Google\Model
{
    protected $borderType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\EmbeddedObjectBorder::class;
    protected $borderDataType = '';
    /**
     * @var int
     */
    public $chartId;
    protected $positionType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\EmbeddedObjectPosition::class;
    protected $positionDataType = '';
    protected $specType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\ChartSpec::class;
    protected $specDataType = '';
    /**
     * @param EmbeddedObjectBorder
     */
    public function setBorder(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\EmbeddedObjectBorder $border)
    {
        $this->border = $border;
    }
    /**
     * @return EmbeddedObjectBorder
     */
    public function getBorder()
    {
        return $this->border;
    }
    /**
     * @param int
     */
    public function setChartId($chartId)
    {
        $this->chartId = $chartId;
    }
    /**
     * @return int
     */
    public function getChartId()
    {
        return $this->chartId;
    }
    /**
     * @param EmbeddedObjectPosition
     */
    public function setPosition(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\EmbeddedObjectPosition $position)
    {
        $this->position = $position;
    }
    /**
     * @return EmbeddedObjectPosition
     */
    public function getPosition()
    {
        return $this->position;
    }
    /**
     * @param ChartSpec
     */
    public function setSpec(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\ChartSpec $spec)
    {
        $this->spec = $spec;
    }
    /**
     * @return ChartSpec
     */
    public function getSpec()
    {
        return $this->spec;
    }
}
// Adding a class alias for backwards compatibility with the previous class name.
\class_alias(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\EmbeddedChart::class, 'ZOOlanders\\YOOessentials\\Vendor\\Google_Service_Sheets_EmbeddedChart');
