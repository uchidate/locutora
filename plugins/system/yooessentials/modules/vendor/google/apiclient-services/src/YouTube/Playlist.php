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

class Playlist extends \ZOOlanders\YOOessentials\Vendor\Google\Model
{
    protected $contentDetailsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\PlaylistContentDetails::class;
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
    protected $localizationsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\PlaylistLocalization::class;
    protected $localizationsDataType = 'map';
    protected $playerType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\PlaylistPlayer::class;
    protected $playerDataType = '';
    protected $snippetType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\PlaylistSnippet::class;
    protected $snippetDataType = '';
    protected $statusType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\PlaylistStatus::class;
    protected $statusDataType = '';
    /**
     * @param PlaylistContentDetails
     */
    public function setContentDetails(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\PlaylistContentDetails $contentDetails)
    {
        $this->contentDetails = $contentDetails;
    }
    /**
     * @return PlaylistContentDetails
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
     * @param PlaylistLocalization[]
     */
    public function setLocalizations($localizations)
    {
        $this->localizations = $localizations;
    }
    /**
     * @return PlaylistLocalization[]
     */
    public function getLocalizations()
    {
        return $this->localizations;
    }
    /**
     * @param PlaylistPlayer
     */
    public function setPlayer(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\PlaylistPlayer $player)
    {
        $this->player = $player;
    }
    /**
     * @return PlaylistPlayer
     */
    public function getPlayer()
    {
        return $this->player;
    }
    /**
     * @param PlaylistSnippet
     */
    public function setSnippet(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\PlaylistSnippet $snippet)
    {
        $this->snippet = $snippet;
    }
    /**
     * @return PlaylistSnippet
     */
    public function getSnippet()
    {
        return $this->snippet;
    }
    /**
     * @param PlaylistStatus
     */
    public function setStatus(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\PlaylistStatus $status)
    {
        $this->status = $status;
    }
    /**
     * @return PlaylistStatus
     */
    public function getStatus()
    {
        return $this->status;
    }
}
// Adding a class alias for backwards compatibility with the previous class name.
\class_alias(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\Playlist::class, 'ZOOlanders\\YOOessentials\\Vendor\\Google_Service_YouTube_Playlist');
