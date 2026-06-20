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

class AutoFillRequest extends \ZOOlanders\YOOessentials\Vendor\Google\Model
{
    protected $rangeType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\GridRange::class;
    protected $rangeDataType = '';
    protected $sourceAndDestinationType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\SourceAndDestination::class;
    protected $sourceAndDestinationDataType = '';
    /**
     * @var bool
     */
    public $useAlternateSeries;
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
     * @param SourceAndDestination
     */
    public function setSourceAndDestination(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\SourceAndDestination $sourceAndDestination)
    {
        $this->sourceAndDestination = $sourceAndDestination;
    }
    /**
     * @return SourceAndDestination
     */
    public function getSourceAndDestination()
    {
        return $this->sourceAndDestination;
    }
    /**
     * @param bool
     */
    public function setUseAlternateSeries($useAlternateSeries)
    {
        $this->useAlternateSeries = $useAlternateSeries;
    }
    /**
     * @return bool
     */
    public function getUseAlternateSeries()
    {
        return $this->useAlternateSeries;
    }
}
// Adding a class alias for backwards compatibility with the previous class name.
\class_alias(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\AutoFillRequest::class, 'ZOOlanders\\YOOessentials\\Vendor\\Google_Service_Sheets_AutoFillRequest');
