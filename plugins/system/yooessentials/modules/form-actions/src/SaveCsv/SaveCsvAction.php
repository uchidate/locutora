<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form\Actions\SaveCsv;

use ZOOlanders\YOOessentials\Form\Actions\SaveToAction;
use ZOOlanders\YOOessentials\Form\Http\FormSubmissionResponse;

class SaveCsvAction extends SaveToAction
{
    use InteractsWithCsv;

    public const NAME = 'save-csv';

    public function __invoke(FormSubmissionResponse $response, callable $next): FormSubmissionResponse
    {
        $config = (object) $this->getConfig();

        $data = self::resolveData($config->content ?? []);
        $headers = self::readCsvHeader($config);
        $data = self::sortDataFromHeaders($headers, $data);

        self::writeCsv($data, $config);

        return $next($response->withDataLog([
            self::NAME => [
                'config' => $config,
                'data' => $data
            ]
        ]));
    }
}
