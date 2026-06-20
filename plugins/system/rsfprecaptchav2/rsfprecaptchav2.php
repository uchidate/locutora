<?php
/**
* @package RSform!Pro
* @copyright (C) 2014 www.rsjoomla.com
* @license GPL, http://www.gnu.org/copyleft/gpl.html
*/

defined('_JEXEC') or die;

define('RSFORM_FIELD_RECAPTCHAV2', 2424);

class plgSystemRsfprecaptchav2 extends JPlugin
{
	protected $autoloadLanguage = true;
	
	// Show field in Form Components
	public function onRsformBackendAfterShowComponents() {
		$input 		= JFactory::getApplication()->input;
		$formId 	= $input->getInt('formId');
		$exists 	= RSFormProHelper::componentExists($formId, RSFORM_FIELD_RECAPTCHAV2);
		$link		= $exists ? "displayTemplate('" . RSFORM_FIELD_RECAPTCHAV2 . "', '{$exists[0]}')" : "displayTemplate('" . RSFORM_FIELD_RECAPTCHAV2 ."')";
		
		?>
		<li><a href="javascript: void(0);" onclick="<?php echo $link;?>;return false;" id="rsfpc<?php echo RSFORM_FIELD_RECAPTCHAV2; ?>"><span class="rsficon rsficon-spinner9"></span><span class="inner-text"><?php echo JText::_('RSFP_RECAPTCHAV2_LABEL'); ?></span></a></li>
		<?php
	}

	// Show the Configuration tab
	public function onRsformBackendAfterShowConfigurationTabs($tabs)
	{
		$tabs->addTitle(JText::_('RSFP_RECAPTCHAV2_LABEL'), 'page-recaptchav2');
		$tabs->addContent($this->showConfigurationScreen());
	}
	
	protected function showConfigurationScreen()
	{
		ob_start();

		JForm::addFormPath(__DIR__ . '/forms');

		$form = JForm::getInstance( 'plg_system_rsfprecaptchav2.configuration', 'configuration', array('control' => 'rsformConfig'), false, false );
		$form->bind($this->loadFormData());

		?>
		<div id="page-recaptchav2" class="form-horizontal">
			<p><a href="https://www.google.com/recaptcha/" target="_blank"><?php echo JText::_('RSFP_RECAPTCHAV2_GET_RECAPTCHA_HERE'); ?></a></p>
			<?php
			foreach ($form->getFieldsets() as $fieldset)
			{
				if ($fields = $form->getFieldset($fieldset->name))
				{
					foreach ($fields as $field)
					{
						echo $field->renderField();
					}
				}
			}
			?>
		</div>
		<?php

		$contents = ob_get_contents();
		ob_end_clean();

		return $contents;
	}

	private function loadFormData()
	{
		$data 	= array();
		$db 	= JFactory::getDbo();

		$query = $db->getQuery(true)
			->select('*')
			->from($db->qn('#__rsform_config'))
			->where($db->qn('SettingName') . ' LIKE ' . $db->q('recaptchav2.%', false));
		if ($results = $db->setQuery($query)->loadObjectList())
		{
			foreach ($results as $result)
			{
				$data[$result->SettingName] = $result->SettingValue;
			}
		}

		return $data;
	}
	
	public function onRsformFrontendAJAXScriptCreate($args)
	{
		$script =& $args['script'];
		$formId = $args['formId'];
		
		if ($componentId = RSFormProHelper::componentExists($formId, RSFORM_FIELD_RECAPTCHAV2))
		{
			$form = RSFormProHelper::getForm($formId);

			$logged	= $form->RemoveCaptchaLogged ? JFactory::getUser()->id : false;

			$data = RSFormProHelper::getComponentProperties($componentId[0]);
			
			if (!empty($data['SIZE']) && $data['SIZE'] == 'INVISIBLE' && !$logged)
			{
				$script .= 'ajaxValidationRecaptchaV2(task, formId, data, '.$componentId[0].');'."\n";
			}
		}
	}
	
	public function onRsformFrontendAfterFormProcess($args)
	{
		$formId = $args['formId'];
		
		if (RSFormProHelper::componentExists($formId, RSFORM_FIELD_RECAPTCHAV2)) {
			JFactory::getSession()->clear('com_rsform.recaptchav2Token'.$formId);
		}
	}

	public function onRsformFrontendInitFormDisplay($args)
	{
		if ($componentIds = RSFormProHelper::componentExists($args['formId'], RSFORM_FIELD_RECAPTCHAV2))
		{
			$all_data = RSFormProHelper::getComponentProperties($componentIds);

			if ($all_data)
			{
				foreach ($all_data as $componentId => $data)
				{
					$args['formLayout'] = preg_replace('/<label (.*?) for="' . preg_quote($data['NAME'], '/') .'"/', '<label $1', $args['formLayout']);
				}
			}
		}
	}
}