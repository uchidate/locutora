<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Access\Rule;

class SeasonRule extends DateRule
{
    public function name(): string
    {
        return 'Season';
    }

    public function namespace(): string
    {
        return 'yooessentials_access_season';
    }

    public function description(): string
    {
        return 'Validates against the current meteorological season.';
    }

    public function fields(): array
    {
        return [
            'seasons' => [
                'label' => 'Selection',
                'type' => 'select',
                'source' => true,
                'description' => 'The seasons that the current date must match. Timezone from Site configuration is automatically applied. Use the shift or ctrl/cmd key to select multiple entries.',
                'attrs' => [
                    'multiple' => true
                ],
                'options' => [
                    'Winter' => 'winter',
                    'Spring' => 'spring',
                    'Summer' => 'summer',
                    'Autumn' => 'fall'
                ],
            ],
            'hemisphere' => [
                'label' => 'Hemisphere',
                'type' => 'select',
                'source' => true,
                'options' => [
                    'Northern' => '',
                    'Southern' => 'southern',
                    'Australia' => 'australia'
                ],
                'description' => 'The Hemisphere from which to calculate the current season.'
            ]
        ];
    }

    public function resolveProps(object $props, object $node): object
    {
        if (!isset($props->seasons)) {
            throw new \RuntimeException('Not Valid Evaluation Arguments');
        }

        if (empty($props->hemisphere)) {
            $props->hemisphere = 'northern';
        }

        return $props;
    }

    public function resolve($props, $node): bool
    {
        $now = $this->now();
        $season = self::getSeason($now, $props->hemisphere ?? false);

        return in_array($season, (array) $props->seasons);
    }

    /**
     * Code extracted from Regular Labs Library version 20.9.11663
     *
     * @author          Peter van Westen
     * @copyright       Copyright © 2020 Regular Labs All Rights Reserved
     * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
     */
    private static function getSeason(&$d, string $hemisphere)
    {
        // Set $date to today
        $date = strtotime($d->format('Y-m-d H:i:s'));

        // Get year of date specified
        $date_year = $d->format('Y'); // Four digit representation for the year

        // Specify the season names
        $season_names = ['winter', 'spring', 'summer', 'fall'];

        // Declare season date ranges
        switch (strtolower($hemisphere)) {
            case 'southern':
                if (
                    $date < strtotime($date_year . '-03-21')
                    || $date >= strtotime($date_year . '-12-21')
                ) {
                    return $season_names[2]; // Must be in Summer
                }

                if ($date >= strtotime($date_year . '-09-23')) {
                    return $season_names[1]; // Must be in Spring
                }

                if ($date >= strtotime($date_year . '-06-21')) {
                    return $season_names[0]; // Must be in Winter
                }

                if ($date >= strtotime($date_year . '-03-21')) {
                    return $season_names[3]; // Must be in Fall
                }

                break;
            case 'australia':
                if (
                    $date < strtotime($date_year . '-03-01')
                    || $date >= strtotime($date_year . '-12-01')
                ) {
                    return $season_names[2]; // Must be in Summer
                }

                if ($date >= strtotime($date_year . '-09-01')) {
                    return $season_names[1]; // Must be in Spring
                }

                if ($date >= strtotime($date_year . '-06-01')) {
                    return $season_names[0]; // Must be in Winter
                }

                if ($date >= strtotime($date_year . '-03-01')) {
                    return $season_names[3]; // Must be in Fall
                }

                break;
            default: // northern
                if (
                    $date < strtotime($date_year . '-03-21')
                    || $date >= strtotime($date_year . '-12-21')
                ) {
                    return $season_names[0]; // Must be in Winter
                }

                if ($date >= strtotime($date_year . '-09-23')) {
                    return $season_names[3]; // Must be in Fall
                }

                if ($date >= strtotime($date_year . '-06-21')) {
                    return $season_names[2]; // Must be in Summer
                }

                if ($date >= strtotime($date_year . '-03-21')) {
                    return $season_names[1]; // Must be in Spring
                }

                break;
        }

        return 0;
    }
}
