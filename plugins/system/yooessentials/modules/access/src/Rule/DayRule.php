<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Access\Rule;

class DayRule extends DateRule
{
    public function name(): string
    {
        return 'Day';
    }

    public function namespace(): string
    {
        return 'yooessentials_access_day';
    }

    public function description(): string
    {
        return 'Validates against the current day.';
    }

    public function resolveProps(object $props, object $node): object
    {
        if (!isset($props->days)) {
            throw new \RuntimeException('Not Valid Evaluation Arguments');
        }

        return $props;
    }

    public function resolve($props, $node): bool
    {
        $currentDay = $this->now()->format('N');

        return in_array($currentDay, (array) $props->days);
    }

    public function fields(): array
    {
        return [
            'days' => [
                'label' => 'Selection',
                'type' => 'select',
                'source' => true,
                'description' => 'The days that the current date must match. Timezone from Site configuration is automatically applied. Use the shift or ctrl/cmd key to select multiple entries.',
                'attrs' => [
                    'multiple' => true,
                    'class' => 'uk-height-small'
                ],
                'options' => [
                    'Monday' => '1',
                    'Tuesday' => '2',
                    'Wednesday' => '3',
                    'Thursday' => '4',
                    'Friday' => '5',
                    'Saturday' => '6',
                    'Sunday' => '7'
                ]
            ]
        ];
    }
}
