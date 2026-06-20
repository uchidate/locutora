<?php
/**
 * @package    RSForm! Pro
 *
 * @copyright  (c) 2019 RSJoomla!
 * @link       https://www.rsjoomla.com
 * @license    GNU General Public License http://www.gnu.org/licenses/gpl-3.0.en.html
 */

defined('JPATH_PLATFORM') or die;

class JFormFieldMailerheaders extends JFormField
{
	protected function getInput()
	{
		JText::script('PLG_SYSTEM_RSFPMAILER_HEADER_NAME_PLACEHOLDER');
		JText::script('PLG_SYSTEM_RSFPMAILER_HEADER_VALUE_PLACEHOLDER');
		JText::script('PLG_SYSTEM_RSFPMAILER_SURE_DELETE_HEADER');

		JHtml::_('jquery.framework');

		JFactory::getDocument()->addScriptDeclaration('RSFormPro.EmailHeader = {};

			RSFormPro.EmailHeader.updateValues = function() {
				var headers = {};
				
				jQuery(\'.com-rsform-table-email-headers tbody tr\').each(function(i, elem){
					var header_name = jQuery(elem).find(\'.form_header_name\').val().trim();
					var header_value = jQuery(elem).find(\'.form_header_value\').val().trim();

					headers[header_name] = header_value;
				});
				
				document.getElementById(\'' . $this->id . '\').value = JSON.stringify(headers);
			};

			RSFormPro.EmailHeader.addField = function () {
				var $table = jQuery(\'.com-rsform-table-email-headers tbody\');
				var $row = jQuery(\'<tr class="email-header-row">\');

				var $inputName = jQuery(\'<td><input type="text" onchange="RSFormPro.EmailHeader.updateValues();" class="rs_inp rs_80 form_header_name" placeholder="\' + Joomla.JText._(\'PLG_SYSTEM_RSFPMAILER_HEADER_NAME_PLACEHOLDER\') + \'"></td>\');
				var $inputValue = jQuery(\'<td><input type="text" onchange="RSFormPro.EmailHeader.updateValues();" class="rs_inp rs_80 form_header_value" placeholder="\' + Joomla.JText._(\'PLG_SYSTEM_RSFPMAILER_HEADER_VALUE_PLACEHOLDER\') + \'"></td>\');
				var $deleteBtn = jQuery(\'<td>\').append(jQuery(\'<button type="button" class="btn btn-danger btn-mini"><i class="rsficon rsficon-remove"></i></button>\').click(RSFormPro.EmailHeader.deleteField));

				$row.append($inputName, $inputValue, $deleteBtn);
				$table.append($row);
			};

			RSFormPro.EmailHeader.deleteField = function () {
				if (confirm(Joomla.JText._(\'PLG_SYSTEM_RSFPMAILER_SURE_DELETE_HEADER\'))) {
					jQuery(this).parents(\'.email-header-row\').remove();
					RSFormPro.EmailHeader.updateValues();
				}
			};');

		$html = '<table width="100%" class="com-rsform-table-email-headers" style="border-spacing: 5px;border-collapse: initial;">' .
			'<thead>' .
			'<tr>' .
			'<th class="text-left" align="left" colspan="3"><button type="button" onclick="RSFormPro.EmailHeader.addField();" class="btn btn-primary">' . JText::_('PLG_SYSTEM_RSFPMAILER_ADD_HEADER') . '</button></th>' .
			'</tr>' .
			'<tr>' .
			'<th>' . JText::_('PLG_SYSTEM_RSFPMAILER_HEADER_NAME') . '</th>' .
			'<th colspan="2">' . JText::_('PLG_SYSTEM_RSFPMAILER_HEADER_VALUE') . '</th>' .
			'</tr>' .
			'</thead>' .
			'<tbody>';

		$headers = $this->value;

		if ($headers && strpos($headers, '{') !== false)
		{
			if ($headers = json_decode($headers))
			{
				foreach ($headers as $name => $value)
				{
					$html .= '<tr class="email-header-row">' .
						'<td><input type="text" class="rs_inp rs_80 form_header_name" onchange="RSFormPro.EmailHeader.updateValues();" value="' . RSFormProHelper::htmlEscape($name) . '" placeholder="' . RSFormProHelper::htmlEscape(JText::_('PLG_SYSTEM_RSFPMAILER_HEADER_NAME_PLACEHOLDER')) . '"></td>' .
						'<td><input type="text" class="rs_inp rs_80 form_header_value" onchange="RSFormPro.EmailHeader.updateValues();" value="' . RSFormProHelper::htmlEscape($value) . '" placeholder="' . RSFormProHelper::htmlEscape(JText::_('PLG_SYSTEM_RSFPMAILER_HEADER_VALUE_PLACEHOLDER')) . '"></td>' .
						'<td><button type="button" class="btn btn-danger btn-mini" onclick="RSFormPro.EmailHeader.deleteField.call(this);"><i class="rsficon rsficon-remove"></i></button></td>' .
					'</tr>';
				}
			}
		}

		$html .= '</tbody></table>';

		$html .= '<input type="hidden" name="' . $this->name .'" value="' . RSFormProHelper::htmlEscape($this->value) . '" id="' . $this->id . '" />';

		return $html;
	}
}