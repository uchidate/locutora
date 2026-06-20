<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Rss\Type;

use ZOOlanders\YOOessentials\Source\GraphQL\TypeInterface;
use ZOOlanders\YOOessentials\Util;

class RssImageType implements TypeInterface
{
    public const NAME = 'RSSImage';

    public function type(): string
    {
        return TypeInterface::TYPE_OBJECT;
    }

    public function label(): string
    {
        return 'Image';
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
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::url',
                    ],
                ],
                'title' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Title',
                        'fields' => [],
                    ],
                ],
                'link' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Link',
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

    public static function url($tweet): string
    {
        $url = $tweet['url'] ?? '';
        $cacheKey = 'rss-' . sha1($url);

        return Util\File::cacheMedia($url, $cacheKey);
    }
}
