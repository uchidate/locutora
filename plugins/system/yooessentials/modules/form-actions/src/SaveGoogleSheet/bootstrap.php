<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form\Actions\SaveGoogleSheet;

use ZOOlanders\YOOessentials\UpdateTransform;

return [

    'routes' => [
        ['post', SaveGoogleSheetController::GET_SPREADSHEET_LIST_ENDPOINT, SaveGoogleSheetController::class . '@getSpreadsheetList'],
        ['post', SaveGoogleSheetController::GET_SPREADSHEET_SHEETS_ENDPOINT, SaveGoogleSheetController::class . '@getSpreadsheetSheets'],
        ['post', SaveGoogleSheetController::GET_SHEET_COLUMNS_ENDPOINT, SaveGoogleSheetController::class . '@getSheetColumns'],
    ],

    'yooessentials-form-actions' => [
        SaveGoogleSheetAction::class => __DIR__ . '/config.json'
    ],

    'extend' => [
        UpdateTransform::class => function (UpdateTransform $update) {
            $update->addGlobals(require __DIR__ . '/updates.php');
        }
    ],

];
