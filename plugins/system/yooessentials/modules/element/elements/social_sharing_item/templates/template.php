<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

$icon = $this->el('a', [

    'rel' => 'noreferrer',

    'href' => $props['link'],

    'title' => $props['title'],

    'class' => array_merge([
        'el-link',
        'uk-icon-link {@!link_style}',
        'uk-icon-button {@link_style: button}',
        'uk-link-{link_style: muted|text|reset}',
    ], $attrs['class']),

    'uk-icon' => [
        !empty($props['icon'])
            ? "icon: {$this->e($props['icon'])};"
            : "icon: {$this->e($props['link'], 'social')};",
        'width: {icon_width}; height: {icon_width}; {@!link_style: button}',
    ]

]);

if ($props['link_target'] === 'popup') {
    $icon->attrs['data-yooessentials-social-popup'] = $node->popup;
} else {
    $icon->attrs['target'] = $props['link_target'];
}

?>

<?= $icon($element, $attrs, '') ?>
