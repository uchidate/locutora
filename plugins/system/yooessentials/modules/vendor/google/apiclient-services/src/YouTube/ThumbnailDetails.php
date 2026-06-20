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

class ThumbnailDetails extends \ZOOlanders\YOOessentials\Vendor\Google\Model
{
    protected $defaultType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\Thumbnail::class;
    protected $defaultDataType = '';
    protected $highType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\Thumbnail::class;
    protected $highDataType = '';
    protected $maxresType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\Thumbnail::class;
    protected $maxresDataType = '';
    protected $mediumType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\Thumbnail::class;
    protected $mediumDataType = '';
    protected $standardType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\Thumbnail::class;
    protected $standardDataType = '';
    /**
     * @param Thumbnail
     */
    public function setDefault(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\Thumbnail $default)
    {
        $this->default = $default;
    }
    /**
     * @return Thumbnail
     */
    public function getDefault()
    {
        return $this->default;
    }
    /**
     * @param Thumbnail
     */
    public function setHigh(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\Thumbnail $high)
    {
        $this->high = $high;
    }
    /**
     * @return Thumbnail
     */
    public function getHigh()
    {
        return $this->high;
    }
    /**
     * @param Thumbnail
     */
    public function setMaxres(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\Thumbnail $maxres)
    {
        $this->maxres = $maxres;
    }
    /**
     * @return Thumbnail
     */
    public function getMaxres()
    {
        return $this->maxres;
    }
    /**
     * @param Thumbnail
     */
    public function setMedium(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\Thumbnail $medium)
    {
        $this->medium = $medium;
    }
    /**
     * @return Thumbnail
     */
    public function getMedium()
    {
        return $this->medium;
    }
    /**
     * @param Thumbnail
     */
    public function setStandard(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\Thumbnail $standard)
    {
        $this->standard = $standard;
    }
    /**
     * @return Thumbnail
     */
    public function getStandard()
    {
        return $this->standard;
    }
}
// Adding a class alias for backwards compatibility with the previous class name.
\class_alias(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ThumbnailDetails::class, 'ZOOlanders\\YOOessentials\\Vendor\\Google_Service_YouTube_ThumbnailDetails');
