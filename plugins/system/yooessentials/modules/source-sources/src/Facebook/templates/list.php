<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

$showLink = $args['show_link'] ?? false;
$linkStyle = $args['link_style'] ?? '';

if ($showLink && $linkStyle) {
    echo '<span class="uk-' . $linkStyle . '">';
}

echo implode($args['separator'], array_map(function ($item) use ($showLink) {
    if (empty($showLink)) {
        return $item['name'];
    }

    $link = 'https://www.facebook.com/hashtag/' . str_replace('#', '', $item['name']);

    return "<a href=\"$link\">{$item['name']}</a>";
}, $items));

if ($showLink && $linkStyle) {
    echo '</span>';
}
