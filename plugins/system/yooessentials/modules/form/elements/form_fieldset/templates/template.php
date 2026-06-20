<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

$el = $this->el('fieldset', [
    'class' => [
        'uk-fieldset',
        'uk-form-{layout}'
    ]
]);

?>

<?= $el($props, $attrs) ?>

    <?php if ($props['caption']) : ?>
    <legend class="uk-legend"><?= $props['caption'] ?></legend>
    <?php endif ?>

    <?php foreach ($children as $child) : ?>
        <?= $builder->render($child, ['element' => $props]) ?>
    <?php endforeach ?>

<?= $el->end() ?>
