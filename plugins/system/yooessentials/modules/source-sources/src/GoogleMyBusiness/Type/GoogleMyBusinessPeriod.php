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

class GoogleMyBusinessPeriod extends AbstractObjectType implements HasSourceInterface
{
    public const TYPE_NAME = 'GoogleMyBusinessPeriod';

    public function name(): string
    {
        return self::TYPE_NAME;
    }

    public function config(): array
    {
        return [
            'metadata' => [
                'type' => true,
                'label' => 'Time Period',
            ],
            'fields' => [
                'openPeriod' => [
                    'type' => 'String',
                    'args' => [
                        'format' => [
                            'type' => 'String',
                        ],
                    ],
                    'metadata' => [
                        'label' => 'Open Period',
                        'arguments' => [
                            'format' => [
                                'label' => 'Format',
                                'description' => 'Select a predefined time format or enter a custom one.',
                                'type' => 'data-list',
                                'default' => '',
                                'options' => [
                                    '15:00 (G:i)' => 'G:i',
                                    '3:00 pm (g:i A)' => 'g:i a'
                                ],
                                'attrs' => [
                                    'placeholder' => 'Default'
                                ]
                            ],
                        ]
                    ],
                    'extensions' => [
                        'call' => [
                            'func' => static::class . '::resolveTimePeriod'
                        ]
                    ]
                ],
                'openDay' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Open Day',
                    ],
                    'extensions' => [
                        'call' => [
                            'func' => static::class . '::resolveDay',
                            'args' => [
                                'field' => 'openDay'
                            ]
                        ]
                    ]
                ],
                'closeDay' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Close Day',
                    ],
                    'extensions' => [
                        'call' => [
                            'func' => static::class . '::resolveDay',
                            'args' => [
                                'field' => 'closeDay'
                            ]
                        ]
                    ]
                ],
                'openTime' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Open Time',
                        'filters' => ['time'],
                    ],
                    'extensions' => [
                        'call' => [
                            'func' => static::class . '::resolveTime',
                            'args' => [
                                'field' => 'openTime'
                            ]
                        ]
                    ]
                ],
                'closeTime' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Close Time',
                        'filters' => ['time'],
                    ],
                    'extensions' => [
                        'call' => [
                            'func' => static::class . '::resolveTime',
                            'args' => [
                                'field' => 'closeTime'
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }

    public static function resolveTime($period, array $args = []): ?string
    {
        $field = $args['field'] ?? '';
        $time = $period->{$field};

        return ($time['hours'] ?? '00') . ':' . ($time['minutes'] ?? '00');
    }

    public static function resolveDay($period, array $args = []): ?string
    {
        $field = $args['field'] ?? '';
        $days = ['SUNDAY', 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY'];

        if (($day = array_search($period->{$field}, $days)) !== false) {
            $date = new \DateTime();
            $date->setISODate(2021, 1, $day);

            return $date->format('l');
        }

        return 'DAY_OF_WEEK_UNSPECIFIED';
    }

    public static function resolveTimePeriod($period, array $args = []): ?string
    {
        $open = self::resolveTime($period, ['field' => 'openTime']);
        $close = self::resolveTime($period, ['field' => 'closeTime']);

        if ($open === '00:00' && $close === '24:00') {
            return 'Open 24 Hours';
        }

        $format = empty($args['format']) ? 'g:i A' : $args['format'];

        return date($format, strtotime($open)) . ' - ' . date($format, strtotime($close));
        ;
    }
}
