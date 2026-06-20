<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form\Actions\SaveGoogleSheet;

use YOOtheme\Http\Request;
use YOOtheme\Http\Response;
use YOOtheme\Str;
use ZOOlanders\YOOessentials\DatabaseManager;

class SaveGoogleSheetController
{
    use HasApiRequest;

    public const GET_SPREADSHEET_LIST_ENDPOINT = 'yooessentials/form-action/save-gsheet/spreadsheets';
    public const GET_SPREADSHEET_SHEETS_ENDPOINT = 'yooessentials/form-action/save-gsheet/sheets';
    public const GET_SHEET_COLUMNS_ENDPOINT = 'yooessentials/form-action/save-gsheet/columns';

    public function getSpreadsheetList(Request $request, Response $response)
    {
        $form = $request->getParam('form');
        $query = $request->getParam('query') ?? null;
        $auth = $form['account'] ?? '';

        try {
            if (!$auth) {
                throw new \RuntimeException('Account must be specified.');
            }

            $options = [
                'q' => 'mimeType = "application/vnd.google-apps.spreadsheet"'
            ];

            if ($query) {
                $options['q'] .= " and name contains \"$query\"";
            }

            $result = self::api($auth)->listFiles($options);

            $items = array_reduce($result['files'], function ($carry, $sheet) {
                return array_merge($carry, [[
                    'text' => $sheet['name'],
                    'value' => $sheet['id'],
                    'meta' => $sheet['id']
                ]]);
            }, []);
        } catch (\Exception $e) {
            return $response->withJson($e->getMessage(), 400);
        }

        return $response->withJson($items, 200);
    }

    public function getSpreadsheetSheets(Request $request, Response $response)
    {
        $form = $request->getParam('form');
        $auth = $form['account'] ?? '';
        $spreadsheetId = $form['sheet_id'] ?? null;

        try {
            if (!$auth) {
                throw new \RuntimeException('Account must be specified.');
            }

            if (!$spreadsheetId) {
                throw new \Exception('Spreadsheet must be specified.');
            }

            $sheets = self::api($auth)->sheets($spreadsheetId);

            $items = array_reduce($sheets, function ($carry, $sheet) {
                return array_merge($carry, [[
                    'text' => $sheet->properties->title,
                    'value' => $sheet->properties->title
                ]]);
            }, []);
        } catch (\Exception $e) {
            return $response->withJson($e->getMessage(), 400);
        }

        return $response->withJson($items, 200);
    }

    public function getSheetColumns(Request $request, Response $response, DatabaseManager $database)
    {
        $form = $request->getParam('form') ?? [];
        $auth = $form['account'] ?? '';
        $sheetId = $form['sheet_id'] ?? '';
        $sheetName = $form['sheet_name'] ?? '';

        try {
            if (!$auth) {
                throw new \RuntimeException('Account must be specified.');
            }

            if (!$sheetId) {
                throw new \RuntimeException('Spreadsheet must be specified.');
            }

            if ($sheetName) {
                $result = self::api($auth)->headers($sheetId, "{$sheetName}!1:1");
            } else {
                $result = self::api($auth)->headers($sheetId, '1:1');
            }

            $columns = [];

            foreach ($result as $i => $col) {
                $columns[] = [
                    'id' => $col,
                    'title' => Str::titleCase($col)
                ];
            }
        } catch (\Exception $e) {
            return $response->withJson($e->getMessage(), 400);
        }

        return $response->withJson($columns, 200);
    }
}
