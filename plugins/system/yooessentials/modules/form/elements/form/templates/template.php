<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

$form = $this->el('form', [

    'id' => $node->form->domId,

    'name' => $node->form->domName,

    'action' => $node->form->action,

    'method' => $node->form->method,

    'validate-action' => $node->form->validateAction,

    'data-uk-yooessentials-form' => true,

    'novalidate' => $node->form->html5validation === false,

    'class' => [
        'uk-form',
        $node->form->domClass
    ],

]);

$errors = $this->el('div', [
    'class' => [
        'uk-text-danger',
        'uk-text-small'
    ],
    'data-yooessentials-form-errors' => true
], '');

?>

<?= $form($props, array_filter($attrs)) ?>
    <?= $builder->render($children) ?>
    <input type="hidden" name="formid" value="<?= $node->id ?>"/>
    <?= $node->form->csrf; ?>
    <?= $errors(); ?>
<?= $form->end() ?>
