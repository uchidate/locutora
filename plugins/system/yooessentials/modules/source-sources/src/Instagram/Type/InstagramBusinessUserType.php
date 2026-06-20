<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Instagram\Type;

use ZOOlanders\YOOessentials\Source\GraphQL\TypeInterface;
use ZOOlanders\YOOessentials\Util;

class InstagramBusinessUserType implements TypeInterface
{
    public const TYPE_NAME = 'InstagramBusinessUser';
    public const TYPE_LABEL = 'Instagram Business User';

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
                        'label' => 'Name',
                    ],
                ],
                'website' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Website',
                    ],
                ],
                'biography' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Biography',
                    ],
                ],
                'profile_picture_url' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Picture URL',
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::profilePictureUrl',
                    ],
                ],
                'followers_count' => [
                    'type' => 'Int',
                    'metadata' => [
                        'label' => 'Followers Count',
                    ]
                ],
                'follows_count' => [
                    'type' => 'Int',
                    'metadata' => [
                        'label' => 'Follows Count',
                    ]
                ],
                'media_count' => [
                    'type' => 'Int',
                    'metadata' => [
                        'label' => 'Media Count',
                    ]
                ],
                'id' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'ID',
                    ],
                ]
            ],

            'metadata' => [
                'type' => true,
                'label' => $this->label(),
            ],

        ];
    }

    public static function profilePictureUrl($user)
    {
        $id = $user['id'] ?? '';
        $url = $user['profile_picture_url'] ?? '';

        if (!$url || !$id) {
            return '';
        }

        return Util\File::cacheMedia($url, "ig-media-user-$id");
    }
}
