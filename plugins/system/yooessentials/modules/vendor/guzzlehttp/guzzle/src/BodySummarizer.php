<?php

namespace ZOOlanders\YOOessentials\Vendor\GuzzleHttp;

use ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\MessageInterface;
final class BodySummarizer implements \ZOOlanders\YOOessentials\Vendor\GuzzleHttp\BodySummarizerInterface
{
    /**
     * @var int|null
     */
    private $truncateAt;
    public function __construct(int $truncateAt = null)
    {
        $this->truncateAt = $truncateAt;
    }
    /**
     * Returns a summarized message body.
     */
    public function summarize(\ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\MessageInterface $message) : ?string
    {
        return $this->truncateAt === null ? \ZOOlanders\YOOessentials\Vendor\GuzzleHttp\Psr7\Message::bodySummary($message) : \ZOOlanders\YOOessentials\Vendor\GuzzleHttp\Psr7\Message::bodySummary($message, $this->truncateAt);
    }
}
