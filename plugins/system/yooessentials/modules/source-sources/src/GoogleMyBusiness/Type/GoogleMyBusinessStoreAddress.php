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

class GoogleMyBusinessStoreAddress extends AbstractObjectType implements HasSourceInterface
{
    public const TYPE_NAME = 'GoogleMyBusinessStoreAddress';

    public function name(): string
    {
        return self::TYPE_NAME;
    }

    public function config(): array
    {
        return [
            'fields' => [
                'revision' => [
                    'type' => 'Int',
                    'metadata' => [
                        'label' => 'Revision',
                    ]
                ],
                'regionCode' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Region Code',
                    ]
                ],
                'languageCode' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Language Code',
                    ]
                ],
                'postalCode' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Postal Code',
                    ]
                ],
                'sortingCode' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Sorting Code',
                    ]
                ],
                'administrativeArea' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Administrative Area',
                    ]
                ],
                'locality' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Locality',
                    ]
                ],
                'address' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Address',
                    ],
                    'extensions' => [
                        'call' => [
                            'func' => static::class . '::resolveAddress',
                            'args' => []
                        ]
                    ]
                ],
                'fullAddress' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Full Address',
                    ],
                    'extensions' => [
                        'call' => [
                            'func' => static::class . '::resolveFullAddress',
                            'args' => []
                        ]
                    ]
                ],
                'addressLines' => [
                    'type' => ['listOf' => 'String'],
                    'metadata' => [
                        'label' => 'Address Lines',
                    ]
                ],

                'recipients' => [
                    'type' => ['listOf' => 'String'],
                    'metadata' => [
                        'label' => 'Recipients',
                    ]
                ],
                'organization' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Organization',
                    ]
                ]
            ],
            'metadata' => [
                'type' => true,
                'label' => 'Address',
            ],
        ];
    }

    public static function resolveAddress(array $address): string
    {
        return implode(' ', $address['addressLines'] ?? []);
    }

    public static function resolveFullAddress(array $address): string
    {
        return implode(', ', [
            self::resolveAddress($address),
            $address['postalCode'],
            $address['locality'],
            $address['administrativeArea'],
        ]);
    }
}
