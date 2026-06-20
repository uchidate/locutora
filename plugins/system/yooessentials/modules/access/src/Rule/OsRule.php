<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Access\Rule;

use YOOtheme\Arr;
use YOOtheme\Str;
use ZOOlanders\YOOessentials\Access\AbstractRule;
use ZOOlanders\YOOessentials\MobileDetect;

class OsRule extends AbstractRule
{
    private const OS = ['Mac OS X', 'Mac OS Classic', 'Linux', 'Open BSD', 'Sun OS', 'QNX', 'BeOS', 'OS/2', 'Windows', 'Windows Vista', 'Windows Server 2003', 'Windows XP', 'Windows 2000 sp1', 'Windows 2000', 'Windows NT', 'Windows Me', 'Windows 98', 'Windows 95', 'Windows CE'];

    public function group(): string
    {
        return 'device';
    }

    public function name(): string
    {
        return 'Operating System';
    }

    public function namespace(): string
    {
        return 'yooessentials_access_os';
    }

    public function description(): string
    {
        return 'Validates against the Operating System.';
    }

    public function resolve($props, $node): bool
    {
        if (!isset($props->os) or !$this->getAgent()) {
            throw new \RuntimeException('Not Valid Evaluation Arguments');
        }

        $selection = $props->os;

        if (is_string($selection)) {
            $selection = explode(',', str_replace([' ', "\r", "\n"], ['', '', ','], $selection));
        }

        return Arr::some($selection, function ($s) {
            return $this->_resolve($s);
        });
    }

    protected function _resolve($s): bool
    {
        $agent = $this->getAgent();

        preg_match("#(\D*)([\d\.]+)?-?([\d\.]+)?#i", $s, $matches);
        @list($match, $name, $min, $max) = $matches;

        if (!preg_match("#^$name$#i", $agent->name, $match)) {
            return false;
        };

        if ($min && !Str::contains($min, '.')) {
            $min = "$min.0";
        }

        if ($max && !Str::contains($max, '.')) {
            $max = "$max.0";
        }

        if ($min && !$max and !version_compare($agent->version, $min, '==')) {
            return false;
        }

        if ($min && version_compare($agent->version, $min, '<') or $max && version_compare($agent->version, $max, '>')) {
            return false;
        }

        return true;
    }

    public function fields(): array
    {
        return [
            'os' => [
                'label' => 'List',
                'type' => 'textarea',
                'source' => true,
                'attrs' => [
                    'rows' => 4,
                    'placeholder' => "Linux\nWindows XP\nMac OS X 10.2-10.15"
                ],
                'description' => 'A list of Operative Systems that the agent must match, with optional version range. Separate the entries with a comma and/or new line. Keep in mind that operating system detection is not always accurate, users can setup their browser to mimic other agents.'
            ],
            '_supported' => [
                'label' => 'Supported OS',
                'type' => 'yooessentials-info',
                'content' => implode(', ', self::OS) . '.'
            ]
        ];
    }

    protected function getAgent(): ?object
    {
        static $agent = null;

        if (!$agent) {
            $detect = new MobileDetect;
            $ag = $detect->getUserAgent();

            // standardize names
            $ag = str_replace('_', '.', $ag);
            $ag = str_replace('Mac OS X ', 'Mac OS X/', $ag);
            $ag = str_replace('Mac_PowerPC', 'Mac OS Classic', $ag);
            $ag = str_replace('Macintosh', 'Mac OS Classic', $ag);

            $ag = str_replace('X11', 'Linux', $ag);
            $ag = str_replace('Open BSD', 'OpenBSD', $ag);
            $ag = str_replace('Sun OS', 'SunOS', $ag);

            $ag = str_replace('Windows nt 10.0', 'Windows 10', $ag);
            $ag = str_replace('Windows nt 6.2', 'Windows 8', $ag);
            $ag = str_replace('Windows nt 6.1', 'Windows 7', $ag);
            $ag = str_replace('Windows nt 6.0', 'Windows Vista', $ag);
            $ag = str_replace('Windows nt 5.2', 'Windows Server 2003', $ag);
            $ag = str_replace('Windows nt 5.1', 'Windows XP', $ag);
            $ag = str_replace('Windows nt 5.01', 'Windows 2000 sp1', $ag);
            $ag = str_replace('Windows nt 5.0', 'Windows 2000', $ag);
            $ag = str_replace('Windows nt 4.0', 'Windows NT', $ag);
            $ag = str_replace('Win 9x 4.9', 'Windows Me', $ag);
            $ag = str_replace('Windows 98', 'Windows 98', $ag);
            $ag = str_replace('Windows 95', 'Windows 95', $ag);
            $ag = str_replace('Windows ce', 'Windows CE', $ag);

            $agent = $this->parseAgent($ag, self::OS);
        }

        return $agent;
    }

    protected function parseAgent($agent, $names)
    {
        $names = implode('|', $names);

        if (preg_match("#($names)[\/ ](\d+\.\d+)#i", $agent, $match)) {
            return (object) ['name' => str_replace(' ', '', $match[1]), 'version' => $match[2]];
        }
    }
}
