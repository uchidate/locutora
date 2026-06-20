<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form\Actions\SaveGoogleSheet;

use ZOOlanders\YOOessentials\Api\Google\Sheet\GoogleSheetApi;
use ZOOlanders\YOOessentials\Form\Actions\SaveToAction;
use ZOOlanders\YOOessentials\Form\Http\FormSubmissionResponse;

class SaveGoogleSheetAction extends SaveToAction
{
    use HasApiRequest;

    public const NAME = 'save-google-sheet';

    protected const DISABLED_VALUE = '';

    public function __invoke(FormSubmissionResponse $response, callable $next): FormSubmissionResponse
    {
        $config = (object) $this->getConfig();

        $data = self::resolveData($config->content ?? []);
        self::save($data, $config);

        return $next($response->withDataLog([
            self::NAME => [
                'config' => $config,
                'data' => $data
            ]
        ]));
    }

    private static function save(array $data, object $config): void
    {
        $inputOptions = [
            'INPUT_TYPE_RAW' => GoogleSheetApi::INPUT_TYPE_RAW,
            'INPUT_TYPE_USER_ENTERED' => GoogleSheetApi::INPUT_TYPE_USER_ENTERED
        ];

        $sheet = $config->sheet_name ?? '';
        $sheetId = $config->sheet_id;
        $valueInput = $config->value_input ?? 'INPUT_TYPE_RAW';

        $headers = self::readHeader($config, $data);
        $interval = self::interval($sheet, $headers);

        $data = self::sortDataFromHeaders($headers, $data);

        $params = [
            'valueInputOption' => $inputOptions[$valueInput]
        ];

        self::api($config->account)->append($sheetId, array_values($data), $interval, $params);
    }

    private static function readHeader(object $config): array
    {
        $sheet = $config->sheet_name ?? '';
        $sheetId = $config->sheet_id;

        $interval = '1:1';
        if ($sheet) {
            $interval = "{$sheet}!1:1";
        }

        return self::api($config->account)->headers($sheetId, $interval);
    }

    private static function interval(string $sheet, array $headers): string
    {
        $endIntervalColumn = 'A';

        for ($i = 1; $i < count($headers); $i++) {
            $endIntervalColumn = ++$endIntervalColumn;
        }

        return "{$sheet}!A1:{$endIntervalColumn}1";
    }
}
