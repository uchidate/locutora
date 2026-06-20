<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form;

use function YOOtheme\app;
use YOOtheme\Builder;
use YOOtheme\Path;
use YOOtheme\View;
use ZOOlanders\YOOessentials\Form\Controller\FormAdminController;
use ZOOlanders\YOOessentials\Form\Controller\FormController;
use ZOOlanders\YOOessentials\Form\Html\HtmlHelper;
use ZOOlanders\YOOessentials\Form\Http\FormSubmissionRequest;

return [

    'routes' => [
        ['post', FormSubmissionRequest::SUBMIT_URL, FormController::class . '@submit', ['allowed' => true]],
        ['post', FormAdminController::FIELDS_URL, FormAdminController::class . '@fields', ['allowed' => true]]
    ],

    'events' => [

        'source.init' => [
            FormListener::class => ['initSource', 66]
        ],

        'customizer.init' => [
            FormListener::class => ['initCustomizer', 10]
        ],

        'builder.type' => [
            FormListener::class => ['addFormPanel', -10]
        ]

    ],

    'extend' => [

        Builder::class => function (Builder $builder, $app) {
            $builder->addTypePath(Path::get('./elements/*/element.json'));

            $formIdTransform = $app(FormIdTransform::class);

            $builder->addTransform('presave', [$formIdTransform, 'presave']);
            $builder->addTransform('preload', [$formIdTransform, 'preload']);
            $builder->addTransform('render', new ControlTransform);
        },

        View::class => function (View $view) {
            $formHtmlHelper = app(HtmlHelper::class);
            $view['form'] = $formHtmlHelper;
        },

    ],

    'services' => [
        FormSubmissionRequest::class => '',
        FormService::class => '',
    ],

    'yooessentials-bootstrap' => [
        __DIR__ . '/../form-actions/bootstrap.php',
    ],

];
