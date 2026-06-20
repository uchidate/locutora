<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form\Actions\Email;

return [

    'routes' => [
        ['post', EmailActionController::TEST_EMAIL_URL, EmailActionController::class . '@sendTest']
    ],

    'yooessentials-form-actions' => [
        EmailAction::class => __DIR__ . '/config.json'
    ]

];
