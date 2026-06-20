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
use ZOOlanders\YOOessentials\Util;

class GoogleMyBusinessReviewer extends AbstractObjectType implements HasSourceInterface
{
    public const TYPE_NAME = 'GoogleMyBusinessReviewer';

    public function name(): string
    {
        return self::TYPE_NAME;
    }

    public function config(): array
    {
        return [
            'fields' => [
                'profilePhotoUrl' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Profile Photo Url',
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::resolveProfileUrl',
                    ],
                ],
                'displayName' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Display Name',
                    ]
                ],
                'isAnonymous' => [
                    'type' => 'Boolean',
                    'metadata' => [
                        'label' => 'Anonymous',
                    ]
                ],
            ],
            'metadata' => [
                'type' => true,
                'label' => 'Reviewer',
            ],
        ];
    }

    public static function resolveProfileUrl($data): ?string
    {
        $url = $data['profilePhotoUrl'] ?? '';
        $cacheKey = 'google-bp-media-reviewer-photo-' . sha1($url);

        return Util\File::cacheMedia($url, $cacheKey);
    }
}
