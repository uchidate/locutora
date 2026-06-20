<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Access\Rule;

class DateRule extends DatetimeRule
{
    /**
     * @var String
     */
    protected $format = 'Y-m-d';

    public function name(): string
    {
        return 'Date';
    }

    public function namespace(): string
    {
        return 'yooessentials_access_date';
    }

    public function description(): string
    {
        return 'Validates against the current date.';
    }

    public function fields(): array
    {
        return [
            'publish_up' => [
                'label' => 'From',
                'type' => 'yooessentials-date',
                'description' => 'The start date in <code>Y-m-d</code> format.',
                'source' => true,
            ],
            'publish_down' => [
                'label' => 'Until',
                'type' => 'yooessentials-date',
                'description' => 'The end date in <code>Y-m-d</code> format.',
                'source' => true,
            ]
        ];
    }
}
