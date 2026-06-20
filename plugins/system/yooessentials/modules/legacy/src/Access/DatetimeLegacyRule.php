<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Legacy\Access;

use YOOtheme\Config;
use ZOOlanders\YOOessentials\Access\AbstractRule;

class DatetimeLegacyRule extends AbstractRule
{
    /**
     * @var \DateTimeZone
     */
    protected $tz;

    public function __construct(Config $config)
    {
        $this->tz = new \DateTimeZone($config->get('yooessentials.timezone') ?? 'UTC');
    }

    public function name(): string
    {
        return 'Datetime Legacy (deprecated)';
    }

    public function group(): string
    {
        return 'legacy';
    }

    public function namespace(): string
    {
        return 'yooessentials_access_datetime_legacy';
    }

    public function description(): string
    {
        return 'This rule is deprecated.';
    }

    public function now(): \DateTimeImmutable
    {
        return new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
    }

    public function resolveProps(object $props, object $node): object
    {
        if (!($props->publish_up_date ?? false) && !($props->publish_up_time ?? false) && !($props->publish_down_date ?? false) && !($props->publish_down_time ?? false)) {
            throw new \RuntimeException('Not Valid Evaluation Arguments');
        }

        return $props;
    }

    public function resolve($props, $node): bool
    {
        $now = $this->now()->setTimezone($this->tz);
        $fromDate = trim($props->publish_up_date ?? '');
        $fromTime = trim($props->publish_up_time ?? '');
        $untilDate = trim($props->publish_down_date ?? '');
        $untilTime = trim($props->publish_down_time ?? '');

        try {
            $fromDate = $fromDate ? (new \DateTime($fromDate))->format('Y-m-d') : '';
            $fromTime = $fromTime ? (new \DateTime($fromTime))->format('H:i') : '';
            $untilDate = $untilDate ? (new \DateTime($untilDate))->format('Y-m-d') : '';
            $untilTime = $untilTime ? (new \DateTime($untilTime))->format('H:i') : '';

            $from = trim("$fromDate $fromTime");
            $until = trim("$untilDate $untilTime");

            $from = $from ? new \DateTime($from, $this->tz) : null;
            $until = $until ? new \DateTime($until, $this->tz) : null;
        } catch (\Exception $e) {
            return true;
        }

        if ($from and (int) $from->format('U') > (int) $now->format('U')) {
            return false;
        }

        if ($until and (int) $until->format('U') < (int) $now->format('U')) {
            return false;
        }

        return true;
    }

    public function fields(): array
    {
        return [
            '_tz' => [
                'description' => 'This rule is deprecated, it will be deleted in some future revision. Use the new Datetime rule instead.',
                'type' => 'yooessentials-info'
            ],
            '_from' => [
                'label' => 'From',
                'type' => 'fields',
                'divider' => true,
                'fields' => [
                    'publish_up_date' => [
                        'label' => 'Date',
                        'description' => 'The start date in <code>YYYY-MM-DD</code> format. If omited the current date is assumed.',
                        'source' => true,
                        'attrs' => [
                            'type' => 'date',
                            'placeholder' => 'YYYY-MM-DD'
                        ]
                    ],
                    'publish_up_time' => [
                        'label' => 'Time',
                        'description' => 'The start time in <code>H:i</code> format that will be added to the start date.',
                        'source' => true,
                        'attrs' => [
                            'type' => 'time'
                        ]
                    ],
                ]
            ],
            '_until' => [
                'label' => 'Until',
                'type' => 'fields',
                'divider' => true,
                'fields' => [
                    'publish_down_date' => [
                        'label' => 'Date',
                        'description' => 'The end date in <code>YYYY-MM-DD</code> format. If omited the current date is assumed.',
                        'source' => true,
                        'attrs' => [
                            'type' => 'date',
                            'placeholder' => 'YYYY-MM-DD'
                        ]
                    ],
                    'publish_down_time' => [
                        'label' => 'Time',
                        'description' => 'The end time in <code>H:i</code> format that will be added to the start date.',
                        'source' => true,
                        'attrs' => [
                            'type' => 'time'
                        ]
                    ],
                ]
            ],
        ];
    }
}
