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

class Channel extends \ZOOlanders\YOOessentials\Vendor\Google\Model
{
    protected $auditDetailsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ChannelAuditDetails::class;
    protected $auditDetailsDataType = '';
    protected $brandingSettingsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ChannelBrandingSettings::class;
    protected $brandingSettingsDataType = '';
    protected $contentDetailsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ChannelContentDetails::class;
    protected $contentDetailsDataType = '';
    protected $contentOwnerDetailsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ChannelContentOwnerDetails::class;
    protected $contentOwnerDetailsDataType = '';
    protected $conversionPingsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ChannelConversionPings::class;
    protected $conversionPingsDataType = '';
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
    protected $localizationsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ChannelLocalization::class;
    protected $localizationsDataType = 'map';
    protected $snippetType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ChannelSnippet::class;
    protected $snippetDataType = '';
    protected $statisticsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ChannelStatistics::class;
    protected $statisticsDataType = '';
    protected $statusType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ChannelStatus::class;
    protected $statusDataType = '';
    protected $topicDetailsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ChannelTopicDetails::class;
    protected $topicDetailsDataType = '';
    /**
     * @param ChannelAuditDetails
     */
    public function setAuditDetails(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ChannelAuditDetails $auditDetails)
    {
        $this->auditDetails = $auditDetails;
    }
    /**
     * @return ChannelAuditDetails
     */
    public function getAuditDetails()
    {
        return $this->auditDetails;
    }
    /**
     * @param ChannelBrandingSettings
     */
    public function setBrandingSettings(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ChannelBrandingSettings $brandingSettings)
    {
        $this->brandingSettings = $brandingSettings;
    }
    /**
     * @return ChannelBrandingSettings
     */
    public function getBrandingSettings()
    {
        return $this->brandingSettings;
    }
    /**
     * @param ChannelContentDetails
     */
    public function setContentDetails(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ChannelContentDetails $contentDetails)
    {
        $this->contentDetails = $contentDetails;
    }
    /**
     * @return ChannelContentDetails
     */
    public function getContentDetails()
    {
        return $this->contentDetails;
    }
    /**
     * @param ChannelContentOwnerDetails
     */
    public function setContentOwnerDetails(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ChannelContentOwnerDetails $contentOwnerDetails)
    {
        $this->contentOwnerDetails = $contentOwnerDetails;
    }
    /**
     * @return ChannelContentOwnerDetails
     */
    public function getContentOwnerDetails()
    {
        return $this->contentOwnerDetails;
    }
    /**
     * @param ChannelConversionPings
     */
    public function setConversionPings(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ChannelConversionPings $conversionPings)
    {
        $this->conversionPings = $conversionPings;
    }
    /**
     * @return ChannelConversionPings
     */
    public function getConversionPings()
    {
        return $this->conversionPings;
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
     * @param ChannelLocalization[]
     */
    public function setLocalizations($localizations)
    {
        $this->localizations = $localizations;
    }
    /**
     * @return ChannelLocalization[]
     */
    public function getLocalizations()
    {
        return $this->localizations;
    }
    /**
     * @param ChannelSnippet
     */
    public function setSnippet(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ChannelSnippet $snippet)
    {
        $this->snippet = $snippet;
    }
    /**
     * @return ChannelSnippet
     */
    public function getSnippet()
    {
        return $this->snippet;
    }
    /**
     * @param ChannelStatistics
     */
    public function setStatistics(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ChannelStatistics $statistics)
    {
        $this->statistics = $statistics;
    }
    /**
     * @return ChannelStatistics
     */
    public function getStatistics()
    {
        return $this->statistics;
    }
    /**
     * @param ChannelStatus
     */
    public function setStatus(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ChannelStatus $status)
    {
        $this->status = $status;
    }
    /**
     * @return ChannelStatus
     */
    public function getStatus()
    {
        return $this->status;
    }
    /**
     * @param ChannelTopicDetails
     */
    public function setTopicDetails(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ChannelTopicDetails $topicDetails)
    {
        $this->topicDetails = $topicDetails;
    }
    /**
     * @return ChannelTopicDetails
     */
    public function getTopicDetails()
    {
        return $this->topicDetails;
    }
}
// Adding a class alias for backwards compatibility with the previous class name.
\class_alias(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\Channel::class, 'ZOOlanders\\YOOessentials\\Vendor\\Google_Service_YouTube_Channel');
