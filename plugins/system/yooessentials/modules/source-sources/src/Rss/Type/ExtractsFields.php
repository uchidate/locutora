<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Rss\Type;

use YOOtheme\Str;
use ZOOlanders\YOOessentials\Source\SourceService;

trait ExtractsFields
{
    /** @var array */
    protected $types = [];
    protected $fields = null;

    public function types(): array
    {
        return $this->types;
    }

    private function getFields(array $data): array
    {
        if ($this->fields !== null) {
            return $this->fields;
        }

        $fields = [];

        foreach ($data as $header => $field) {
            $fields[SourceService::encodeField($header)] = $this->mapField($header, $field);
        }

        return $this->fields = $fields;
    }

    private function itemField(): array
    {
        return [
            'type' => [
                'listOf' => $this->itemType()->name(),
            ],
            'metadata' => [
                'label' => 'Rss Items',
                'fields' => []
            ]
        ];
    }

    private function arrayField(string $header, array $field): array
    {
        $type = new RssArrayType($header, $field, $this->name());
        $this->types[] = $type;

        return [
            'type' => $type->name(),
            'metadata' => [
                'label' => 'Rss Items',
                'fields' => []
            ]
        ];
    }

    private function imageField(string $header): array
    {
        return [
            'type' => RssImageType::NAME,
            'metadata' => [
                'label' => self::prepareLabel($header),
                'fields' => []
            ]
        ];
    }

    private function linkField(string $header): array
    {
        return [
            'type' => RssLinkType::NAME,
            'metadata' => [
                'label' => self::prepareLabel($header),
                'fields' => []
            ],
            'extensions' => [
                'call' => [
                    'func' => RssLinkType::class . '::resolve',
                    'args' => [
                        'header' => $header,
                    ]
                ]
            ],
        ];
    }

    private function authorField(string $header): array
    {
        return [
            'type' => RssAuthorType::NAME,
            'metadata' => [
                'label' => self::prepareLabel($header),
                'fields' => []
            ],
        ];
    }

    private function enclosureField(string $header): array
    {
        return [
            'type' => RssEnclosureType::NAME,
            'metadata' => [
                'label' => self::prepareLabel($header),
                'fields' => []
            ],
            'extensions' => [
                'call' => [
                    'func' => RssEnclosureType::class . '::resolve',
                    'args' => [
                        'header' => $header,
                    ]
                ]
            ],
        ];
    }

    private function mapField(string $header, $field): array
    {
        if ($field instanceof \DateTimeInterface) {
            return [
                'type' => 'String',
                'metadata' => [
                    'label' => self::prepareLabel($header),
                    'filters' => [
                        'date'
                    ]
                ],
                'extensions' => [
                    'call' => [
                        'func' => RssFeedType::class . '::resolveDateTime',
                        'args' => [
                            'header' => $header,
                        ]
                    ]
                ],
            ];
        }

        switch ($header) {
            case 'entry':
            case 'item':
                return $this->itemField();
            case 'enclosure':
                return $this->enclosureField($header);
            case 'image':
            case 'logo':
            case 'icon':
                return $this->imageField($header);
            case 'link':
                return $this->linkField($header);
            case 'ahtor':
                return $this->authorField($header);
        }

        if (is_array($field) && !empty($field)) {
            return $this->arrayField($header, $field);
        }

        return [
            'type' => 'String',
            'metadata' => [
                'label' => self::prepareLabel($header),
                'fields' => []
            ]
        ];
    }

    public static function prepareLabel(string $header): string
    {
        $header = str_replace(':', ' - ', $header);

        return Str::titleCase($header);
    }
}
