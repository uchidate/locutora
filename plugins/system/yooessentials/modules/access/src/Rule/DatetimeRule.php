<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Access\Rule;

class DatetimeRule extends TimeRule
{
    /**
     * @var String
     */
    protected $format = 'Y-m-d H:i';

    public function name(): string
    {
        return 'Datetime';
    }

    public function namespace(): string
    {
        return 'yooessentials_access_datetime';
    }

    public function description(): string
    {
        return 'Validates against the current date & time.';
    }

    public function fields(): array
    {
        return [
            'publish_up' => [
                'label' => 'From',
                'type' => 'yooessentials-datetime',
                'source' => true,
                'valueFormat' => 'yyyy-MM-dd HH:mm',
                'displayFormat' => 'yyyy-MM-dd HH:mm',
            ],
            'publish_down' => [
                'label' => 'Until',
                'type' => 'yooessentials-datetime',
                'description' => 'The start & end datetime in <code>Y-m-d H:i</code> format.',
                'source' => true,
                'valueFormat' => 'yyyy-MM-dd HH:mm',
                'displayFormat' => 'yyyy-MM-dd HH:mm',
            ]
        ];
    }

    public function resolveProps(object $props, object $node): object
    {
        $props->now = $this->now()->setTimezone($this->tz);
        $props->publish_up = $props->publish_up ?? null;
        $props->publish_down = $props->publish_down ?? null;

        if ($props->publish_up) {
            $props->publish_up = $this->createDate($props->publish_up);
        }

        if ($props->publish_down) {
            $props->publish_down = $this->createDate($props->publish_down);
        }

        if (!$props->publish_up && !$props->publish_down) {
            throw new \RuntimeException('Not Valid Evaluation Arguments');
        }

        return $props;
    }

    public function createDate($date): ?\DateTime
    {
        $date = \DateTime::createFromFormat($this->format, $date);

        if (!$date) {
            return null;
        }

        return $date->setTimezone($this->tz);
    }
}
