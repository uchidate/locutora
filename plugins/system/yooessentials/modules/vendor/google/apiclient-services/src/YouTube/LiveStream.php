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

class LiveStream extends \ZOOlanders\YOOessentials\Vendor\Google\Model
{
    protected $cdnType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\CdnSettings::class;
    protected $cdnDataType = '';
    protected $contentDetailsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\LiveStreamContentDetails::class;
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
    protected $snippetType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\LiveStreamSnippet::class;
    protected $snippetDataType = '';
    protected $statusType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\LiveStreamStatus::class;
    protected $statusDataType = '';
    /**
     * @param CdnSettings
     */
    public function setCdn(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\CdnSettings $cdn)
    {
        $this->cdn = $cdn;
    }
    /**
     * @return CdnSettings
     */
    public function getCdn()
    {
        return $this->cdn;
    }
    /**
     * @param LiveStreamContentDetails
     */
    public function setContentDetails(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\LiveStreamContentDetails $contentDetails)
    {
        $this->contentDetails = $contentDetails;
    }
    /**
     * @return LiveStreamContentDetails
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
     * @param LiveStreamSnippet
     */
    public function setSnippet(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\LiveStreamSnippet $snippet)
    {
        $this->snippet = $snippet;
    }
    /**
     * @return LiveStreamSnippet
     */
    public function getSnippet()
    {
        return $this->snippet;
    }
    /**
     * @param LiveStreamStatus
     */
    public function setStatus(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\LiveStreamStatus $status)
    {
        $this->status = $status;
    }
    /**
     * @return LiveStreamStatus
     */
    public function getStatus()
    {
        return $this->status;
    }
}
// Adding a class alias for backwards compatibility with the previous class name.
\class_alias(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\LiveStream::class, 'ZOOlanders\\YOOessentials\\Vendor\\Google_Service_YouTube_LiveStream');
