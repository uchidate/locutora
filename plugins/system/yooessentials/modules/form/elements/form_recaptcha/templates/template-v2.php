<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

use function YOOtheme\App;
use YOOtheme\Metadata;

/** @var Metadata $metadata */
$metadata = app(Metadata::class);

$id = 'reCAPTCHA' . str_replace(['#', '-'], '', $node->id);
$callback = 'yooessentialsRecaptcha2Callback';

$metadata->set('script:yooessentials-recaptcha-v2', ['src' => "https://www.google.com/recaptcha/api.js?onload={$callback}&render=explicit", 'async' => true, 'defer' => true]);

$sitekey = $node->control->siteKey;
$size = $node->control->props['size'];
$theme = $node->control->props['theme'];
$badge = $node->control->props['badge_position'];

$params = compact('id', 'callback', 'theme', 'size', 'sitekey', 'badge');

$el = $this->el('div');

$control = $this['form']->control(
    $node->control->name,
    $node->control->props['label'],
    true
);

$inline = $node->control->props['type'] === 'v2-checkbox' || $badge === 'inline';
$template = $node->control->props['type'] === 'v2-invisible' ? '_invisible' : '_checkbox';

?>

<?php if ($inline) : ?>
<?= $el($props, $attrs) ?>
    <?= $control() ?>
<?php endif; ?>

    <?= $this->render("{$__dir}/v2/{$template}", $params) ?>

<?php if ($inline) : ?>
    <?= $control->end() ?>
<?= $el->end() ?>
<?php endif; ?>


