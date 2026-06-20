<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

$template = $node->control->props['type'] === 'v3' ? 'v3' : 'v2'

?>

<?= $this->render("{$__dir}/template-{$template}") ?>
