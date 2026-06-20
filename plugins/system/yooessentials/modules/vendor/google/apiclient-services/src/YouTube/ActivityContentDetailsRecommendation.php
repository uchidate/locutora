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

class ActivityContentDetailsRecommendation extends \ZOOlanders\YOOessentials\Vendor\Google\Model
{
    /**
     * @var string
     */
    public $reason;
    protected $resourceIdType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ResourceId::class;
    protected $resourceIdDataType = '';
    protected $seedResourceIdType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ResourceId::class;
    protected $seedResourceIdDataType = '';
    /**
     * @param string
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
    }
    /**
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }
    /**
     * @param ResourceId
     */
    public function setResourceId(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ResourceId $resourceId)
    {
        $this->resourceId = $resourceId;
    }
    /**
     * @return ResourceId
     */
    public function getResourceId()
    {
        return $this->resourceId;
    }
    /**
     * @param ResourceId
     */
    public function setSeedResourceId(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ResourceId $seedResourceId)
    {
        $this->seedResourceId = $seedResourceId;
    }
    /**
     * @return ResourceId
     */
    public function getSeedResourceId()
    {
        return $this->seedResourceId;
    }
}
// Adding a class alias for backwards compatibility with the previous class name.
\class_alias(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ActivityContentDetailsRecommendation::class, 'ZOOlanders\\YOOessentials\\Vendor\\Google_Service_YouTube_ActivityContentDetailsRecommendation');
