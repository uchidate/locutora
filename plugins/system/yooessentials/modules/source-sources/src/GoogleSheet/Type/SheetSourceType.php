<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\GoogleSheet\Type;

use YOOtheme\Str;
use ZOOlanders\YOOessentials\Source\GraphQL\AbstractObjectType;
use ZOOlanders\YOOessentials\Source\GraphQL\HasSourceInterface;
use ZOOlanders\YOOessentials\Source\SourceService;
use ZOOlanders\YOOessentials\Sources\GoogleSheet\GoogleSheetSource;

class SheetSourceType extends AbstractObjectType implements HasSourceInterface
{
    /**
     * @var GoogleSheetSource
     */
    protected $source;

    public function name(): string
    {
        return 'googleSheet_' . sha1(json_encode(array_filter($this->source->headers())));
    }

    public function label(): string
    {
        return 'Sheet';
    }

    public function config(): array
    {
        try {
            $headers = $this->source->headers();

            $fields = [];
            foreach ($headers as $header) {
                $fields[SourceService::encodeField($header)] = [
                    'type' => 'String',
                    'metadata' => [
                        'label' => Str::titleCase($header),
                        'fields' => []
                    ]
                ];
            }

            return [
                'fields' => $fields,
                'metadata' => [
                    'type' => true,
                    'label' => $this->label(),
                ],
            ];
        } catch (\Exception $e) {
            return [];
        }
    }
}
