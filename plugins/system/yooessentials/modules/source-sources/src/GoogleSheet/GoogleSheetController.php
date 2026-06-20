<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\GoogleSheet;

use YOOtheme\Http\Request;
use YOOtheme\Http\Response;
use ZOOlanders\YOOessentials\Source\Resolver\LoadsSourceFromArgs;

class GoogleSheetController
{
    use LoadsSourceFromArgs;

    /**
     * @var string
     */
    public const PRESAVE_ENDPOINT = 'yooessentials/source/google-sheet';

    /**
     * @var string
     */
    public const GET_SHEETS_ENDPOINT = 'yooessentials/source/google-sheet/sheets';

    /**
     * @var string
     */
    public const GET_SPREADSHEETS_ENDPOINT = 'yooessentials/source/google-sheet/spreadsheets';

    public function presave(Request $request, Response $response)
    {
        $form = $request('form');
        $account = $form['account'] ?? null;
        $spreadsheetId = $form['sheet_id'] ?? null;

        if (!$account) {
            return $response->withJson('Account must be specified.', 400);
        }

        if (!$spreadsheetId) {
            return $response->withJson('Spreadsheet must be specified.', 400);
        }

        try {
            $source = self::loadSource($form, GoogleSheetSource::class);

            // check if spreadsheet id is valid
            $source->api()->spreadsheet($spreadsheetId);

            // check if sheet name is valid
            $sheetName = $form['sheet_name'] ?? null;

            if (!empty($sheetName && !in_array($sheetName, $source->sheets()))) {
                throw new \Exception('Invalid Spreadsheet Sheet Name.');
            }

            // check if headers are set
            $source->headers();
        } catch (\Exception $e) {
            return $response->withJson($e->getMessage(), 400);
        }

        return $response->withJson(200);
    }

    public function sheets(Request $request, Response $response)
    {
        $form = $request->getParam('form');
        $spreadsheetId = $form['sheet_id'] ?? null;

        try {
            if (!$spreadsheetId) {
                throw new \Exception('Spreadsheet ID must be specified.');
            }

            $source = self::loadSource($form, GoogleSheetSource::class);
            $sheets = $source->api()->sheets($spreadsheetId);

            $items = array_map(function ($sheet) {
                return [
                    'text' => $sheet->properties->title,
                    'value' => $sheet->properties->title
                ];
            }, $sheets);

            return $response->withJson($items, 200);
        } catch (\Exception $e) {
            return $response->withJson($e->getMessage(), 400);
        }
    }

    public function spreadsheets(Request $request, Response $response)
    {
        $form = $request->getParam('form');
        $search = $request->getParam('search') ?? null;

        $options = [
            'q' => 'mimeType = "application/vnd.google-apps.spreadsheet"'
        ];

        if ($search) {
            $options['q'] .= " and name contains \"$search\"";
        }

        try {
            $source = self::loadSource($form, GoogleSheetSource::class);
            $result = $source->api()->listFiles($options);

            $items = array_map(function ($spreadsheet) {
                return [
                    'text' => $spreadsheet['name'],
                    'value' => $spreadsheet['id'],
                    'meta' => $spreadsheet['id'],
                ];
            }, $result['files']);

            return $response->withJson($items, 200);
        } catch (\Exception $e) {
            return $response->withJson($e->getMessage(), 400);
        }
    }
}
