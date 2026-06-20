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

class LiveChatMessageSnippet extends \ZOOlanders\YOOessentials\Vendor\Google\Model
{
    /**
     * @var string
     */
    public $authorChannelId;
    /**
     * @var string
     */
    public $displayMessage;
    protected $fanFundingEventDetailsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\LiveChatFanFundingEventDetails::class;
    protected $fanFundingEventDetailsDataType = '';
    protected $giftMembershipReceivedDetailsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\LiveChatGiftMembershipReceivedDetails::class;
    protected $giftMembershipReceivedDetailsDataType = '';
    /**
     * @var bool
     */
    public $hasDisplayContent;
    /**
     * @var string
     */
    public $liveChatId;
    protected $memberMilestoneChatDetailsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\LiveChatMemberMilestoneChatDetails::class;
    protected $memberMilestoneChatDetailsDataType = '';
    protected $membershipGiftingDetailsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\LiveChatMembershipGiftingDetails::class;
    protected $membershipGiftingDetailsDataType = '';
    protected $messageDeletedDetailsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\LiveChatMessageDeletedDetails::class;
    protected $messageDeletedDetailsDataType = '';
    protected $messageRetractedDetailsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\LiveChatMessageRetractedDetails::class;
    protected $messageRetractedDetailsDataType = '';
    protected $newSponsorDetailsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\LiveChatNewSponsorDetails::class;
    protected $newSponsorDetailsDataType = '';
    /**
     * @var string
     */
    public $publishedAt;
    protected $superChatDetailsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\LiveChatSuperChatDetails::class;
    protected $superChatDetailsDataType = '';
    protected $superStickerDetailsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\LiveChatSuperStickerDetails::class;
    protected $superStickerDetailsDataType = '';
    protected $textMessageDetailsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\LiveChatTextMessageDetails::class;
    protected $textMessageDetailsDataType = '';
    /**
     * @var string
     */
    public $type;
    protected $userBannedDetailsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\LiveChatUserBannedMessageDetails::class;
    protected $userBannedDetailsDataType = '';
    /**
     * @param string
     */
    public function setAuthorChannelId($authorChannelId)
    {
        $this->authorChannelId = $authorChannelId;
    }
    /**
     * @return string
     */
    public function getAuthorChannelId()
    {
        return $this->authorChannelId;
    }
    /**
     * @param string
     */
    public function setDisplayMessage($displayMessage)
    {
        $this->displayMessage = $displayMessage;
    }
    /**
     * @return string
     */
    public function getDisplayMessage()
    {
        return $this->displayMessage;
    }
    /**
     * @param LiveChatFanFundingEventDetails
     */
    public function setFanFundingEventDetails(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\LiveChatFanFundingEventDetails $fanFundingEventDetails)
    {
        $this->fanFundingEventDetails = $fanFundingEventDetails;
    }
    /**
     * @return LiveChatFanFundingEventDetails
     */
    public function getFanFundingEventDetails()
    {
        return $this->fanFundingEventDetails;
    }
    /**
     * @param LiveChatGiftMembershipReceivedDetails
     */
    public function setGiftMembershipReceivedDetails(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\LiveChatGiftMembershipReceivedDetails $giftMembershipReceivedDetails)
    {
        $this->giftMembershipReceivedDetails = $giftMembershipReceivedDetails;
    }
    /**
     * @return LiveChatGiftMembershipReceivedDetails
     */
    public function getGiftMembershipReceivedDetails()
    {
        return $this->giftMembershipReceivedDetails;
    }
    /**
     * @param bool
     */
    public function setHasDisplayContent($hasDisplayContent)
    {
        $this->hasDisplayContent = $hasDisplayContent;
    }
    /**
     * @return bool
     */
    public function getHasDisplayContent()
    {
        return $this->hasDisplayContent;
    }
    /**
     * @param string
     */
    public function setLiveChatId($liveChatId)
    {
        $this->liveChatId = $liveChatId;
    }
    /**
     * @return string
     */
    public function getLiveChatId()
    {
        return $this->liveChatId;
    }
    /**
     * @param LiveChatMemberMilestoneChatDetails
     */
    public function setMemberMilestoneChatDetails(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\LiveChatMemberMilestoneChatDetails $memberMilestoneChatDetails)
    {
        $this->memberMilestoneChatDetails = $memberMilestoneChatDetails;
    }
    /**
     * @return LiveChatMemberMilestoneChatDetails
     */
    public function getMemberMilestoneChatDetails()
    {
        return $this->memberMilestoneChatDetails;
    }
    /**
     * @param LiveChatMembershipGiftingDetails
     */
    public function setMembershipGiftingDetails(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\LiveChatMembershipGiftingDetails $membershipGiftingDetails)
    {
        $this->membershipGiftingDetails = $membershipGiftingDetails;
    }
    /**
     * @return LiveChatMembershipGiftingDetails
     */
    public function getMembershipGiftingDetails()
    {
        return $this->membershipGiftingDetails;
    }
    /**
     * @param LiveChatMessageDeletedDetails
     */
    public function setMessageDeletedDetails(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\LiveChatMessageDeletedDetails $messageDeletedDetails)
    {
        $this->messageDeletedDetails = $messageDeletedDetails;
    }
    /**
     * @return LiveChatMessageDeletedDetails
     */
    public function getMessageDeletedDetails()
    {
        return $this->messageDeletedDetails;
    }
    /**
     * @param LiveChatMessageRetractedDetails
     */
    public function setMessageRetractedDetails(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\LiveChatMessageRetractedDetails $messageRetractedDetails)
    {
        $this->messageRetractedDetails = $messageRetractedDetails;
    }
    /**
     * @return LiveChatMessageRetractedDetails
     */
    public function getMessageRetractedDetails()
    {
        return $this->messageRetractedDetails;
    }
    /**
     * @param LiveChatNewSponsorDetails
     */
    public function setNewSponsorDetails(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\LiveChatNewSponsorDetails $newSponsorDetails)
    {
        $this->newSponsorDetails = $newSponsorDetails;
    }
    /**
     * @return LiveChatNewSponsorDetails
     */
    public function getNewSponsorDetails()
    {
        return $this->newSponsorDetails;
    }
    /**
     * @param string
     */
    public function setPublishedAt($publishedAt)
    {
        $this->publishedAt = $publishedAt;
    }
    /**
     * @return string
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }
    /**
     * @param LiveChatSuperChatDetails
     */
    public function setSuperChatDetails(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\LiveChatSuperChatDetails $superChatDetails)
    {
        $this->superChatDetails = $superChatDetails;
    }
    /**
     * @return LiveChatSuperChatDetails
     */
    public function getSuperChatDetails()
    {
        return $this->superChatDetails;
    }
    /**
     * @param LiveChatSuperStickerDetails
     */
    public function setSuperStickerDetails(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\LiveChatSuperStickerDetails $superStickerDetails)
    {
        $this->superStickerDetails = $superStickerDetails;
    }
    /**
     * @return LiveChatSuperStickerDetails
     */
    public function getSuperStickerDetails()
    {
        return $this->superStickerDetails;
    }
    /**
     * @param LiveChatTextMessageDetails
     */
    public function setTextMessageDetails(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\LiveChatTextMessageDetails $textMessageDetails)
    {
        $this->textMessageDetails = $textMessageDetails;
    }
    /**
     * @return LiveChatTextMessageDetails
     */
    public function getTextMessageDetails()
    {
        return $this->textMessageDetails;
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
    /**
     * @param LiveChatUserBannedMessageDetails
     */
    public function setUserBannedDetails(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\LiveChatUserBannedMessageDetails $userBannedDetails)
    {
        $this->userBannedDetails = $userBannedDetails;
    }
    /**
     * @return LiveChatUserBannedMessageDetails
     */
    public function getUserBannedDetails()
    {
        return $this->userBannedDetails;
    }
}
// Adding a class alias for backwards compatibility with the previous class name.
\class_alias(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\LiveChatMessageSnippet::class, 'ZOOlanders\\YOOessentials\\Vendor\\Google_Service_YouTube_LiveChatMessageSnippet');
