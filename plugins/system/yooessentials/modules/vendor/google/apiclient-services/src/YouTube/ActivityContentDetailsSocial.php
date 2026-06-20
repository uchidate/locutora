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

class ActivityContentDetailsSocial extends \ZOOlanders\YOOessentials\Vendor\Google\Model
{
    /**
     * @var string
     */
    public $author;
    /**
     * @var string
     */
    public $imageUrl;
    /**
     * @var string
     */
    public $referenceUrl;
    protected $resourceIdType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ResourceId::class;
    protected $resourceIdDataType = '';
    /**
     * @var string
     */
    public $type;
    /**
     * @param string
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }
    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }
    /**
     * @param string
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
    }
    /**
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }
    /**
     * @param string
     */
    public function setReferenceUrl($referenceUrl)
    {
        $this->referenceUrl = $referenceUrl;
    }
    /**
     * @return string
     */
    public function getReferenceUrl()
    {
        return $this->referenceUrl;
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
     * @param string
     */
    public function setType($type)
    {
        $this->type = $type;
    }
    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
// Adding a class alias for backwards compatibility with the previous class name.
\class_alias(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ActivityContentDetailsSocial::class, 'ZOOlanders\\YOOessentials\\Vendor\\Google_Service_YouTube_ActivityContentDetailsSocial');
