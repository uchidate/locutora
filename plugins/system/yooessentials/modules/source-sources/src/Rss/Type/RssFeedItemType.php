<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Rss\Type;

use ZOOlanders\YOOessentials\Source\GraphQL\TypeInterface;
use ZOOlanders\YOOessentials\Source\SourceService;

class RssFeedItemType implements TypeInterface
{
    use ExtractsFields;

    /** @var string */
    protected $prefix = '';

    /** @var array */
    protected $data = [];

    public function __construct(array $items, string $prefix)
    {
        $return = [];
        array_walk($items, function ($a) use (&$return) {
            foreach ($a as $k => $v) {
                $return[$k] = $v;
            }
        });

        $this->data = $return;
        $this->prefix = $prefix;

        $this->getFields($this->data);
    }

    public function types(): array
    {
        return $this->types;
    }

    public function name(): string
    {
        return SourceService::encodeField($this->prefix . '_item');
    }

    public function type(): string
    {
        return TypeInterface::TYPE_OBJECT;
    }

    public function label(): string
    {
        return 'RSS Feed Item';
    }

    public function config(): array
    {
        $fields = $this->getFields($this->data);

        return [
            'fields' => $fields,
            'metadata' => [
                'type' => true,
                'label' => $this->label(),
            ],
        ];
    }
}
