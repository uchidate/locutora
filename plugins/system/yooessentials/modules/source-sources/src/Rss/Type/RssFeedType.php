<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Rss\Type;

use ZOOlanders\YOOessentials\Source\GraphQL\AbstractObjectType;
use ZOOlanders\YOOessentials\Source\GraphQL\HasSourceInterface;
use ZOOlanders\YOOessentials\Source\SourceService;
use ZOOlanders\YOOessentials\Source\Type\SourceInterface;
use ZOOlanders\YOOessentials\Sources\Rss\RssSource;

class RssFeedType extends AbstractObjectType implements HasSourceInterface
{
    use ExtractsFields;

    /** @var RssFeedItemType|null */
    private $itemType = null;

    /** @var RssSource */
    protected $source;

    public function __construct(SourceInterface $source)
    {
        parent::__construct($source);

        $this->getFields($this->source->rss()->toArray());
    }

    public function itemType(): RssFeedItemType
    {
        if ($this->itemType !== null) {
            return $this->itemType;
        }

        $this->itemType = new RssFeedItemType($this->source->rss()->items(), $this->name());

        return $this->itemType;
    }

    public function name(): string
    {
        return SourceService::encodeField('RSSfeed_' . $this->source->id());
    }

    public function config(): array
    {
        $data = $this->source->rss()->toArray();

        $fields = $this->getFields($data);

        return [
            'fields' => $fields,
            'metadata' => [
                'type' => true,
                'label' => $this->label(),
            ],
        ];
    }

    public static function resolveDateTime($data, $args)
    {
        $date = $data[$args['header']] ?? null;

        return $date ? $date->format('U') : null;
    }
}
