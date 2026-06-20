<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Access\Rule;

class MonthRule extends DateRule
{
    public function name(): string
    {
        return 'Month';
    }

    public function namespace(): string
    {
        return 'yooessentials_access_month';
    }

    public function description(): string
    {
        return 'Validates against the current month.';
    }

    public function resolveProps(object $props, object $node): object
    {
        if (!isset($props->months)) {
            throw new \RuntimeException('Not Valid Evaluation Arguments');
        }

        return $props;
    }

    public function resolve($props, $node): bool
    {
        $currentMonth = $this->now()->format('m');

        return in_array($currentMonth, (array) $props->months);
    }

    public function fields(): array
    {
        return [
            'months' => [
                'label' => 'Selection',
                'type' => 'select',
                'source' => true,
                'description' => 'The months that the current date must match. Timezone from Site configuration is automatically applied. Use the shift or ctrl/cmd key to select multiple entries.',
                'attrs' => [
                    'multiple' => true,
                    'class' => 'uk-height-small uk-resize-vertical'
                ],
                'options' => [
                    'January' => '1',
                    'February' => '2',
                    'March' => '3',
                    'April' => '4',
                    'May' => '5',
                    'June' => '6',
                    'July' => '7',
                    'August' => '8',
                    'September' => '9',
                    'October' => '10',
                    'November' => '11',
                    'December' => '12',
                ],
            ]
        ];
    }
}
