<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form\Actions\SaveCsv;

return [

    'routes' => [
        // ['get', SaveCsvActionController::DOWNLOAD_CSV_URL, SaveCsvActionController::class . '@download', ['allowed' => true]],
        ['post', SaveCsvActionController::GET_COLUMNS_ENDPOINT, SaveCsvActionController::class . '@getColumns'],
    ],

    'yooessentials-form-actions' => [
        SaveCsvAction::class => __DIR__ . '/config.json'
    ]

];
