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

class ActivityContentDetails extends \ZOOlanders\YOOessentials\Vendor\Google\Model
{
    protected $bulletinType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ActivityContentDetailsBulletin::class;
    protected $bulletinDataType = '';
    protected $channelItemType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ActivityContentDetailsChannelItem::class;
    protected $channelItemDataType = '';
    protected $commentType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ActivityContentDetailsComment::class;
    protected $commentDataType = '';
    protected $favoriteType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ActivityContentDetailsFavorite::class;
    protected $favoriteDataType = '';
    protected $likeType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ActivityContentDetailsLike::class;
    protected $likeDataType = '';
    protected $playlistItemType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ActivityContentDetailsPlaylistItem::class;
    protected $playlistItemDataType = '';
    protected $promotedItemType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ActivityContentDetailsPromotedItem::class;
    protected $promotedItemDataType = '';
    protected $recommendationType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ActivityContentDetailsRecommendation::class;
    protected $recommendationDataType = '';
    protected $socialType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ActivityContentDetailsSocial::class;
    protected $socialDataType = '';
    protected $subscriptionType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ActivityContentDetailsSubscription::class;
    protected $subscriptionDataType = '';
    protected $uploadType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ActivityContentDetailsUpload::class;
    protected $uploadDataType = '';
    /**
     * @param ActivityContentDetailsBulletin
     */
    public function setBulletin(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ActivityContentDetailsBulletin $bulletin)
    {
        $this->bulletin = $bulletin;
    }
    /**
     * @return ActivityContentDetailsBulletin
     */
    public function getBulletin()
    {
        return $this->bulletin;
    }
    /**
     * @param ActivityContentDetailsChannelItem
     */
    public function setChannelItem(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ActivityContentDetailsChannelItem $channelItem)
    {
        $this->channelItem = $channelItem;
    }
    /**
     * @return ActivityContentDetailsChannelItem
     */
    public function getChannelItem()
    {
        return $this->channelItem;
    }
    /**
     * @param ActivityContentDetailsComment
     */
    public function setComment(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ActivityContentDetailsComment $comment)
    {
        $this->comment = $comment;
    }
    /**
     * @return ActivityContentDetailsComment
     */
    public function getComment()
    {
        return $this->comment;
    }
    /**
     * @param ActivityContentDetailsFavorite
     */
    public function setFavorite(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ActivityContentDetailsFavorite $favorite)
    {
        $this->favorite = $favorite;
    }
    /**
     * @return ActivityContentDetailsFavorite
     */
    public function getFavorite()
    {
        return $this->favorite;
    }
    /**
     * @param ActivityContentDetailsLike
     */
    public function setLike(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ActivityContentDetailsLike $like)
    {
        $this->like = $like;
    }
    /**
     * @return ActivityContentDetailsLike
     */
    public function getLike()
    {
        return $this->like;
    }
    /**
     * @param ActivityContentDetailsPlaylistItem
     */
    public function setPlaylistItem(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ActivityContentDetailsPlaylistItem $playlistItem)
    {
        $this->playlistItem = $playlistItem;
    }
    /**
     * @return ActivityContentDetailsPlaylistItem
     */
    public function getPlaylistItem()
    {
        return $this->playlistItem;
    }
    /**
     * @param ActivityContentDetailsPromotedItem
     */
    public function setPromotedItem(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ActivityContentDetailsPromotedItem $promotedItem)
    {
        $this->promotedItem = $promotedItem;
    }
    /**
     * @return ActivityContentDetailsPromotedItem
     */
    public function getPromotedItem()
    {
        return $this->promotedItem;
    }
    /**
     * @param ActivityContentDetailsRecommendation
     */
    public function setRecommendation(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ActivityContentDetailsRecommendation $recommendation)
    {
        $this->recommendation = $recommendation;
    }
    /**
     * @return ActivityContentDetailsRecommendation
     */
    public function getRecommendation()
    {
        return $this->recommendation;
    }
    /**
     * @param ActivityContentDetailsSocial
     */
    public function setSocial(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ActivityContentDetailsSocial $social)
    {
        $this->social = $social;
    }
    /**
     * @return ActivityContentDetailsSocial
     */
    public function getSocial()
    {
        return $this->social;
    }
    /**
     * @param ActivityContentDetailsSubscription
     */
    public function setSubscription(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ActivityContentDetailsSubscription $subscription)
    {
        $this->subscription = $subscription;
    }
    /**
     * @return ActivityContentDetailsSubscription
     */
    public function getSubscription()
    {
        return $this->subscription;
    }
    /**
     * @param ActivityContentDetailsUpload
     */
    public function setUpload(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ActivityContentDetailsUpload $upload)
    {
        $this->upload = $upload;
    }
    /**
     * @return ActivityContentDetailsUpload
     */
    public function getUpload()
    {
        return $this->upload;
    }
}
// Adding a class alias for backwards compatibility with the previous class name.
\class_alias(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ActivityContentDetails::class, 'ZOOlanders\\YOOessentials\\Vendor\\Google_Service_YouTube_ActivityContentDetails');
