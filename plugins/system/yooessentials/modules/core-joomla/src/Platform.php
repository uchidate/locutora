<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Joomla;

use Joomla\CMS\HTML\HTMLHelper;
use YOOtheme\Config;
use YOOtheme\Http\Uri;
use YOOtheme\Str;

class Platform
{
    /**
     * Handle application routes.
     *
     * @param Application $app
     */
    public static function handleRoute(Config $config, $path, $parameters, $secure, callable $next)
    {
        /** @var Uri $uri */
        $uri = $next($path, $parameters, $secure, $next);

        if (Str::startsWith($uri->getQueryParam('p'), '/yooessentials/')) {
            $query = $uri->getQueryParams();
            $query['option'] = 'com_ajax';
            $query['style'] = $config('theme.id');

            $uri = $uri->withQueryParams($query);
        }

        return $uri;
    }

    /**
     * Prints the HTML form token used for CSRF validation
     */
    public static function printCsrfFormToken()
    {
        return HTMLHelper::_('form.token');
    }
}
