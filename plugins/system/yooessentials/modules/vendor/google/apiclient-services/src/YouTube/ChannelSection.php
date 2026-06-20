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

class ChannelSection extends \ZOOlanders\YOOessentials\Vendor\Google\Model
{
    protected $contentDetailsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ChannelSectionContentDetails::class;
    protected $contentDetailsDataType = '';
    /**
     * @var string
     */
    public $etag;
    /**
     * @var string
     */
    public $id;
    /**
     * @var string
     */
    public $kind;
    protected $localizationsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ChannelSectionLocalization::class;
    protected $localizationsDataType = 'map';
    protected $snippetType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ChannelSectionSnippet::class;
    protected $snippetDataType = '';
    protected $targetingType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ChannelSectionTargeting::class;
    protected $targetingDataType = '';
    /**
     * @param ChannelSectionContentDetails
     */
    public function setContentDetails(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ChannelSectionContentDetails $contentDetails)
    {
        $this->contentDetails = $contentDetails;
    }
    /**
     * @return ChannelSectionContentDetails
     */
    public function getContentDetails()
    {
        return $this->contentDetails;
    }
    /**
     * @param string
     */
    public function setEtag($etag)
    {
        $this->etag = $etag;
    }
    /**
     * @return string
     */
    public function getEtag()
    {
        return $this->etag;
    }
    /**
     * @param string
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @param string
     */
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    /**
     * @return string
     */
    public function getKind()
    {
        return $this->kind;
    }
    /**
     * @param ChannelSectionLocalization[]
     */
    public function setLocalizations($localizations)
    {
        $this->localizations = $localizations;
    }
    /**
     * @return ChannelSectionLocalization[]
     */
    public function getLocalizations()
    {
        return $this->localizations;
    }
    /**
     * @param ChannelSectionSnippet
     */
    public function setSnippet(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ChannelSectionSnippet $snippet)
    {
        $this->snippet = $snippet;
    }
    /**
     * @return ChannelSectionSnippet
     */
    public function getSnippet()
    {
        return $this->snippet;
    }
    /**
     * @param ChannelSectionTargeting
     */
    public function setTargeting(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ChannelSectionTargeting $targeting)
    {
        $this->targeting = $targeting;
    }
    /**
     * @return ChannelSectionTargeting
     */
    public function getTargeting()
    {
        return $this->targeting;
    }
}
// Adding a class alias for backwards compatibility with the previous class name.
\class_alias(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ChannelSection::class, 'ZOOlanders\\YOOessentials\\Vendor\\Google_Service_YouTube_ChannelSection');
