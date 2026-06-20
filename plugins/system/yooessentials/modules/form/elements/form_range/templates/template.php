<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

$el = $this->el('div');

$id = !empty($node->control->id) ? $node->control->id : $node->control->name;

$control = $this['form']->control(
    $node->control->name,
    $node->control->props['label'],
    false,
    $id
);

$input = $this['form']->range([
    'id' => $id,
    'name' => $node->control->name,
    'value' => $node->control->value,
    'min' => $node->control->props['min'] ?? null,
    'max' => $node->control->props['max'] ?? null,
    'step' => $node->control->props['step'] ?? null,
    'autofocus' => (bool) $node->control->props['autofocus'] ?? null
]);

?>

<?= $el($props, $attrs) ?>

    <?= $control() ?>

        <?= $input($node->control->props) ?>

    <?= $control->end() ?>

<?= $el->end() ?>
