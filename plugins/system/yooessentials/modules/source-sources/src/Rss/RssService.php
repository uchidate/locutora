<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Rss;

use SimpleXMLElement;
use YOOtheme\Http\Response;
use YOOtheme\HttpClientInterface;

class RssService
{
    /**
     * @var HttpClientInterface
     */
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function load(string $url, ?string $user = null, ?string $password = null): RssFeed
    {
        $xml = $this->loadXml($url, $user, $password);

        if ($xml->channel) {
            return $this->fromRss($xml);
        }

        return $this->fromAtom($xml);
    }

    public function loadRss(string $url, ?string $user = null, ?string $password = null): RssFeed
    {
        return $this->fromRss($this->loadXml($url, $user, $password));
    }

    public function loadAtom(string $url, ?string $user = null, ?string $password = null): RssFeed
    {
        return $this->fromAtom($this->loadXml($url, $user, $password));
    }

    private function fromRss(SimpleXMLElement $xml): RssFeed
    {
        if (!$xml->channel) {
            throw new \Exception('Invalid feed.');
        }

        self::adjustNamespaces($xml);

        $this->fixRssTimeStamp($xml->channel, false);

        foreach ($xml->channel->item as $item) {
            // converts namespaces to dotted tags
            self::adjustNamespaces($item);

            // generate 'url' & 'timestamp' tags
            $item->url = (string) $item->link;

            $this->fixRssTimeStamp($item);
        }

        return new RssFeed($xml->channel, $xml['version']);
    }

    private function fromAtom(SimpleXMLElement $xml): RssFeed
    {
        if (
            !in_array('http://www.w3.org/2005/Atom', $xml->getDocNamespaces(), true)
            && !in_array('http://purl.org/atom/ns#', $xml->getDocNamespaces(), true)
        ) {
            throw new \Exception('Invalid feed.');
        }

        // generate 'url' & 'timestamp' tags
        foreach ($xml->entry as $entry) {
            $entry->url = (string) $entry->link['href'];
            $entry->timestamp = strtotime($entry->updated);
        }

        return new RssFeed($xml, RssFeed::TYPE_ATOM);
    }

    private function loadXml(string $url, ?string $user = null, ?string $password = null): SimpleXMLElement
    {
        $options = [];
        if ($user || $password) {
            $options = [
                'headers' => [
                    'Authorization' => 'Basic ' . base64_encode($user . ':' . $password)
                ]
            ];
        }

        /** @var Response $response */
        $response = $this->client->get($url, $options);
        if ($response->getStatusCode() < 200 || $response->getStatusCode() > 299) {
            throw new \Exception('Cannot load Feed: ' . (string) $response->getBody());
        }

        return new SimpleXMLElement((string) $response->getBody(), LIBXML_NOWARNING | LIBXML_NOERROR | LIBXML_NOCDATA);
    }

    private static function adjustNamespaces(SimpleXMLElement $el): void
    {
        foreach ($el->getNamespaces(true) as $prefix => $ns) {
            if ($prefix === '') {
                continue;
            }
            $children = $el->children($ns);
            foreach ($children as $tag => $content) {
                $el->{$prefix . ':' . $tag} = $content;
            }
        }
    }

    private function fixRssTimeStamp(SimpleXMLElement $item, bool $forceTag = true): void
    {
        $attributes = [
            'dc:date' => 'timestamp',
            'pubDate' => 'timestamp',
            'lastBuildDate' => 'lastBuildDate'
        ];

        foreach ($attributes as $attribute => $tag) {
            $tag = $forceTag ? $tag : $attribute;
            if (isset($item->{$attribute})) {
                $item->{$tag} = strtotime($item->{$attribute});

                if ($tag !== $attribute) {
                    unset($item->{$attribute});
                }
            }
        }
    }
}
