<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Access\Rule;

use YOOtheme\Config;
use ZOOlanders\YOOessentials\Access\AbstractRule;

class TimeRule extends AbstractRule
{
    /**
     * @var \DateTimeZone
     */
    protected $tz;

    /**
     * @var String
     */
    protected $format = 'H:i';

    public function __construct(Config $config)
    {
        $this->tz = new \DateTimeZone($config->get('yooessentials.timezone') ?? 'UTC');
    }

    public function group(): string
    {
        return 'datetime';
    }

    public function name(): string
    {
        return 'Time';
    }

    public function namespace(): string
    {
        return 'yooessentials_access_time';
    }

    public function description(): string
    {
        return 'Validates against the current time.';
    }

    public function fields(): array
    {
        return [
            'publish_up' => [
                'label' => 'From',
                'type' => 'yooessentials-time',
                'description' => 'The start time in <code>H:i</code> format.',
                'source' => true,
            ],
            'publish_down' => [
                'label' => 'Until',
                'type' => 'yooessentials-time',
                'description' => 'The end time in <code>H:i</code> format.',
                'source' => true,
            ]
        ];
    }

    public function now(): \DateTimeImmutable
    {
        return new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
    }

    public function resolveProps(object $props, object $node): object
    {
        $props->now = $this->now()->setTimezone($this->tz);
        $props->publish_up = $props->publish_up ?? null;
        $props->publish_down = $props->publish_down ?? null;

        if ($props->publish_up) {
            [$hour, $min] = explode(':', $props->publish_up);
            $props->publish_up = $this->now()->setTime($hour, $min)->setTimezone($this->tz);
        }

        if ($props->publish_down) {
            [$hour, $min] = explode(':', $props->publish_down);
            $props->publish_down = $this->now()->setTime($hour, $min)->setTimezone($this->tz);
        }

        if (!$props->publish_up && !$props->publish_down) {
            throw new \RuntimeException('Not Valid Evaluation Arguments');
        }

        return $props;
    }

    public function resolve($props, $node): bool
    {
        if ($props->publish_up and (int) $props->publish_up->format('U') > (int) $props->now->format('U')) {
            return false;
        }

        if ($props->publish_down and (int) $props->publish_down->format('U') < (int) $props->now->format('U')) {
            return false;
        }

        return true;
    }
}
