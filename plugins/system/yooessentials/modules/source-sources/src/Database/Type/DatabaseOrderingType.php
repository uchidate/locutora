<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Database\Type;

use ZOOlanders\YOOessentials\Source\GraphQL\TypeInterface;

class DatabaseOrderingType implements TypeInterface
{
    public const TYPE_LABEL = 'Database DatabaseOrdering';
    public const TYPE_NAME = 'DatabaseOrdering';

    public function type(): string
    {
        return TypeInterface::TYPE_INPUT;
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
                ],
                'status' => [
                    'type' => 'String',
                ],
                'table' => [
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
