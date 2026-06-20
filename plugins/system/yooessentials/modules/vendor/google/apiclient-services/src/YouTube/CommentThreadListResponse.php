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

class CommentThreadListResponse extends \ZOOlanders\YOOessentials\Vendor\Google\Collection
{
    protected $collection_key = 'items';
    /**
     * @var string
     */
    public $etag;
    /**
     * @var string
     */
    public $eventId;
    protected $itemsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\CommentThread::class;
    protected $itemsDataType = 'array';
    /**
     * @var string
     */
    public $kind;
    /**
     * @var string
     */
    public $nextPageToken;
    protected $pageInfoType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\PageInfo::class;
    protected $pageInfoDataType = '';
    protected $tokenPaginationType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\TokenPagination::class;
    protected $tokenPaginationDataType = '';
    /**
     * @var string
     */
    public $visitorId;
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
    public function setEventId($eventId)
    {
        $this->eventId = $eventId;
    }
    /**
     * @return string
     */
    public function getEventId()
    {
        return $this->eventId;
    }
    /**
     * @param CommentThread[]
     */
    public function setItems($items)
    {
        $this->items = $items;
    }
    /**
     * @return CommentThread[]
     */
    public function getItems()
    {
        return $this->items;
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
     * @param string
     */
    public function setNextPageToken($nextPageToken)
    {
        $this->nextPageToken = $nextPageToken;
    }
    /**
     * @return string
     */
    public function getNextPageToken()
    {
        return $this->nextPageToken;
    }
    /**
     * @param PageInfo
     */
    public function setPageInfo(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\PageInfo $pageInfo)
    {
        $this->pageInfo = $pageInfo;
    }
    /**
     * @return PageInfo
     */
    public function getPageInfo()
    {
        return $this->pageInfo;
    }
    /**
     * @param TokenPagination
     */
    public function setTokenPagination(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\TokenPagination $tokenPagination)
    {
        $this->tokenPagination = $tokenPagination;
    }
    /**
     * @return TokenPagination
     */
    public function getTokenPagination()
    {
        return $this->tokenPagination;
    }
    /**
     * @param string
     */
    public function setVisitorId($visitorId)
    {
        $this->visitorId = $visitorId;
    }
    /**
     * @return string
     */
    public function getVisitorId()
    {
        return $this->visitorId;
    }
}
// Adding a class alias for backwards compatibility with the previous class name.
\class_alias(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\CommentThreadListResponse::class, 'ZOOlanders\\YOOessentials\\Vendor\\Google_Service_YouTube_CommentThreadListResponse');
