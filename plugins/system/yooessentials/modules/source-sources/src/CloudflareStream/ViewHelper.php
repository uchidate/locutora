<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\CloudflareStream;

use YOOtheme\Url;
use ZOOlanders\YOOessentials\Feature;

class ViewHelper extends \YOOtheme\Theme\ViewHelper
{
    const REGEX_CLOUDFLARE_IFRAME = '#iframe\.videodelivery\.net#i';

    public function register($view)
    {
        $view->addFunction('iframeVideo', [$this, 'iframeVideo']);

        if (Feature::canUse(Feature::VIEW_ADD_TRANSFORM)) {
            $view['html']->addTransform('iframe', function ($element, $params) {
                $src = $element->attrs['src'] ?? '';

                // add cloudflare stream iframe poster support to video element
                if ($src && preg_match(self::REGEX_CLOUDFLARE_IFRAME, $src)) {
                    $poster = $params['video_poster'] ?? null;

                    $element->attrs['src'] = Url::to($src, [
                        'poster' => $poster ? Url::to("~/$poster", [], true) : null,
                        'loop' => $params['video_loop'] ?? 0,
                        'muted' => $params['video_muted'] ?? 0,
                        'autoplay' => $params['video_autoplay'] ?? 0,
                        'controls' => $params['video_controls'] ?? 1,
                        'preload' => $params['video_lazyload'] ? 'none' : true,
                    ]);
                }
            });
        }
    }

    public function iframeVideo($link, $params = [], $defaults = true)
    {
        // add cloudflare stream iframe support
        if ($link && preg_match(self::REGEX_CLOUDFLARE_IFRAME, $link)) {
            return Url::to($link);
        }

        return parent::iframeVideo($link, $params, $defaults);
    }
}
