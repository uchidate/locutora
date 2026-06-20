<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

$width = $node->chart->config['width'] ?? null;
$height = $node->chart->config['height'] ?? null;

$style = $this->expr([
    $width ? "width: {$width};" : '',
    $height ? "height: {$height};" : ''
]);

$el = $this->el('div', [
    'data-yooessentials-chart' => json_encode($node->chart->config, JSON_HEX_APOS),
    'data-labels' => json_encode($node->chart->labels, JSON_HEX_APOS),
    'data-sets' => json_encode($node->chart->datasets, JSON_HEX_APOS),
    'style' => $style
]);

?>

<?= $el($props, $attrs) ?>
    <canvas style="<?= $style ?>"></canvas>
<?= $el->end() ?>
