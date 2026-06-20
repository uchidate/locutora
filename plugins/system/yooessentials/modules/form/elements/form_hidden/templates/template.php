<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

$input = $this->el('input', [
    'type' => 'hidden',
    'id' => $node->control->id,
    'name' => $node->control->name,
    'value' => $node->control->value
]);

?>

<?= $input($node->control->props) ?>
