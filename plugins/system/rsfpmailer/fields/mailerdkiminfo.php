<?php
/**
 * @package    RSForm! Pro
 *
 * @copyright  (c) 2019 RSJoomla!
 * @link       https://www.rsjoomla.com
 * @license    GNU General Public License http://www.gnu.org/licenses/gpl-3.0.en.html
 */

defined('JPATH_PLATFORM') or die;

class JFormFieldMailerdkiminfo extends JFormField
{
	protected function getInput()
	{
		JFactory::getDocument()->addScriptDeclaration('var updateDKIMinfo = function() {' .
			'document.getElementById(\'dkimdomain\').innerText = document.getElementsByName(\'rsformConfig[mailer.dkimdomain]\')[0].value;' .
			'document.getElementById(\'dkimkey\').innerText = document.getElementsByName(\'rsformConfig[mailer.dkimselector]\')[0].value;' .
			'document.getElementById(\'dkimvalue\').innerText = document.getElementsByName(\'rsformConfig[mailer.dkimpublickey]\')[0].value;' .
		'}');

		return sprintf(
			'<div class="alert alert-info">' . JText::_('PLG_SYSTEM_RSFPMAILER_DKIMINFO') . ' <strong id="dkimdomain">%s</strong>' .
			'<hr /><strong>' . JText::_('PLG_SYSTEM_RSFPMAILER_DKIMINFOKEY') . '</strong> <span id="dkimkey">%s</span>._domainkey<br>' .
			'<strong>' . JText::_('PLG_SYSTEM_RSFPMAILER_DKIMINFOVALUE') . '</strong> v=DKIM1;k=rsa;g=*;s=email;t=s;p=<span id="dkimvalue">%s</span>' .
			'</div>', RSFormProHelper::getConfig('mailer.dkimdomain'), RSFormProHelper::getConfig('mailer.dkimselector'), RSFormProHelper::getConfig('mailer.dkimpublickey'));
	}
}