<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Twitter\Type;

use ZOOlanders\YOOessentials\Source\GraphQL\TypeInterface;
use ZOOlanders\YOOessentials\Util;

class TwitterUserType implements TypeInterface
{
    public const TYPE_NAME = 'TwitterUser';
    public const TYPE_LABEL = 'Twitter User';

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

                'url' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'URL',
                    ],
                ],
                'name' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Name',
                        'filters' => ['limit'],
                    ],
                ],
                'username' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Username',
                        'filters' => ['limit'],
                    ],
                ],
                'description' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Description',
                        'filters' => ['limit'],
                    ],
                ],
                'profile_image_url' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Profile Image Url',
                    ],
                ],
                'profile_image' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Profile Image',
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::profileImage',
                    ],
                ],
                'created_at' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Created Time',
                        'filters' => ['date'],
                    ],
                ],
                'followers_count' => [
                    'type' => 'Int',
                    'metadata' => [
                        'label' => 'Total Followers',
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::followers_count',
                    ],
                ],
                'following_count' => [
                    'type' => 'Int',
                    'metadata' => [
                        'label' => 'Total Following',
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::following_count',
                    ],
                ],
                'tweet_count' => [
                    'type' => 'Int',
                    'metadata' => [
                        'label' => 'Total Tweets',
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::tweet_count',
                    ],
                ],
                'listed_count' => [
                    'type' => 'Int',
                    'metadata' => [
                        'label' => 'Total Listed',
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::listed_count',
                    ],
                ],
                'source' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Source',
                        'filters' => ['limit'],
                    ],
                ],
                'id' => [
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

    public static function followers_count($user): int
    {
        return $user['public_metrics']['followers_count'] ?? 0;
    }

    public static function following_count($user): int
    {
        return $user['public_metrics']['following_count'] ?? 0;
    }

    public static function tweet_count($user): int
    {
        return $user['public_metrics']['tweet_count'] ?? 0;
    }

    public static function listed_count($user): int
    {
        return $user['public_metrics']['listed_count'] ?? 0;
    }

    public static function profileImage($user)
    {
        $id = $user['id'] ?? '';
        $url = $user['profile_image_url'] ?? '';

        return Util\File::cacheMedia($url, "twitter-user-$id");
    }
}
