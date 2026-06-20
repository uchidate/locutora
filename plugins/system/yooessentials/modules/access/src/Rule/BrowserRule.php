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
use ZOOlanders\YOOessentials\MobileDetect;

class BrowserRule extends OsRule
{
    private const DESKTOP = ['Chrome', 'Firefox', 'Opera', 'Safari', 'Edge', 'MSIE'];

    private const MOBILE = ['Android', 'iPad', 'iPhone', 'iPod', 'Blackberry', 'IEMobile', 'NetFront', 'NokiaBrowser', 'Opera Mini', 'Opera Mobi', 'UC Browser'];

    public function name(): string
    {
        return 'Browser';
    }

    public function namespace(): string
    {
        return 'yooessentials_access_browser';
    }

    public function description(): string
    {
        return 'Validates against the browser.';
    }

    public function resolve($props, $node): bool
    {
        if (!isset($props->browsers) or !$this->getAgent()) {
            throw new \RuntimeException('Not Valid Evaluation Arguments');
        }

        $selection = $props->browsers;

        if (is_string($selection)) {
            $selection = explode(',', str_replace([' ', "\r", "\n"], ['', '', ','], $selection));
        }

        return Arr::some($selection, function ($s) {
            return $this->_resolve($s);
        });
    }

    public function fields(): array
    {
        return [
            'browsers' => [
                'label' => 'List',
                'type' => 'textarea',
                'source' => true,
                'attrs' => [
                    'rows' => 4,
                    'placeholder' => "Chrome\nAndroid 4\nFirefox 60-70"
                ],
                'description' => 'A list of browsers that the agent must match, with optional version range. Separate the entries with a comma and/or new line. Keep in mind that browser detection is not always accurate, users can setup their browser to mimic other agents.'
            ],
            '_desktop' => [
                'label' => 'Supported Browsers',
                'type' => 'yooessentials-info',
                'content' => implode(', ', self::DESKTOP) . '.'
            ],
            '_mobile' => [
                'type' => 'yooessentials-info',
                'content' => implode(', ', self::MOBILE) . '.'
            ]
        ];
    }

    protected function getAgent(): ?object
    {
        static $agent = null;

        if (!$agent) {
            $detect = new MobileDetect;
            $ag = $detect->getUserAgent();

            if ($detect->isMobile()) {
                return $agent = $this->parseAgent($ag, self::MOBILE);
            }

            switch (true) {
                case (Str::contains($ag, 'Trident')):
                    // add MSIE to IE11
                    $ag = preg_replace('#(Trident\/[0-9\.]+; rv:([0-9\.]+))#is', '\1 MSIE/\2', $ag);
                    // fix format for other versions
                    // $ag = preg_replace('#MSIE ([0-9\.]+);#i', 'MSIE/\1', $ag);
                    break;

                case (Str::contains($ag, 'Chrome')):
                    // remove Safari from Chrome
                    $ag = preg_replace('#(Chrome/.*)Safari/[0-9\.]*#is', '\1', $ag);
                    // add MSIE to IE Edge and remove Chrome from IE Edge
                    $ag = preg_replace('#Chrome/.*(Edge/[0-9])#is', 'MSIE\1', $ag);

                    break;

                case (Str::contains($ag, 'Opera')):
                    $ag = preg_replace('#(Opera/.*)Version/#is', '\1Opera/', $ag);

                    break;
            }

            $agent = $this->parseAgent($ag, self::DESKTOP);
        }

        return $agent;
    }
}
