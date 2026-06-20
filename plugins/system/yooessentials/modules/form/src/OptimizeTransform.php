<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form;

class OptimizeTransform
{
    private const FORM_DATA_KEY = 'yooessentials_form';

    /**
     * Transform callback.
     *
     * @param object $node
     * @param array  $params
     */
    public function __invoke($node, array $params)
    {
        $isFormArea = (bool) ($node->props[self::FORM_DATA_KEY]->state ?? false);
        $hasFormAreaData = (bool) ($node->props[self::FORM_DATA_KEY] ?? $node->formid ?? false);

        if (!$isFormArea && $hasFormAreaData) {
            unset($node->formid);
            unset($node->props[self::FORM_DATA_KEY]);
        }
    }
}
