<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

echo $this->el('input', [
    'type' => 'text',
    'name' => $node->control->name,
    'value' => '',
    'class' => ['uk-hidden']
]);

echo $this->el('input', [
    'type' => 'text',
    'name' => $node->control->name . '_time',
    'value' => $node->control->time,
    'class' => ['uk-hidden']
]);
