<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Rss;

use ZOOlanders\YOOessentials\Source\Type\DynamicSourceInputType;
use ZOOlanders\YOOessentials\Sources\Rss\Type\RssAuthorType;
use ZOOlanders\YOOessentials\Sources\Rss\Type\RssFilterType;
use ZOOlanders\YOOessentials\Sources\Rss\Type\RssOrderingType;
use function YOOtheme\app;
use YOOtheme\Event;
use ZOOlanders\YOOessentials\Source\Type\AbstractSourceType;
use ZOOlanders\YOOessentials\Source\Type\SourceInterface;
use ZOOlanders\YOOessentials\Sources\Rss\Type\RssEnclosureType;
use ZOOlanders\YOOessentials\Sources\Rss\Type\RssImageType;
use ZOOlanders\YOOessentials\Sources\Rss\Type\RssLinkType;

class RssSource extends AbstractSourceType implements SourceInterface
{
    /** @var RssFeed */
    private $rss;

    public function types(): array
    {
        try {
            $this->rss();
        } catch (\Exception $e) {
            Event::emit('yooessentials.error', [
                'addon' => 'source',
                'provider' => 'rss',
                'error' => $e->getMessage()
            ]);

            return [];
        }

        $objectType = new Type\RssFeedType($this);
        $itemType = $objectType->itemType();
        $queryType = new Type\RssFeedQueryType($this, $objectType);
        $itemsQueryType = new Type\RssFeedItemsQueryType($this, $objectType);
        $filterType = new RssFilterType();
        $orderingType = new RssOrderingType();

        return array_merge(
            [
                $filterType,
                $orderingType,
                new DynamicSourceInputType($filterType),
                new DynamicSourceInputType($orderingType),
                new RssAuthorType(),
                new RssImageType(),
                new RssLinkType(),
                new RssEnclosureType(),
            ],
            $objectType->types(),
            $itemType->types(),
            [
                $objectType,
                $itemType,
                $queryType,
                $itemsQueryType,
            ]
        );
    }

    public function rss(): RssFeed
    {
        if ($this->rss) {
            return $this->rss;
        }

        $url = $this->config('url');

        /** @var RssFeed $rssFeed */
        $rss = app(RssService::class)->load($url);

        return $this->rss = $rss;
    }
}
