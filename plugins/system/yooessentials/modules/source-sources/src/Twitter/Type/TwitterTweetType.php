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

class TwitterTweetType implements TypeInterface
{
    public const TYPE_NAME = 'TwitterTweet';
    public const TYPE_LABEL = 'Twitter Tweet';

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
                'text' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Text',
                        'filters' => ['limit'],
                    ],
                ],
                'text_html' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Text HTML',
                        'filters' => ['limit'],
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::html',
                    ],
                ],
                'permalink_url' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Permalink',
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::permalink',
                    ],
                ],
                'created_at' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Created At',
                        'filters' => ['date'],
                    ],
                ],
                'retweet_count' => [
                    'type' => 'Int',
                    'metadata' => [
                        'label' => 'Total Retweets',
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::retweet_count',
                    ],
                ],
                'reply_count' => [
                    'type' => 'Int',
                    'metadata' => [
                        'label' => 'Total Replies',
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::reply_count',
                    ],
                ],
                'like_count' => [
                    'type' => 'Int',
                    'metadata' => [
                        'label' => 'Total Likes',
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::like_count',
                    ],
                ],
                'quote_count' => [
                    'type' => 'Int',
                    'metadata' => [
                        'label' => 'Total Quotes',
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::quote_count',
                    ],
                ],
                'image_urls' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Images URLs',
                    ],
                ],
                'images' => [
                    'type' => ['listOf' => 'String'],
                    'metadata' => [
                        'label' => 'Tweet Images',
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::images',
                    ],
                ],
                'videos' => [
                    'type' => ['listOf' => 'String'],
                    'metadata' => [
                        'label' => 'Tweet Videos',
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::videos',
                    ],
                ],
                'urls' => [
                    'type' => ['listOf' => 'String'],
                    'metadata' => [
                        'label' => 'Urls',
                    ],
                ],
                'expanded_urls' => [
                    'type' => ['listOf' => 'String'],
                    'metadata' => [
                        'label' => 'Expanded Urls',
                    ],
                ],
                'lang' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Language',
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
                'author' => [
                    'type' => TwitterUserType::TYPE_NAME,
                    'metadata' => [
                        'label' => 'Author',
                    ],
                ],
                'in_reply_to_user' => [
                    'type' => TwitterUserType::TYPE_NAME,
                    'metadata' => [
                        'label' => 'In Reply To User',
                    ],
                ],
            ],

            'metadata' => [
                'type' => true,
                'label' => $this->label(),
            ],

        ];
    }

    public static function permalink($tweet): string
    {
        return "https://twitter.com/{$tweet['author']['username']}/status/{$tweet['id']}";
    }

    public static function html($tweet): int
    {
        return nl2br($tweet['text']);
    }

    public static function retweet_count($tweet): int
    {
        return $tweet['public_metrics']['retweet_count'] ?? 0;
    }

    public static function reply_count($tweet): int
    {
        return $tweet['public_metrics']['reply_count'] ?? 0;
    }

    public static function like_count($tweet): int
    {
        return $tweet['public_metrics']['like_count'] ?? 0;
    }

    public static function quote_count($tweet): int
    {
        return $tweet['public_metrics']['quote_count'] ?? 0;
    }

    public static function images($tweet): array
    {
        $photos = array_filter($tweet['medias'] ?? [], function ($media) {
            return $media['type'] === 'photo';
        });

        return array_map(function ($media) {
            $url = $media['url'] ?? '';
            $cacheKey = 'twitter-tweet-' . sha1($url);

            return Util\File::cacheMedia($url, $cacheKey);
        }, $photos);
    }

    public static function videos($tweet): array
    {
        $photos = array_filter($tweet['medias'] ?? [], function ($media) {
            return $media['type'] === 'video';
        });

        return array_map(function ($media) {
            return $media['url'];
        }, $photos);
    }
}
