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
    $node->control->props['required'],
    $id
);

$select = $this['form']->select([
    'id' => $id,
    'name' => $node->control->props['multiple'] ? $node->control->name . '[]' : $node->control->name,
    'required' => (bool) $node->control->props['required'] ?? null,
    'multiple' => (bool) $node->control->props['multiple'] ?? null,
    'autofocus' => (bool) $node->control->props['autofocus'] ?? null,
    'size' => $node->control->props['height'] ?? null
]);

?>

<?= $el($props, $attrs) ?>

    <?= $control() ?>

        <?= $select($node->control->props, [
            'state' => $node->control->errors ? 'danger' : null
        ]) ?>

            <?php foreach ($children as $child) : ?>

                <?php
                    $text = strip_tags($child->props['text']);
                    $value = $child->props['value'];
                    $disabled = $child->props['disabled'];
                    $selected = in_array($value, $node->control->value);

                    if ($value === '') {
                        $value = true;
                    }

                    $option = $this->el('option', compact('disabled', 'selected', 'value'), $text);
                    $option->attr($child->attrs);
                ?>

                <?= $option() ?>

            <?php endforeach ?>

        <?= $select->end() ?>

    <?= $control->end() ?>

<?= $el->end() ?>
