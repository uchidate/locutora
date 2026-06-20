<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form;

use ZOOlanders\YOOessentials\Form\Http\FormSubmissionRequest;

class FormValidator
{
    /**
     * @var FormSubmissionRequest
     */
    protected $submission;

    /**
     * @var array|null
     */
    protected $errors;

    /**
     * @var FormService
     */
    protected $formService;

    /**
     * Constructor.
     */
    public function __construct(FormSubmissionRequest $submission, FormService $formService)
    {
        $this->submission = $submission;
        $this->formService = $formService;
    }

    public function validate(): bool
    {
        if (!$this->submission->form()) {
            return true;
        }

        if ($this->errors !== null) {
            return empty($this->errors);
        }

        $this->errors = $this->formService->validateElements($this->submission);

        return empty($this->errors);
    }

    public function errors($control = null): array
    {
        if ($control) {
            return $this->errors[$control] ?? [];
        }

        return $this->errors ?? [];
    }
}
