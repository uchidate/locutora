<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\GoogleSheet\Type;

use ZOOlanders\YOOessentials\Source\GraphQL\AbstractQueryType;
use ZOOlanders\YOOessentials\Source\GraphQL\HasSourceInterface;
use ZOOlanders\YOOessentials\Source\Resolver\CachesResolvedData;
use ZOOlanders\YOOessentials\Source\Resolver\LoadsSourceFromArgs;
use ZOOlanders\YOOessentials\Source\SourceService;
use ZOOlanders\YOOessentials\Source\Type\SourceInterface;
use ZOOlanders\YOOessentials\Sources\GoogleSheet\GoogleSheetSource;

class SheetQuerySourceType extends AbstractQueryType implements HasSourceInterface
{
    use LoadsSourceFromArgs, CachesResolvedData;

    /**
     * @var GoogleSheetSource
     */
    protected $source;

    /**
     * @var SheetSourceType
     */
    private $sheetType;

    public function __construct(SourceInterface $source, SheetSourceType $sheetType)
    {
        parent::__construct($source);

        $this->sheetType = $sheetType;
    }

    public static function getCacheKey(): string
    {
        return 'google-sheet-query';
    }

    public function name(): string
    {
        $id = $this->source()->id();

        return "googleSheet_{$id}_query";
    }

    public function config(): array
    {
        return [

            'fields' => [

                $this->name() => [

                    'type' => ['listOf' => $this->sheetType->name()],

                    'args' => [

                        'offset' => [
                            'type' => 'Int',
                        ],
                        'limit' => [
                            'type' => 'Int',
                        ],
                        'cache' => [
                            'type' => 'Int'
                        ],

                    ],

                    'metadata' => [
                        'group' => 'Google Sheet',
                        'label' => $this->label(),
                        'fields' => [

                            '_offset_limit' => [
                                'type' => 'grid',
                                'width' => '1-2',
                                'description' => 'Set the starting point and limit the number of rows.',
                                'fields' => [
                                    'offset' => [
                                        'label' => 'Start',
                                        'type' => 'yooessentials-number',
                                        'modifier' => 1,
                                        'default' => GoogleSheetSource::SHEET_ROW_OFFSET,
                                        'attrs' => [
                                            'min' => 0,
                                            'placeholder' => GoogleSheetSource::SHEET_ROW_OFFSET
                                        ]
                                    ],
                                    'limit' => [
                                        'label' => 'Quantity',
                                        'type' => 'yooessentials-number',
                                        'default' => GoogleSheetSource::SHEET_ROW_LIMIT,
                                        'attrs' => [
                                            'min' => 1,
                                            'placeholder' => GoogleSheetSource::SHEET_ROW_LIMIT
                                        ]
                                    ],
                                ]
                            ],

                            'cache' => [
                                'type' => 'yooessentials-number',
                                'label' => 'Cache Time',
                                'description' => 'The duration in seconds before the cache is renewed. Set to <code>0</code> to disable caching.',
                                'attrs' => [
                                    'min' => 0,
                                    'max' => 86400 * 30,
                                    'step' => 3600,
                                    'placeholder' => static::DEFAULT_CACHE_TIME
                                ]
                            ],

                        ],
                    ],

                    'extensions' => [
                        'call' => [
                            'func' => __CLASS__.'::resolve',
                            'args' => [
                                'source_id' => $this->source->id(),
                            ]
                        ]
                    ],

                ],

            ],

        ];
    }

    public static function resolve($root, array $args)
    {
        $source = self::loadSource($args, GoogleSheetSource::class);

        if (!$source) {
            return [];
        }

        $result = self::resolveFromCache($source, $args, function () use ($source, $args) {
            $headers = $source->headers();
            $interval = self::getInterval($args, $source);
            $values = $source->api()->values($source->sheetId, $interval);

            if (!$values) {
                return [];
            }

            $data = [];
            foreach ($values as $row) {
                $rowData = [];
                foreach ($row as $k => $value) {
                    $header = $headers[$k] ?? null;

                    if ($header) {
                        $rowData[SourceService::encodeField($header)] = $value;
                    }
                }

                $data[] = $rowData;
            }

            return $data;
        });

        return $result;
    }

    protected static function getInterval(array $args, GoogleSheetSource $source): string
    {
        $offset = $args['offset'] ?? GoogleSheetSource::SHEET_ROW_OFFSET;
        $limit = $args['limit'] ?? GoogleSheetSource::SHEET_ROW_LIMIT;

        if ($offset < 0) {
            $offset = 0;
        }

        // force a limit
        if ($limit <= 0) {
            $limit = 1000;
        }

        // skip the header, and sheets starts from 1
        $offset += 2;
        $limit += ($offset - 1);

        return $source->interval($offset, $limit);
    }
}
