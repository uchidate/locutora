<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

use ZOOlanders\YOOessentials\Util\Prop;

$mailto = $node->props['mailto'] ?? '';
$options = array_filter(Prop::filterByPrefix($node->props, 'email_'));

$query = http_build_query(array_filter($options), '', '&', PHP_QUERY_RFC3986);

// support line breaks, replaces encoded '\n' with %0A
$query = str_replace('%5Cn', '%0A', $query);

$icon = $this->el('a', [

    'rel' => 'noreferrer',

    'href' => "mailto:$mailto?$query",

    'class' => array_merge([
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
