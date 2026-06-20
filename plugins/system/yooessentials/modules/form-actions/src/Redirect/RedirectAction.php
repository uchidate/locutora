<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form\Actions\Redirect;

use YOOtheme\Url;
use ZOOlanders\YOOessentials\Form\Actions\StandardAction;
use ZOOlanders\YOOessentials\Form\Http\FormSubmissionResponse;

class RedirectAction extends StandardAction
{
    public const NAME = 'redirect';

    public function __invoke(FormSubmissionResponse $response, callable $next): FormSubmissionResponse
    {
        return $next($response->withData([
            'redirect' => [
                'to' => Url::to($this->config('redirect', '')),
                'timeout' => (int) ($this->config('timeout', 0)),
                'blank' => $this->config('blank', false)
            ]
        ]));
    }
}
