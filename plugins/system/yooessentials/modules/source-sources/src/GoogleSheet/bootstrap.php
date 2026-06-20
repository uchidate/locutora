<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\GoogleSheet;

return [

    'routes' => [

        ['post', GoogleSheetController::PRESAVE_ENDPOINT, GoogleSheetController::class . '@presave'],
        ['post', GoogleSheetController::GET_SHEETS_ENDPOINT, GoogleSheetController::class . '@sheets'],
        ['post', GoogleSheetController::GET_SPREADSHEETS_ENDPOINT, GoogleSheetController::class . '@spreadsheets'],

    ],

    'yooessentials-sources' => [

        'google_sheet' => GoogleSheetSource::class,

    ],

];
