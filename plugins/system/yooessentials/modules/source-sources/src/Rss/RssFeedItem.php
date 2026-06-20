<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Rss;

/** *
 * @see https://en.wikipedia.org/wiki/RSS
 */
class RssFeedItem
{
    /** @var \SimpleXMLElement */
    private $xml;

    /** @var string */
    private $type;

    public function __construct(\SimpleXMLElement $xml, string $type = RssFeed::TYPE_RSS_2_0)
    {
        $this->xml = $xml;
        $this->type = $type;
    }

    public function title(): string
    {
        return $this->xml->title;
    }

    public function description(): string
    {
        return $this->xml->description;
    }

    public function link(): string
    {
        return $this->xml->link;
    }

    public function category(): string
    {
        return $this->xml->category;
    }

    public function id(): string
    {
        if ($this->type === RssFeed::TYPE_ATOM) {
            return $this->xml->id;
        }

        return $this->xml->guid;
    }

    public function date(): \DateTime
    {
        return \DateTime::createFromFormat('U', $this->xml->pubdate);
    }

    public function source(): string
    {
        return $this->xml->source;
    }

    public function toArray(\SimpleXMLElement $xml = null)
    {
        if ($xml === null) {
            $xml = $this->xml;
        }

        if (!$xml->children()) {
            return (string) $xml;
        }

        $arr = [];
        foreach ($xml->children() as $tag => $child) {
            if (count($xml->$tag) === 1) {
                $arr[$tag] = $this->toArray($child);
            } else {
                $arr[$tag][] = $this->toArray($child);
            }
        }

        return $arr;
    }
}
