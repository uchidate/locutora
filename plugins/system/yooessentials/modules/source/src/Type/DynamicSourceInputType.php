<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Source\Type;

use ZOOlanders\YOOessentials\Source\GraphQL\TypeInterface;

class DynamicSourceInputType implements TypeInterface
{
    public const TYPE_LABEL = 'Dynamic Source Props';
    public const TYPE_NAME = 'DynamicSourceProps';

    /** @var TypeInterface */
    protected $inputType;

    public function __construct(TypeInterface $inputType)
    {
        $this->inputType = $inputType;
    }

    public static function nameForInputType(string $inputTypeName): string
    {
        return self::TYPE_NAME . $inputTypeName;
    }

    public function type(): string
    {
        return TypeInterface::TYPE_INPUT;
    }

    public function name(): string
    {
        return static::nameForInputType($this->inputType->name());
    }

    public function label(): string
    {
        return self::TYPE_LABEL . ' - ' . $this->inputType->label();
    }

    public function config(): array
    {
        return [
            'fields' => [
                'props' => [
                    'type' => $this->inputType->name(),
                ],
                'source' => [
                    'type' => 'String',
                ]
            ],

        ];
    }
}
