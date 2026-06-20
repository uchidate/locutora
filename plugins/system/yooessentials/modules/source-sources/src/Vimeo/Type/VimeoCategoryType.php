<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Vimeo\Type;

use ZOOlanders\YOOessentials\Source\GraphQL\TypeInterface;

class VimeoCategoryType implements TypeInterface
{
    public const TYPE_NAME = 'VimeoCategory';
    public const TYPE_LABEL = 'Vimeo Category';

    public const FIELDS = ['name', 'link', 'top_level', 'parent', 'resource_key'];

    public function type(): string
    {
        return TypeInterface::TYPE_OBJECT;
    }

    public function name(): string
    {
        return self::TYPE_NAME;
    }

    public function label(): string
    {
        return self::TYPE_LABEL;
    }

    public function config(): array
    {
        return [

            'fields' => [
                'name' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Name'
                    ],
                ],
                'link' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Link'
                    ],
                ],
                'top_level' => [
                    'type' => 'Boolean',
                    'metadata' => [
                        'label' => 'Top Level'
                    ],
                ],
                'parent' => [
                    'type' => 'VimeoCategory',
                    'metadata' => [
                        'label' => 'Parent Category',
                    ],
                ],
                'subcategories' => [
                    'type' => [
                        'listOf' => 'VimeoCategory',
                    ],
                    'metadata' => [
                        'label' => 'Subcategories',
                    ],
                ],
                'resource_key' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'ID',
                    ],
                ],
            ],

            'metadata' => [
                'type' => true,
                'label' => $this->label(),
            ],

        ];
    }
}
