<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

$mimetypes = $node->control->props['mimetypes'] ?? '';
$mimetypes = explode(',', str_replace(' ', '', $mimetypes));

$extensions = $node->control->props['extensions'] ?? '';
$extensions = explode(',', str_replace([' ', '.'], '', $extensions));
$extensions = preg_filter('/^/', '.', $extensions); // prepend dot

$accept = array_filter(array_merge($mimetypes, $extensions));

$input = $this->el('input', [
    'type' => 'file',
    'id' => $node->control->id,
    'name' => $node->control->props['multiple'] ? $node->control->name . '[]' : $node->control->name,
    'value' => $node->control->value,
    'accept' => count($accept) ? implode(',', $accept) : null,
    'multiple' => (bool) $node->control->props['multiple'] ?? null
]);

?>

<?= $input($node->control->props);
