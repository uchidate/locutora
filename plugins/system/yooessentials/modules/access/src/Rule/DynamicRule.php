<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Access\Rule;

use function YOOtheme\app;
use ZOOlanders\YOOessentials\Access\AbstractRule;

class DynamicRule extends AbstractRule
{
    public function group(): string
    {
        return '';
    }

    public function name(): string
    {
        return 'Dynamic';
    }

    public function namespace(): string
    {
        return 'yooessentials_access_dynamic';
    }

    public function description(): string
    {
        return 'Validates against static or dynamic values.';
    }

    public function resolve($props, $node): bool
    {
        if (!isset($props->value, $props->condition)) {
            throw new \RuntimeException('Not Valid Evaluation Arguments');
        }

        $props->condition_value = $props->condition_value ?? '';

        if ($props->condition === '!') {
            return self::isEmpty($props->value);
        }

        if ($props->condition === '~=') {
            return self::doesInclude($props->value, $props->condition_value);
        }

        if ($props->condition === '=') {
            return self::equals($props->value, $props->condition_value);
        }

        if ($props->condition === '>') {
            return self::greaterThan($props->value, $props->condition_value);
        }

        if ($props->condition === '^=') {
            return self::startsWith($props->value, $props->condition_value);
        }

        if ($props->condition === '$=') {
            return self::endsWith($props->value, $props->condition_value);
        }

        return false;
    }

    public function fields(): array
    {
        return [
            'value' => [
                'label' => 'Value',
                'source' => true,
                'description' => 'The value which to evaluate. Make sure to choose the source in the Advanced Tab in order to set it as Dynamic.'
            ],
            'condition' => [
                'label' => 'Condition',
                'type' => 'select',
                'default' => '!',
                'description' => 'The condition logic to evaluate the value with.',
                'options' => [
                    'Is empty' => '!',
                    'Includes' => '~=',
                    'Equals to' => '=',
                    'Greater than' => '>',
                    'Starts with' => '^=',
                    'Ends with' => '$=',
                ]
            ],
            'condition_value' => [
                'source' => true,
                'label' => 'Condition Value',
                'show' => '$match(condition, "=|>")',
                'description' => 'The value which to use as the condition.'
            ]
        ];
    }

    protected static function isEmpty($value): bool
    {
        return empty(is_string($value) ? trim($value): $value);
    }

    protected static function doesInclude($value, $val): bool
    {
        if (is_array($value)) {
            return self::includes($value, (array) $val);
        }

        if (is_array($val)) {
            return $val = $val[0];
        }

        return str_contains(self::toString($value), self::toString($val));
    }

    protected static function equals($value, $val): bool
    {
        $valueDate = self::createDate($value);
        $valDate = self::createDate($val);

        if ($valueDate || $valDate) {
            if ($valueDate && $valDate) {
                return (int) $valueDate->format('U') === (int) $valDate->format('U');
            }

            return false;
        }

        $value = (array) $value;
        $val = (array) $val;

        return count($value) === count($val) && self::includes($value, $val);
    }

    protected static function greaterThan($value, $val): bool
    {
        $valueDate = self::createDate($value);
        $valDate = self::createDate($val);

        if ($valueDate || $valDate) {
            if ($valueDate && $valDate) {
                return (int) $valueDate->format('U') > (int) $valDate->format('U');
            }

            return false;
        }

        $value = (array) $value;
        $val = (array) $val;

        return $value > $val;
    }

    protected static function startsWith($value, $val): bool
    {
        $value = (array) $value;
        $val = (array) $val;

        return str_starts_with($value[0] ?? '', $val[0] ?? '');
    }

    protected static function endsWith($value, $val): bool
    {
        $value = (array) $value;
        $val = (array) $val;

        return str_ends_with($value[0] ?? '', $val[0] ?? '');
    }

    protected static function includes(array $value, array $val): bool
    {
        return count(array_diff($val, $value)) === 0;
    }

    protected static function toString($val)
    {
        if (is_scalar($val) || is_callable([$val, '__toString'])) {
            return (string) $val;
        }

        return '';
    }

    protected static function createDate($date): ?\DateTime
    {
        if (!is_string($date)) {
            return null;
        }

        try {
            $tz = new \DateTimeZone(app()->config->get('yooessentials.timezone') ?? 'UTC');

            return (new \DateTime($date))->setTimezone($tz);
        } catch (\Exception $e) {
            return null;
        }
    }
}
