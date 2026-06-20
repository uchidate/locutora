<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

$el = $this->el('div');

if ($node->control->props['id_inherit'] ?? false) {
    $id = !empty($node->control->id) ? $node->control->id : $node->control->name;
}

$control = $this['form']->control(
    $node->control->name,
    $node->control->props['label'],
    $node->control->props['required'],
    $id
);

$textarea = $this['form']->textarea([
    'id' => $id,
    'name' => $node->control->name,
    'required' => (bool) $node->control->props['required'] ?? null,
    'readonly' => (bool) $node->control->props['readonly'] ?? null,
    'autofocus' => (bool) $node->control->props['autofocus'] ?? null,
    'pattern' => $node->control->props['pattern'] ?? null,
    'minlength' => $node->control->props['minlength'] ?? null,
    'maxlength' => $node->control->props['maxlength'] ?? null,
    'placeholder' => $node->control->props['placeholder'] ?? null,
    'rows' => $node->control->props['rows'] ?? null
], $node->control->value);

?>

<?= $el($props, $attrs) ?>

    <?= $control() ?>

        <?= $textarea($node->control->props, [
            'state' => $node->control->errors ? 'danger' : null
        ]) ?>

    <?= $control->end() ?>

<?= $el->end() ?>
