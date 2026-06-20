<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form\Actions;

use ZOOlanders\YOOessentials\Form\Http\FormSubmissionResponse;

interface Action
{
    public function name(): string;

    public function title(): string;

    public function panel(): array;

    public function setConfig(array $config): self;

    public function getConfig(): array;

    public function __invoke(FormSubmissionResponse $response, callable $next): FormSubmissionResponse;
}
