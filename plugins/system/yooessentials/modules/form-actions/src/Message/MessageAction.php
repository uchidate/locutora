<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form\Actions\Message;

use ZOOlanders\YOOessentials\Form\Actions\StandardAction;
use ZOOlanders\YOOessentials\Form\Http\FormSubmissionResponse;

class MessageAction extends StandardAction
{
    public const NAME = 'message';

    public function __invoke(FormSubmissionResponse $response, callable $next): FormSubmissionResponse
    {
        return $next($response->withData([
            'message' => $this->config('content', '')
        ]));
    }
}
