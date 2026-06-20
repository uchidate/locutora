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

class GoogleMyBusinessMediaAttribution extends AbstractObjectType implements HasSourceInterface
{
    public const TYPE_NAME = 'GoogleMyBusinessMediaAttribution';

    public function name(): string
    {
        return self::TYPE_NAME;
    }

    public function config(): array
    {
        return [
            'fields' => [
                'profileName' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Profile Name'
                    ]
                ],

                'profilePhotoUrl' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Profile Photo Url'
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::resolveProfilePhotoUrl',
                    ],
                ],

                'takedownUrl' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Takedown url'
                    ]
                ],

                'profileUrl' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Profile Url'
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::resolveProfileUrl',
                    ],
                ],
            ],
            'metadata' => [
                'type' => true,
                'label' => 'Media Attribution',
            ],
        ];
    }

    public static function resolveProfilePhotoUrl($data): ?string
    {
        $url = $data['profilePhotoUrl'] ?? '';
        $cacheKey = 'google-bp-media-attribution-profile-photo-' . sha1($url);

        return Util\File::cacheMedia($url, $cacheKey);
    }

    public static function resolveProfileUrl($data): ?string
    {
        $url = $data['profileUrl'] ?? '';
        $cacheKey = 'google-bp-media-attribution-profile-' . sha1($url);

        return Util\File::cacheMedia($url, $cacheKey);
    }
}
