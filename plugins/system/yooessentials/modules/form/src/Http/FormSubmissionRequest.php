<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form\Http;

use function YOOtheme\app;
use YOOtheme\Event;
use YOOtheme\Http\Request;
use ZOOlanders\YOOessentials\Form\Form;
use ZOOlanders\YOOessentials\Form\FormService;
use ZOOlanders\YOOessentials\Form\FormValidator;
use ZOOlanders\YOOessentials\Session;

class FormSubmissionRequest
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var array
     */
    protected $meta = [];

    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var string
     */
    public const SUBMIT_URL = '/yooessentials/form';

    /**
     * @var string
     */
    public $csrfFormToken;

    /**
     * @var Form
     */
    protected $form;

    /**
     * @var FormValidator
     */
    protected $validator;

    /**
     * @var FormService
     */
    protected $formService;

    /**
     * @var string
     */
    public const SUBMISSION_EVENT = 'form.submission';

    /**
     * Constructor.
     */
    public function __construct(Request $request, Session $session, FormService $formService)
    {
        $this->request = $request;
        $this->formService = $formService;

        // get data from request
        if ($formId = $request->getParam('formid')) {
            $header = $request->getHeader('Referer');
            $config = $formService->loadConfig($formId);

            $this->form = new Form($formId, $config);
            $this->loadDataFromRequest();
            $this->meta = [
                'referer' => array_shift($header),
                'timestamp' => (new \DateTime())->format('Y-m-d H:i:s')
            ];

            // clean data
            unset($this->data['option'], $this->data['style'], $this->data['p']);

            return;
        }

        // or from session
        if ($submission = $session->get('yooessentials.submission')) {
            $this->meta = $submission['meta'];
            $this->data = $submission['data'];
            $this->form = new Form($this->data['formid']);

            $session->clear('yooessentials.submission');
        }
    }

    public function setForm(Form $form): self
    {
        $this->form = $form;

        return $this;
    }

    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function setMeta(array $meta): self
    {
        $this->meta = $meta;

        return $this;
    }

    public function process(FormSubmissionResponse $response): FormSubmissionResponse
    {
        if ($this->form() === null) {
            $response->withStatus(403, 'Direct form submissions are forbidden');

            return $response;
        }

        try {
            $this->formService->processElementSubmission($this, $response);

            $actions = $this->form()->actions();

            if (empty($actions) && $this->isAjax() && !$this->form()->hasExternalActionUrl()) {
                throw new \RuntimeException('No After Submit actions set.');
            }

            return Event::emit(FormSubmissionRequest::SUBMISSION_EVENT . '|middleware', function (FormSubmissionResponse $response) {
                return $response;
            }, $response);
        } catch (\Exception $e) {
            $errors = ['Submission failed, please try again or contact us about this issue.'];

            if (app()->config->get('app.isCustomizer') || app()->config->get('app.isAdmin')) {
                array_push($errors, $e->getMessage());
            }

            return $response->withErrors($errors);
        }
    }

    public function request(): Request
    {
        return $this->request;
    }

    public function parseTags(string $content): string
    {
        return FormService::parseTags($content, $this->data());
    }

    public function isAjax(): bool
    {
        return 'XMLHttpRequest' === ($this->request()->getHeader('X-Requested-With')[0] ?? null);
    }

    public function form(): ?Form
    {
        return $this->form;
    }

    public function config(): array
    {
        return $this->form() ? $this->form()->config() : [];
    }

    public function validator(): FormValidator
    {
        if (!$this->validator) {
            $this->validator = new FormValidator($this, $this->formService);
        }

        return $this->validator;
    }

    public function toArray(): array
    {
        return [
            'meta' => $this->meta,
            'data' => $this->data(),
            'errors' => $this->validator()->errors()
        ];
    }

    public function data($key = null)
    {
        if ($key) {
            return $this->data[$key] ?? null;
        }

        return $this->data;
    }

    protected function loadDataFromRequest(): void
    {
        // Fix php converting spaces and dots into underscores
        // @see https://www.php.net/manual/en/language.variables.external.php

        $this->data = $this->request->getParsedBody();

        $controlNames = array_filter(array_map(function ($control) {
            return $control['name'] ?? null;
        }, $this->form->controls()));

        foreach ($controlNames as $controlName) {
            $phpControlName = str_replace('.', '_', str_replace(' ', '_', $controlName));

            if ($phpControlName === $controlName) {
                continue;
            }

            if (!isset($this->data[$phpControlName])) {
                continue;
            }

            if (array_key_exists($phpControlName, $controlNames)) {
                continue;
            }

            $this->data[$controlName] = $this->data[$phpControlName];
            unset($this->data[$phpControlName]);
        }
    }
}
