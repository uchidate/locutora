<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Joomla;

use function YOOtheme\app;
use YOOtheme\Config;
use YOOtheme\Http\Request;
use YOOtheme\Http\Response;

class CsrfTokenMiddleware
{
    /**
     * Handles CSRF token from request.
     *
     * @param Request $request
     * @param callable $next
     *
     * @return Response
     */
    public function handle($request, callable $next)
    {
        $config = app(Config::class);
        $request = $request
            ->withHeader('X-XSRF-Token', $config('session.token'));

        return $next($request);
    }
}
