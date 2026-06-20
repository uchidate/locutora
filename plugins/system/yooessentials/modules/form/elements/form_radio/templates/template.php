<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

$el = $this->el('div');

if (count($children) > 1) {
    $control = $this['form']->controlFieldset(
        $node->control->name,
        $node->control->props['label'] ?? '',
        $node->control->props['required'] ?? false,
        $node->control->id
    );
} else {
    $control = $this['form']->control(
        $node->control->name,
        $node->control->props['label'] ?? '',
        $node->control->props['required'] ?? false,
        $node->control->id
    );
}

$options = array_map(function ($child) use ($node, $control) {
    $value = $child->props['value'];
    $id = $child->props['id'] ?? null;
    $text = $child->props['text'];
    $disabled = $child->props['disabled'];
    $checked = $value === $node->control->value;

    if (!$id && $node->control->id) {
        $id = "{$node->control->id}_{$value}";
    }

    if ($value === '') {
        $value = true;
    }

    $label = $this->el('label', [
        'class' => [
            '[uk-disabled uk-text-muted {@disabled}]'
        ]
    ]);

    $input = $this->el('input', [
        'id' => $id,
        'type' => 'radio',
        'name' => $node->control->name,
        'required' => $control->required,
        'class' => [
            'uk-radio'
        ]
    ]);

    $label->attr(compact('disabled'));
    $input->attr(compact('disabled', 'checked', 'value'));
    $input->attr($child->attrs);

    return (object) [
        'label' => $label,
        'text' => $text,
        'input' => $input
    ];
}, $children);

?>

<?= $el($props, $attrs) ?>

    <?= $control() ?>

    <?php if ($node->control->props['layout'] === 'horizontal') : ?>
    <div class="uk-margin uk-grid-small uk-child-width-auto" uk-grid>
    <?php endif; ?>

    <?php foreach ($options as $option) : ?>

        <?= $option->label->attr(['class' => 'uk-flex uk-margin-right']) ?>
            <div><?= $option->input ?></div>
            <div class="uk-margin-small-left"><?= html_entity_decode($option->text) ?></div>
        <?= $option->label->end() ?>

    <?php endforeach ?>

    <?php if ($node->control->props['layout'] === 'horizontal') : ?>
    </div>
    <?php endif; ?>

    <?= $control->end() ?>

<?= $el->end() ?>
