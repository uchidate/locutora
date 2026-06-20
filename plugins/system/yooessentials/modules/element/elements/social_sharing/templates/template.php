<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

$el = $this->el('div');

$grid = $this->el('div', [

    'class' => [
        'uk-child-width-auto',
        'uk-grid-{gap}',
        'uk-flex-{text_align}[@{text_align_breakpoint} [uk-flex-{text_align_fallback}]]',
    ],

    'uk-grid' => true,
]);

?>

<?= $el($props, $attrs) ?>
    <?= $grid($props) ?>

    <?php foreach ($children as $child) : ?>
    <div><?= $builder->render($child, ['element' => $props]) ?></div>
    <?php endforeach ?>

    <?= $grid->end() ?>

<?= $el->end() ?>
