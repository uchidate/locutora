<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

use function YOOtheme\app;
use YOOtheme\Builder\ElementTransform;

return [

    'transforms' => [

        'render' => function ($node) {

            /** @var ElementTransform $transform */
            $transform = app(ElementTransform::class);

            $text = $node->props['text'] ?? '';
            $value = $node->props['value'] ?? '';

            $node->props['value'] = $value;
            $node->props['text'] = empty($text) ? $value : $text;

            $transform->customAttributes($node);

            // Don't render element if content fields are empty
            return (bool) $node->props['text'];
        }

    ]

];
