<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Access\Rule;

use YOOtheme\Arr;

class WeekRule extends DateRule
{
    public function name(): string
    {
        return 'Week';
    }

    public function namespace(): string
    {
        return 'yooessentials_access_week';
    }

    public function description(): string
    {
        return 'Validates against the current yearly week.';
    }

    public function resolveProps(object $props, object $node): object
    {
        if (!isset($props->weeks)) {
            throw new \RuntimeException('Not Valid Evaluation Arguments');
        }

        $props->weeks = static::parseWeeks($props->weeks);

        return $props;
    }

    public function resolve($props, $node): bool
    {
        $currentWeek = (int) $this->now()->format('W');

        return in_array($currentWeek, $props->weeks, true);
    }

    public function fields(): array
    {
        return [
            'weeks' => [
                'label' => 'List',
                'type' => 'textarea',
                'source' => true,
                'attrs' => [
                    'rows' => 4,
                    'placeholder' => "2\n4-8\n52"
                ],
                'description' => 'A list or range of weeks in a year that the current date must match, considering that in average a year has 52 weeks and the week starts in Monday. Separate the entries with a comma and/or new line.'
            ]
        ];
    }

    protected static function parseWeeks($weeks): array
    {
        if (is_string($weeks)) {
            $weeks = self::parseTextareaList($weeks);
        }

        // expand ranges
        foreach ($weeks as $i => $value) {
            if (str_contains($value, '-')) {
                $weeks[$i] = range(...explode('-', $value));
            }
        }

        // flatten and map to integer
        $weeks = array_map('intval', Arr::flatten($weeks));

        return $weeks;
    }
}
