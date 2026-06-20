<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Facebook\Type;

use ZOOlanders\YOOessentials\Source\GraphQL\TypeInterface;
use ZOOlanders\YOOessentials\Util;

// https://developers.facebook.com/docs/graph-api/reference/page
class FacebookPageType implements TypeInterface
{
    public const TYPE_NAME = 'FacebookPage';
    public const TYPE_LABEL = 'Facebook Page';

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
                'username' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Username',
                    ],
                ],
                'link' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Page URL',
                    ],
                ],
                'about' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'About',
                        'filters' => ['limit'],
                    ],
                ],
                'website' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Website URL',
                    ],
                ],
                'whatsapp_number' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'WhatsApp Number',
                    ],
                ],
                'category' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Category',
                    ],
                ],
                'description' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Description',
                        'filters' => ['limit'],
                    ],
                ],
                'description_html' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Description HTML',
                    ],
                ],
                'general_info' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'General Info',
                        'filters' => ['limit'],
                    ],
                ],
                'fan_count' => [
                    'type' => 'Int',
                    'metadata' => [
                        'label' => 'Total Likes',
                    ],
                ],
                'followers_count' => [
                    'type' => 'Int',
                    'metadata' => [
                        'label' => 'Total Followers',
                    ],
                ],

                // 'full_picture' => [
                //     'type' => 'String',
                //     'metadata' => [
                //         'label' => 'Picture Full Size URL',
                //     ],
                //     'extensions' => [
                //         'call' => __CLASS__ . '::fullPicture',
                //     ],
                // ],

                'id' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'ID',
                    ],
                ],

                'person' => [
                    'type' => FacebookPagePersonType::TYPE_NAME,
                    'metadata' => [
                        'label' => 'Person'
                    ],
                    'extensions' => [
                        'call' => FacebookPagePersonType::class . '::resolve',
                    ],
                ]

            ],

            'metadata' => [
                'type' => true,
                'label' => $this->label(),
            ],

        ];
    }

    public static function fullPicture($post)
    {
        $id = $post['id'] ?? '';
        $url = $post['full_picture'] ?? '';

        return Util\File::cacheMedia($url, "facebook-page-$id");
    }
}
