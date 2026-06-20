<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form\Actions;

use ZOOlanders\YOOessentials\Form\Http\FormSubmissionRequest;
use ZOOlanders\YOOessentials\UpdateTransform;

require_once __DIR__ . '/class_aliases.php';

return [

    'routes' => [
        ['get', ActionController::ACTIONS_URL, ActionController::class . '@actions', ['allowed' => true]],
    ],

    'events' => [

        FormSubmissionRequest::SUBMISSION_EVENT => [
            ActionListener::class => ['handleFormActions', -10]
        ],

        'customizer.init' => [
            ActionListener::class => ['initCustomizer', 5]
        ],

    ],

    'loaders' => [
        'yooessentials-form-actions' => new ActionLoader(),
    ],

    'services' => [
        ActionManager::class => '',
    ],

    'extend' => [
        UpdateTransform::class => function (UpdateTransform $update) {
            $update->addGlobals(require __DIR__ . '/updates.php');
        }
    ],

    'yooessentials-bootstrap' => [
        __DIR__ . '/src/Download/bootstrap.php',
        __DIR__ . '/src/Email/bootstrap.php',
        __DIR__ . '/src/Message/bootstrap.php',
        __DIR__ . '/src/Redirect/bootstrap.php',
        __DIR__ . '/src/SaveCsv/bootstrap.php',
        __DIR__ . '/src/SaveGoogleSheet/bootstrap.php',
        __DIR__ . '/src/SaveDatabase/bootstrap.php',
        __DIR__ . '/src/Data/bootstrap.php',
    ],

];
