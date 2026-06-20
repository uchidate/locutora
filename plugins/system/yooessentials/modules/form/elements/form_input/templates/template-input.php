<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

$props = array_merge($node->propsControl, array_filter($child->control->props));

$showLabel = $node->props['show_label'] ?? false;
$showIcon = $node->props['show_icon'] ?? false;

if ($element['fullwidth'] ?? false) {
    $props['width'] = '';
}

if ($child->control->props['id_inherit'] ?? false) {
    $id = !empty($child->control->id) ? $child->control->id : $child->control->name;
}

$control = $this['form']->control(
    $child->control->name,
    $showLabel ? ($props['label'] ?? null) : null,
    $props['required'] ?? null,
    $id
);

$icon = $this['form']->inputIcon();

$input = $this['form']->input([
    'id' => $id,
    'type' => str_replace('yooessentials_form_input_', '', $child->type),
    'name' => $child->control->name,
    'value' => $child->control->value,
    'required' => (bool) ($props['required'] ?? null),
    'readonly' => (bool) ($props['readonly'] ?? null),
    'autofocus' => (bool) ($props['autofocus'] ?? null),
    'pattern' => $props['pattern'] ?? null,
    'min' => $props['min'] ?? $props['mindate'] ?? null,
    'max' => $props['max'] ?? $props['maxdate'] ?? null,
    'minlength' => $props['minlength'] ?? null,
    'maxlength' => $props['maxlength'] ?? null,
    'placeholder' => $props['placeholder'] ?? null

])->render($props, [
    'state' => $child->control->errors ? 'danger' : null
]);
?>

<?= $control() ?>

    <?php if ($showIcon && $props['icon']) : ?>

        <div class="uk-inline uk-display-block">

            <?= $icon([
                'icon' => $props['icon'],
                'align' => $props['icon_align']
            ]) ?>

            <?= $input ?>

        </div>

    <?php else : ?>

        <?= $input ?>

    <?php endif ?>

<?= $control->end() ?>
