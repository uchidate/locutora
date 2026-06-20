<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form\Actions\Download;

return [

    'routes' => [
        ['get', DownloadActionController::DOWNLOAD_URL, DownloadActionController::class . '@download', ['allowed' => true]],
    ],

    'yooessentials-form-actions' => [
        DownloadAction::class => __DIR__ . '/config.json'
    ]

];
