<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

$text = $node->props['text'] ?? '';

$icon = $this->el('a', [

    'rel' => 'noreferrer',

    'href' => "viber://forward?text=$text",

    'title' => $node->title,

    'class' => array_merge([
        'uk-icon',
        'el-link',
        'uk-icon-link {@!link_style}',
        'uk-icon-button {@link_style: button}',
        'uk-link-{link_style: muted|text|reset}',
    ], $attrs['class']),

    'uk-icon' => [
        "icon: {$this->e($props['icon'])};",
        'width: {icon_width}; height: {icon_width}; {@!link_style: button}',
    ]

]);

?>

<?= $icon($element, $attrs, '') ?>
