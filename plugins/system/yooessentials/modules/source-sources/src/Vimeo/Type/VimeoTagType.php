<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Vimeo\Type;

use YOOtheme\Arr;
use ZOOlanders\YOOessentials\Source\GraphQL\TypeInterface;

class VimeoTagType implements TypeInterface
{
    public const TYPE_NAME = 'VimeoTag';
    public const TYPE_LABEL = 'Vimeo Tag';

    public const FIELDS = ['name', 'link', 'resource_key', 'metadata.connections.videos.total'];

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
                'videos_count' => [
                    'type' => 'Int',
                    'metadata' => [
                        'label' => 'Total Videos',
                    ],
                    'extensions' => [
                        'call' => [
                            'func' => __CLASS__ . '::resolveProp',
                            'args' => [
                                'path' => 'metadata.connections.videos.total'
                            ]
                        ]
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

    public static function resolveProp(array $video, array $args)
    {
        return Arr::get($video, $args['path']);
    }
}
