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

class CommentThreadReplies extends \ZOOlanders\YOOessentials\Vendor\Google\Collection
{
    protected $collection_key = 'comments';
    protected $commentsType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\Comment::class;
    protected $commentsDataType = 'array';
    /**
     * @param Comment[]
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }
    /**
     * @return Comment[]
     */
    public function getComments()
    {
        return $this->comments;
    }
}
// Adding a class alias for backwards compatibility with the previous class name.
\class_alias(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\CommentThreadReplies::class, 'ZOOlanders\\YOOessentials\\Vendor\\Google_Service_YouTube_CommentThreadReplies');
