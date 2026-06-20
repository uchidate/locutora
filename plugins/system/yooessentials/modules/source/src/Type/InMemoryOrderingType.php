<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Source\Type;

use ZOOlanders\YOOessentials\Source\GraphQL\TypeInterface;

abstract class InMemoryOrderingType implements TypeInterface
{
    public const TYPE_LABEL = 'Csv Ordering';
    public const TYPE_NAME = 'CsvOrdering';

    abstract public function name(): string;

    abstract public function label(): string;

    public function type(): string
    {
        return TypeInterface::TYPE_INPUT;
    }

    public function config(): array
    {
        return [
            'fields' => [
                'name' => [
                    'type' => 'String',
                ],
                'status' => [
                    'type' => 'String',
                ],
                'field' => [
                    'type' => 'String',
                ],
                'direction' => [
                    'type' => 'String',
                ]
            ],

        ];
    }
}
