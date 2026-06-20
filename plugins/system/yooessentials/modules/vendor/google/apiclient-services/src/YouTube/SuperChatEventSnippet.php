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

class SuperChatEventSnippet extends \ZOOlanders\YOOessentials\Vendor\Google\Model
{
    /**
     * @var string
     */
    public $amountMicros;
    /**
     * @var string
     */
    public $channelId;
    /**
     * @var string
     */
    public $commentText;
    /**
     * @var string
     */
    public $createdAt;
    /**
     * @var string
     */
    public $currency;
    /**
     * @var string
     */
    public $displayString;
    /**
     * @var bool
     */
    public $isSuperStickerEvent;
    /**
     * @var string
     */
    public $messageType;
    protected $superStickerMetadataType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\SuperStickerMetadata::class;
    protected $superStickerMetadataDataType = '';
    protected $supporterDetailsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ChannelProfileDetails::class;
    protected $supporterDetailsDataType = '';
    /**
     * @param string
     */
    public function setAmountMicros($amountMicros)
    {
        $this->amountMicros = $amountMicros;
    }
    /**
     * @return string
     */
    public function getAmountMicros()
    {
        return $this->amountMicros;
    }
    /**
     * @param string
     */
    public function setChannelId($channelId)
    {
        $this->channelId = $channelId;
    }
    /**
     * @return string
     */
    public function getChannelId()
    {
        return $this->channelId;
    }
    /**
     * @param string
     */
    public function setCommentText($commentText)
    {
        $this->commentText = $commentText;
    }
    /**
     * @return string
     */
    public function getCommentText()
    {
        return $this->commentText;
    }
    /**
     * @param string
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }
    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    /**
     * @param string
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }
    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }
    /**
     * @param string
     */
    public function setDisplayString($displayString)
    {
        $this->displayString = $displayString;
    }
    /**
     * @return string
     */
    public function getDisplayString()
    {
        return $this->displayString;
    }
    /**
     * @param bool
     */
    public function setIsSuperStickerEvent($isSuperStickerEvent)
    {
        $this->isSuperStickerEvent = $isSuperStickerEvent;
    }
    /**
     * @return bool
     */
    public function getIsSuperStickerEvent()
    {
        return $this->isSuperStickerEvent;
    }
    /**
     * @param string
     */
    public function setMessageType($messageType)
    {
        $this->messageType = $messageType;
    }
    /**
     * @return string
     */
    public function getMessageType()
    {
        return $this->messageType;
    }
    /**
     * @param SuperStickerMetadata
     */
    public function setSuperStickerMetadata(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\SuperStickerMetadata $superStickerMetadata)
    {
        $this->superStickerMetadata = $superStickerMetadata;
    }
    /**
     * @return SuperStickerMetadata
     */
    public function getSuperStickerMetadata()
    {
        return $this->superStickerMetadata;
    }
    /**
     * @param ChannelProfileDetails
     */
    public function setSupporterDetails(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\ChannelProfileDetails $supporterDetails)
    {
        $this->supporterDetails = $supporterDetails;
    }
    /**
     * @return ChannelProfileDetails
     */
    public function getSupporterDetails()
    {
        return $this->supporterDetails;
    }
}
// Adding a class alias for backwards compatibility with the previous class name.
\class_alias(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\SuperChatEventSnippet::class, 'ZOOlanders\\YOOessentials\\Vendor\\Google_Service_YouTube_SuperChatEventSnippet');
