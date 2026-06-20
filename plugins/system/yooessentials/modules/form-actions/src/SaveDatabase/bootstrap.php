<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form\Actions\SaveDatabase;

return [

    'routes' => [
        ['post', SaveDatabaseController::GET_TABLE_LIST_ENDPOINT, SaveDatabaseController::class . '@getTableList'],
        ['post', SaveDatabaseController::GET_TABLE_COLUMNS_ENDPOINT, SaveDatabaseController::class . '@getTableColumns'],
        ['post', SaveDatabaseController::GET_TABLE_FIELDS_ENDPOINT, SaveDatabaseController::class . '@getTableFields'],
    ],

    'yooessentials-form-actions' => [
        SaveDatabaseAction::class => __DIR__ . '/config.json'
    ]

];
