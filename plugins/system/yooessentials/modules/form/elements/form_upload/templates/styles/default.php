<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

$input = $this['form']->input([
    'type' => 'text',
    'disabled' => 'disabled',
    'placeholder' => $node->control->props['placeholder'] ?? null
]);

?>

<div uk-form-custom="target: true" class="uk-width-1-1">

    <?= $this->render("{$__dir}/_input", ['node' => $node, 'props' => $props]); ?>

    <?= $input([
        'width' => ($props['control_width'] ?? '') ?: 'medium',
        'size' => $props['control_size'] ?? '',
    ]) ?>

    <?= $this->render("{$__dir}/_button", ['node' => $node, 'props' => $props]); ?>
</div>
