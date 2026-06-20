<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

$button = $this->el('button', [

    'type' => 'reset',

    'class' => $this->expr([
        'el-content',
        'uk-width-1-1 {@fullwidth}',
        'uk-{button_style: link-\w+}' => ['button_style' => $props['button_style']],
        'uk-button uk-button-{!button_style: |link-\w+} [uk-button-{button_size}]' => ['button_style' => $props['button_style']],
    ], $element),

    'title' => ['{link_title}'],

]);

?>

<?= $button($props) ?>

<?php if ($props['icon']) : ?>

    <?php if ($props['icon_align'] == 'left') : ?>
    <span uk-icon="<?= $props['icon'] ?>"></span>
    <?php endif ?>

    <span class="uk-text-middle"><?= $props['content'] ?></span>

    <?php if ($props['icon_align'] == 'right') : ?>
    <span uk-icon="<?= $props['icon'] ?>"></span>
    <?php endif ?>

<?php else : ?>
<?= $props['content'] ?>
<?php endif ?>

<?= $button->end() ?>
