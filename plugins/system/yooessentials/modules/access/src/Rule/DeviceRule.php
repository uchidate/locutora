<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Access\Rule;

use ZOOlanders\YOOessentials\Access\AbstractRule;
use ZOOlanders\YOOessentials\MobileDetect;

class DeviceRule extends AbstractRule
{
    public function group(): string
    {
        return 'device';
    }

    public function name(): string
    {
        return 'Device';
    }

    public function namespace(): string
    {
        return 'yooessentials_access_device';
    }

    public function description(): string
    {
        return 'Validates against the device type.';
    }

    public function resolve($props, $node): bool
    {
        if (!isset($props->devices)) {
            throw new \RuntimeException('Not Valid Evaluation Arguments');
        }

        return in_array($this->getDevice(), $props->devices);
    }

    public function fields(): array
    {
        return [
            'devices' => [
                'type' => 'select',
                'source' => true,
                'attrs' => [
                    'multiple' => true
                ],
                'options' => [
                    'Mobile' => 'mobile',
                    'Tablet' => 'tablet',
                    'Desktop' => 'desktop'
                ],
                'description' => 'The list of devices that the agent must match. Use the shift or ctrl/cmd key to select multiple devices. Keep in mind that device detection is not always accurate, users can setup their browsers to mimic other agents.'
            ]
        ];
    }

    protected function getDevice(): string
    {
        static $device = null;

        if (!$device) {
            $detect = new MobileDetect;

            switch (true) {
                case($detect->isTablet()):
                    $device = 'tablet';

                    break;

                case ($detect->isMobile()):
                    $device = 'mobile';

                    break;

                default:
                    $device = 'desktop';
            }
        }

        return $device;
    }
}
