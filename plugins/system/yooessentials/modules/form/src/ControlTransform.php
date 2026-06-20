<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form;

use YOOtheme\Str;

class ControlTransform
{
    /**
     * Transform callback.
     *
     * @param object $node
     * @param array  $params
     */
    public function __invoke($node, array $params)
    {
        if (!Str::startsWith($node->type, 'yooessentials_form_')) {
            return true;
        }

        /**
         * @var $type
         */
        extract($params);

        $type = $params['type'];

        if (is_array($type->controls ?? null)) {
            $node->controls = new \stdClass;

            foreach ($type->controls as $name => $control) {
                if (is_callable($control)) {
                    $control = $control($node, $params);

                    // make name safe
                    $control['name'] = trim($control['name']);

                    $node->controls->$name = $control;
                }
            }
        }
    }
}
