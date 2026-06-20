<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Access;

use YOOtheme\Url;

abstract class AbstractRule implements RuleInterface
{
    public function icon(): string
    {
        $icon = str_replace('yooessentials_access_', '', $this->namespace());

        return Url::to("~yooessentials_url/modules/access/assets/icons/$icon.svg");
    }

    public function docs(): string
    {
        return '';
    }

    public function resolveProps(object $props, object $node): object
    {
        return $props;
    }

    protected static function parseTextareaList($content): array
    {
        if (is_string($content)) {
            return array_map(function ($value) {
                return trim($value);
            }, explode(',', str_replace(["\r", "\n"], ['', ','], $content)));
        }

        return $content;
    }
}
