<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form\Actions\Data;

use ZOOlanders\YOOessentials\Form\Actions\StandardAction;
use ZOOlanders\YOOessentials\Form\Http\FormSubmissionResponse;

class DataAddAction extends StandardAction
{
    public const NAME = 'data-add';

    public function __invoke(FormSubmissionResponse $response, callable $next): FormSubmissionResponse
    {
        $config = (object) $this->getConfig();

        $data = array_column($config->data, 'props');
        $formData = $response->submission()->data();

        foreach ($data as $d) {
            if (!isset($d['name'])) {
                continue;
            }

            $formData[$d['name']] = $d['value'] ?? null;
        }

        $response->submission()->setData($formData);

        return $next($response->withDataLog([
            self::NAME => [
                'config' => $config
            ]
        ]));
    }
}
