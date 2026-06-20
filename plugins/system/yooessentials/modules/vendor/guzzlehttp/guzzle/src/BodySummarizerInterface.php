<?php

namespace ZOOlanders\YOOessentials\Vendor\GuzzleHttp;

use ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\MessageInterface;
interface BodySummarizerInterface
{
    /**
     * Returns a summarized message body.
     */
    public function summarize(\ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\MessageInterface $message) : ?string;
}
