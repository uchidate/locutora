<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\GoogleMyBusiness\Type;

use ZOOlanders\YOOessentials\Source\GraphQL\AbstractObjectType;
use ZOOlanders\YOOessentials\Source\GraphQL\HasSourceInterface;
use ZOOlanders\YOOessentials\Vendor\Google_Service_MyBusiness_Review;

class GoogleMyBusinessReview extends AbstractObjectType implements HasSourceInterface
{
    public const TYPE_NAME = 'GoogleMyBusinessReview';

    public function name(): string
    {
        return self::TYPE_NAME;
    }

    public function config(): array
    {
        return [
            'fields' => [
                'comment' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Comment',
                        'filters' => ['limit']
                    ]
                ],
                'original_comment' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Original Comment',
                        'filters' => ['limit']
                    ],
                    'extensions' => [
                        'call' => [
                            'func' => static::class . '::resolveOriginalComment'
                        ]
                    ]
                ],
                'translated_comment' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Translated Comment',
                        'filters' => ['limit']
                    ],
                    'extensions' => [
                        'call' => [
                            'func' => static::class . '::resolveTranslatedComment'
                        ]
                    ]
                ],
                'createTime' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Created on',
                        'filters' => ['date']
                    ]
                ],
                'updateTime' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Updated on',
                        'filters' => ['date']
                    ]
                ],
                'reviewReply' => [
                    'type' => GoogleMyBusinessReply::TYPE_NAME,
                    'metadata' => [
                        'label' => 'Reply'
                    ]
                ],
                'reviewer' => [
                    'type' => GoogleMyBusinessReviewer::TYPE_NAME,
                    'metadata' => [
                        'label' => 'Reviewer'
                    ]
                ],
                'starRating' => [
                    'type' => 'Int',
                    'metadata' => [
                        'label' => 'Rating'
                    ],
                    'extensions' => [
                        'call' => [
                            'func' => static::class . '::resolveStarRating'
                        ]
                    ]
                ],
                'name' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Resource Name',
                    ]
                ],
                'reviewId' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Resource ID',
                    ]
                ],
            ],
            'metadata' => [
                'type' => true,
                'label' => 'Review',
            ],
        ];
    }

    public static function resolveStarRating($review): ?int
    {
        if (!$review instanceof Google_Service_MyBusiness_Review) {
            $review = new Google_Service_MyBusiness_Review($review);
        }

        switch ($review->getStarRating()) {
            case 'ONE':
                return 1;
            case 'TWO':
                return 2;
            case 'THREE':
                return 3;
            case 'FOUR':
                return 4;
            case 'FIVE':
                return 5;
            case 'STAR_RATING_UNSPECIFIED':
            default:
                return null;
        }
    }

    public static function resolveOriginalComment($review): ?string
    {
        if (!$review instanceof Google_Service_MyBusiness_Review) {
            $review = new Google_Service_MyBusiness_Review($review);
        }

        $comment = self::parseComment($review->getComment());

        return $comment['original'];
    }

    public static function resolveTranslatedComment($review): ?string
    {
        if (!$review instanceof Google_Service_MyBusiness_Review) {
            $review = new Google_Service_MyBusiness_Review($review);
        }

        $comment = self::parseComment($review->getComment());

        return $comment['translated'];
    }

    public static function parseComment($comment): array
    {
        $result = ['original' => '', 'translated' => ''];

        if (preg_match('/^([\W\w\s]*)\(Original\)([\W\w\s]*)$/', $comment, $matches)) {
            $result['original'] = $matches[2];
            $result['translated'] = $matches[1];
        } elseif (preg_match('/^([\W\w\s]*)\(Translated by Google\)([\W\w\s]*)$/', $comment, $matches)) {
            $result['original'] = $matches[1];
            $result['translated'] = $matches[2];
        } else {
            $result['original'] = $result['translated'] = $comment;
        }

        array_walk($result, function (&$v) {
            $v = trim(str_replace(['(Translated by Google)', '(Original)'], '', $v));
        });

        return $result;
    }
}
