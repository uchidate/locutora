<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Csv\Type;

use YOOtheme\Str;
use ZOOlanders\YOOessentials\Source\GraphQL\AbstractObjectType;
use ZOOlanders\YOOessentials\Source\GraphQL\HasSourceInterface;
use ZOOlanders\YOOessentials\Source\SourceService;

class CsvFileType extends AbstractObjectType implements HasSourceInterface
{
    public function name(): string
    {
        return 'fileCSV_' . sha1(json_encode(array_filter($this->source->csv()->getHeader())));
    }

    public function config(): array
    {
        $fields = [];

        foreach ($this->source->csv()->getHeader() as $header) {
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
    }
}
