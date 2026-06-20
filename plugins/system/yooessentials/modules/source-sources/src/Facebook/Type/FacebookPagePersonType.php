<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Facebook\Type;

use ZOOlanders\YOOessentials\Source\GraphQL\TypeInterface;

// https://developers.facebook.com/docs/graph-api/reference/page
class FacebookPagePersonType implements TypeInterface
{
    public const TYPE_NAME = 'FacebookPagePerson';
    public const TYPE_LABEL = 'Facebook Page Person';

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
                'birthday' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Birthday',
                        'filters' => ['date'],
                    ],
                ],
                'personal_info' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Personal Info',
                        'filters' => ['limit'],
                    ],
                ],
                'personal_interests' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Personal Interests',
                        'filters' => ['limit'],
                    ],
                ],
                'affiliation' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Affiliation',
                        'filters' => ['limit'],
                    ],
                ]
            ],

            'metadata' => [
                'type' => true,
                'label' => $this->label(),
            ],

        ];
    }

    public static function resolve($post): array
    {
        return $post;
    }
}
