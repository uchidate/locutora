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

class DataSourceRefreshMonthlySchedule extends \ZOOlanders\YOOessentials\Vendor\Google\Collection
{
    protected $collection_key = 'daysOfMonth';
    /**
     * @var int[]
     */
    public $daysOfMonth;
    protected $startTimeType = \ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\TimeOfDay::class;
    protected $startTimeDataType = '';
    /**
     * @param int[]
     */
    public function setDaysOfMonth($daysOfMonth)
    {
        $this->daysOfMonth = $daysOfMonth;
    }
    /**
     * @return int[]
     */
    public function getDaysOfMonth()
    {
        return $this->daysOfMonth;
    }
    /**
     * @param TimeOfDay
     */
    public function setStartTime(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\TimeOfDay $startTime)
    {
        $this->startTime = $startTime;
    }
    /**
     * @return TimeOfDay
     */
    public function getStartTime()
    {
        return $this->startTime;
    }
}
// Adding a class alias for backwards compatibility with the previous class name.
\class_alias(\ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\DataSourceRefreshMonthlySchedule::class, 'ZOOlanders\\YOOessentials\\Vendor\\Google_Service_Sheets_DataSourceRefreshMonthlySchedule');
