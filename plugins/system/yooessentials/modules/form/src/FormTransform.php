<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form;

use YOOtheme\Builder;
use YOOtheme\Str;

class FormTransform
{
    /** @var FormService */
    protected $formService;

    /** @var Builder */
    protected $builder;

    public function __construct(FormService $formService, Builder $builder)
    {
        $this->formService = $formService;
        $this->builder = $builder;
    }

    /**
     * Transform callback.
     *
     * @param object $node
     * @param array  $params
     */
    public function __invoke($node, array $params)
    {
        if ($this->isFormNode($node)) {
            $this->createForm($node);
        }
    }

    protected function isFormNode($node): bool
    {
        return $this->formService->isFormNode($node);
    }

    protected function createForm($node): ?Form
    {
        $config = (array) $node->props['yooessentials_form'];
        $formNode = $this->wrap($node, $config);
        $config['controls'] = $this->getControls($formNode);

        $this->formService->saveConfig($formNode->id, $config);

        return new Form($formNode->id, $config);
    }

    protected function wrap($node, array $config)
    {
        // pass through the config so in the first rendering there is the basic config available
        $formNode = $this->formService->loadFormNode($node->formid, $config);

        $formNode->form->config = $config;
        $formNode->children = $node->children;

        $node->children = [$formNode];

        return $formNode;
    }

    protected function getControls($node): array
    {
        return array_reduce($node->children, function ($carry, $node) {
            if (!isset($this->builder->types[$node->type])) {
                return $carry;
            }

            if (Str::startsWith($node->type, 'yooessentials_form_') and $node->controls ?? false) {
                foreach ($node->controls as $control) {
                    $carry[] = array_merge(['type' => $node->type], $control);
                }
            }

            if ($node->children ?? false) {
                $carry = array_merge($carry, $this->getControls($node));
            }

            return $carry;
        }, []);
    }
}
