<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form;

use function YOOtheme\App;
use YOOtheme\Metadata;
use YOOtheme\Url;
use ZOOlanders\YOOessentials\Form\Http\FormSubmissionRequest;

return [

    'transforms' => [

        'render' => function ($node) {

            /** @var FormSubmissionRequest $submission */
            $submission = app(FormSubmissionRequest::class);

            /** @var Metadata $submission */
            $metadata = app(Metadata::class);

            /** @var FormService $formService */
            $formService = app(FormService::class);

            $form = $formService->loadForm($node->id);
            $config = $form->config();

            // Empty config means that cache is empty and this is first rendering
            if (empty($config)) {
                $config = (array) $node->yooessentials_form ?? [];
                $formService->saveConfig($node->id, $config);
            }

            $hasExternalActionUrl = $form->hasExternalActionUrl();
            $submitUrl = Url::route(FormSubmissionRequest::SUBMIT_URL);

            $node->form = new \stdClass();
            $node->form->validateAction = '';
            $node->form->action = $submitUrl;
            $node->form->method = 'POST';
            $node->form->csrf = $submission->csrfFormToken;
            $node->form->domId = $config['id'] ?? null;
            $node->form->domClass = $config['class'] ?? null;
            $node->form->domName = $config['name'] ?? null;
            $node->form->html5validation = $config['html5validation'] ?? null;

            if ($hasExternalActionUrl) {
                $node->form->validateAction = $submitUrl;
                $node->form->action = $config['action_url'] ?? '';
                $node->form->method = $config['action_method'] ?? 'POST';
            }

            $metadata->set('script:yooessentials-form', ['src' => '~yooessentials_url/modules/form/assets/form.min.js', 'defer' => true]);
        }

    ],

];
