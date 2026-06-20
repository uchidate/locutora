<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Rss\Type;

use ZOOlanders\YOOessentials\Source\GraphQL\TypeInterface;

class RssAuthorType implements TypeInterface
{
    public const NAME = 'RSSAuthor';

    public function type(): string
    {
        return TypeInterface::TYPE_OBJECT;
    }

    public function label(): string
    {
        return 'Author';
    }

    public function name(): string
    {
        return self::NAME;
    }

    public function config(): array
    {
        return [
            'fields' => [
                'name' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Name',
                        'fields' => [],
                    ]
                ],
                'email' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Email',
                        'fields' => [],
                    ],
                ],
                'uri' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Uri',
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
}
