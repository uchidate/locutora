<?php
/**
* @package RSForm!Pro
* @copyright (C) 2007-2020 www.rsjoomla.com
* @license GPL, http://www.gnu.org/copyleft/gpl.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

if ($moduleclass_sfx) { ?>
<div class="<?php echo htmlentities($moduleclass_sfx, ENT_COMPAT, 'utf-8'); ?>">
<?php } ?>
	<?php echo $html; ?>
<?php if ($moduleclass_sfx) { ?>
</div>
<?php }