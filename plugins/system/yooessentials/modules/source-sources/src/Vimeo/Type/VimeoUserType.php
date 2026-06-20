<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Vimeo\Type;

use ZOOlanders\YOOessentials\Source\GraphQL\TypeInterface;

class VimeoUserType implements TypeInterface
{
    public const TYPE_NAME = 'VimeoUser';
    public const TYPE_LABEL = 'Vimeo User';

    public const FIELDS = ['name', 'bio', 'short_bio', 'gender', 'link', 'location', 'is_expert', 'verified', 'resource_key'];

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
                'bio' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Bio',
                        'filters' => ['limit'],
                    ],
                ],
                'short_bio' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Short Bio',
                        'filters' => ['limit'],
                    ],
                ],
                'gender' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Gender'
                    ],
                ],
                'link' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Link'
                    ],
                ],
                'location' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Location'
                    ],
                ],
                'is_expert' => [
                    'type' => 'Boolean',
                    'metadata' => [
                        'label' => 'Expert'
                    ],
                ],
                'verified' => [
                    'type' => 'Boolean',
                    'metadata' => [
                        'label' => 'Verified'
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
