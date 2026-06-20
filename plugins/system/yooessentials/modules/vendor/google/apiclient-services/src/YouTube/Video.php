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

class Video extends \ZOOlanders\YOOessentials\Vendor\Google\Model
{
    protected $ageGatingType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\VideoAgeGating::class;
    protected $ageGatingDataType = '';
    protected $contentDetailsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\VideoContentDetails::class;
    protected $contentDetailsDataType = '';
    /**
     * @var string
     */
    public $etag;
    protected $fileDetailsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\VideoFileDetails::class;
    protected $fileDetailsDataType = '';
    /**
     * @var string
     */
    public $id;
    /**
     * @var string
     */
    public $kind;
    protected $liveStreamingDetailsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\VideoLiveStreamingDetails::class;
    protected $liveStreamingDetailsDataType = '';
    protected $localizationsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\VideoLocalization::class;
    protected $localizationsDataType = 'map';
    protected $monetizationDetailsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\VideoMonetizationDetails::class;
    protected $monetizationDetailsDataType = '';
    protected $playerType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\VideoPlayer::class;
    protected $playerDataType = '';
    protected $processingDetailsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\VideoProcessingDetails::class;
    protected $processingDetailsDataType = '';
    protected $projectDetailsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\VideoProjectDetails::class;
    protected $projectDetailsDataType = '';
    protected $recordingDetailsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\VideoRecordingDetails::class;
    protected $recordingDetailsDataType = '';
    protected $snippetType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\VideoSnippet::class;
    protected $snippetDataType = '';
    protected $statisticsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\VideoStatistics::class;
    protected $statisticsDataType = '';
    protected $statusType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\VideoStatus::class;
    protected $statusDataType = '';
    protected $suggestionsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\VideoSuggestions::class;
    protected $suggestionsDataType = '';
    protected $topicDetailsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\VideoTopicDetails::class;
    protected $topicDetailsDataType = '';
    /**
     * @param VideoAgeGating
     */
    public function setAgeGating(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\VideoAgeGating $ageGating)
    {
        $this->ageGating = $ageGating;
    }
    /**
     * @return VideoAgeGating
     */
    public function getAgeGating()
    {
        return $this->ageGating;
    }
    /**
     * @param VideoContentDetails
     */
    public function setContentDetails(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\VideoContentDetails $contentDetails)
    {
        $this->contentDetails = $contentDetails;
    }
    /**
     * @return VideoContentDetails
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
     * @param VideoFileDetails
     */
    public function setFileDetails(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\VideoFileDetails $fileDetails)
    {
        $this->fileDetails = $fileDetails;
    }
    /**
     * @return VideoFileDetails
     */
    public function getFileDetails()
    {
        return $this->fileDetails;
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
     * @param VideoLiveStreamingDetails
     */
    public function setLiveStreamingDetails(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\VideoLiveStreamingDetails $liveStreamingDetails)
    {
        $this->liveStreamingDetails = $liveStreamingDetails;
    }
    /**
     * @return VideoLiveStreamingDetails
     */
    public function getLiveStreamingDetails()
    {
        return $this->liveStreamingDetails;
    }
    /**
     * @param VideoLocalization[]
     */
    public function setLocalizations($localizations)
    {
        $this->localizations = $localizations;
    }
    /**
     * @return VideoLocalization[]
     */
    public function getLocalizations()
    {
        return $this->localizations;
    }
    /**
     * @param VideoMonetizationDetails
     */
    public function setMonetizationDetails(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\VideoMonetizationDetails $monetizationDetails)
    {
        $this->monetizationDetails = $monetizationDetails;
    }
    /**
     * @return VideoMonetizationDetails
     */
    public function getMonetizationDetails()
    {
        return $this->monetizationDetails;
    }
    /**
     * @param VideoPlayer
     */
    public function setPlayer(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\VideoPlayer $player)
    {
        $this->player = $player;
    }
    /**
     * @return VideoPlayer
     */
    public function getPlayer()
    {
        return $this->player;
    }
    /**
     * @param VideoProcessingDetails
     */
    public function setProcessingDetails(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\VideoProcessingDetails $processingDetails)
    {
        $this->processingDetails = $processingDetails;
    }
    /**
     * @return VideoProcessingDetails
     */
    public function getProcessingDetails()
    {
        return $this->processingDetails;
    }
    /**
     * @param VideoProjectDetails
     */
    public function setProjectDetails(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\VideoProjectDetails $projectDetails)
    {
        $this->projectDetails = $projectDetails;
    }
    /**
     * @return VideoProjectDetails
     */
    public function getProjectDetails()
    {
        return $this->projectDetails;
    }
    /**
     * @param VideoRecordingDetails
     */
    public function setRecordingDetails(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\VideoRecordingDetails $recordingDetails)
    {
        $this->recordingDetails = $recordingDetails;
    }
    /**
     * @return VideoRecordingDetails
     */
    public function getRecordingDetails()
    {
        return $this->recordingDetails;
    }
    /**
     * @param VideoSnippet
     */
    public function setSnippet(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\VideoSnippet $snippet)
    {
        $this->snippet = $snippet;
    }
    /**
     * @return VideoSnippet
     */
    public function getSnippet()
    {
        return $this->snippet;
    }
    /**
     * @param VideoStatistics
     */
    public function setStatistics(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\VideoStatistics $statistics)
    {
        $this->statistics = $statistics;
    }
    /**
     * @return VideoStatistics
     */
    public function getStatistics()
    {
        return $this->statistics;
    }
    /**
     * @param VideoStatus
     */
    public function setStatus(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\VideoStatus $status)
    {
        $this->status = $status;
    }
    /**
     * @return VideoStatus
     */
    public function getStatus()
    {
        return $this->status;
    }
    /**
     * @param VideoSuggestions
     */
    public function setSuggestions(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\VideoSuggestions $suggestions)
    {
        $this->suggestions = $suggestions;
    }
    /**
     * @return VideoSuggestions
     */
    public function getSuggestions()
    {
        return $this->suggestions;
    }
    /**
     * @param VideoTopicDetails
     */
    public function setTopicDetails(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\VideoTopicDetails $topicDetails)
    {
        $this->topicDetails = $topicDetails;
    }
    /**
     * @return VideoTopicDetails
     */
    public function getTopicDetails()
    {
        return $this->topicDetails;
    }
}
// Adding a class alias for backwards compatibility with the previous class name.
\class_alias(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\Video::class, 'ZOOlanders\\YOOessentials\\Vendor\\Google_Service_YouTube_Video');
