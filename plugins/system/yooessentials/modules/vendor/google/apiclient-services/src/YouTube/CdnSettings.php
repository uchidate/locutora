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
namespace ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube;

class CdnSettings extends \ZOOlanders\YOOessentials\Vendor\Google\Model
{
    /**
     * @var string
     */
    public $format;
    /**
     * @var string
     */
    public $frameRate;
    protected $ingestionInfoType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\IngestionInfo::class;
    protected $ingestionInfoDataType = '';
    /**
     * @var string
     */
    public $ingestionType;
    /**
     * @var string
     */
    public $resolution;
    /**
     * @param string
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }
    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }
    /**
     * @param string
     */
    public function setFrameRate($frameRate)
    {
        $this->frameRate = $frameRate;
    }
    /**
     * @return string
     */
    public function getFrameRate()
    {
        return $this->frameRate;
    }
    /**
     * @param IngestionInfo
     */
    public function setIngestionInfo(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\IngestionInfo $ingestionInfo)
    {
        $this->ingestionInfo = $ingestionInfo;
    }
    /**
     * @return IngestionInfo
     */
    public function getIngestionInfo()
    {
        return $this->ingestionInfo;
    }
    /**
     * @param string
     */
    public function setIngestionType($ingestionType)
    {
        $this->ingestionType = $ingestionType;
    }
    /**
     * @return string
     */
    public function getIngestionType()
    {
        return $this->ingestionType;
    }
    /**
     * @param string
     */
    public function setResolution($resolution)
    {
        $this->resolution = $resolution;
    }
    /**
     * @return string
     */
    public function getResolution()
    {
        return $this->resolution;
    }
}
// Adding a class alias for backwards compatibility with the previous class name.
\class_alias(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\CdnSettings::class, 'ZOOlanders\\YOOessentials\\Vendor\\Google_Service_YouTube_CdnSettings');
