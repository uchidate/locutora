<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Rss\Type;

use ZOOlanders\YOOessentials\Source\GraphQL\TypeInterface;

class RssEnclosureType implements TypeInterface
{
    public const NAME = 'RSSEnclosure';

    public function type(): string
    {
        return TypeInterface::TYPE_OBJECT;
    }

    public function label(): string
    {
        return 'Media (Enclosure)';
    }

    public function name(): string
    {
        return self::NAME;
    }

    public function config(): array
    {
        return [
            'fields' => [
                'url' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Url',
                        'fields' => [],
                    ]
                ],
                'length' => [
                    'type' => 'Int',
                    'metadata' => [
                        'label' => 'Length',
                        'fields' => [],
                    ],
                ],
                'type' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Type',
                        'fields' => [],
                    ]
                ],
            ],
            'metadata' => [
                'type' => true,
                'label' => $this->label(),
            ],
        ];
    }

    public static function resolve(array $data, array $args = []): array
    {
        $link = $data[$args['header']] ?? [];

        $link['uri'] = urldecode($link['uri'] ?? $link['url'] ?? '');

        return $link;
    }
}
