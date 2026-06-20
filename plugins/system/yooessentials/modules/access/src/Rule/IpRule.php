<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Access\Rule;

use YOOtheme\Arr;
use ZOOlanders\YOOessentials\Access\AbstractRule;
use ZOOlanders\YOOessentials\Util\Ip as IpUtil;

class IpRule extends AbstractRule
{
    public function group(): string
    {
        return 'device';
    }

    public function name(): string
    {
        return 'IP Address';
    }

    public function namespace(): string
    {
        return 'yooessentials_access_ip';
    }

    public function description(): string
    {
        return 'Validates agains the IP address.';
    }

    public function resolve($props, $node): bool
    {
        if (!isset($props->ips)) {
            throw new \RuntimeException('Not Valid Evaluation Arguments');
        }

        $selection = $props->ips;

        if (is_string($selection)) {
            $selection = explode(',', str_replace([' ', "\r", "\n"], ['', '', ','], $selection));
        }

        return Arr::some($selection, function ($range) {
            return IpUtil::checkIP($range);
        });
    }

    public function fields(): array
    {
        return [
            'ips' => [
                'label' => 'List',
                'type' => 'textarea',
                'source' => true,
                'attrs' => [
                    'rows' => 4,
                    'placeholder' => "127.0.0.1\n128.0-128.1\n129"
                ],
                'description' => 'A list of IP addresses and ranges that the device must match. Separate the entries with a comma and/or new line.'
            ]
        ];
    }
}
