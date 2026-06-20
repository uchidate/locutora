<?php
/**
 * @package    RSForm! Pro
 * @copyright  (c) 2007 - 2016 RSJoomla!
 * @link       https://www.rsjoomla.com
 * @license    GNU General Public License http://www.gnu.org/licenses/gpl-3.0.en.html
 */

defined('_JEXEC') or die;

/**
 * Class plgSystemRsfpmailer
 */
class plgSystemRsfpmailer extends JPlugin
{
	/**
	 * @var bool
	 */
	protected $autoloadLanguage = true;

	/**
	 * Show the configuration tab (RSForm!Pro - Configuration)
	 *
	 * @param $tabs
	 */
	public function onRsformBackendAfterShowConfigurationTabs($tabs)
	{
		$tabs->addTitle(JText::_('PLG_SYSTEM_RSFPMAILER_LABEL'), 'page-rsfpmailer');
		$tabs->addContent($this->configurationScreen());
	}

	private function loadFormData()
	{
		$data 	= array();
		$db 	= JFactory::getDbo();

		$query = $db->getQuery(true)
			->select('*')
			->from($db->qn('#__rsform_config'))
			->where($db->qn('SettingName') . ' LIKE ' . $db->q('mailer.%', false));
		if ($results = $db->setQuery($query)->loadObjectList())
		{
			foreach ($results as $result)
			{
				$data[$result->SettingName] = $result->SettingValue;
			}
		}

		return $data;
	}

	/**
	 * The actual content of the Configuration tab
	 *
	 * @return string
	 */
	protected function configurationScreen()
	{
		ob_start();

		JForm::addFormPath(__DIR__ . '/forms');
		JForm::addFieldPath(__DIR__ . '/fields');

		$form = JForm::getInstance( 'plg_system_rsfpmailer.configuration', 'configuration', array('control' => 'rsformConfig'), false, false );
		$form->bind($this->loadFormData());

		?>
		<div id="page-rsfpmailer" class="form-horizontal">
			<?php
			foreach ($form->getFieldsets() as $fieldset)
			{
				if ($fields = $form->getFieldset($fieldset->name))
				{
					foreach ($fields as $field)
					{
						// This is a workaround because our fields are named "mailer." and Joomla! uses the dot as a separator and transforms the JSON into [mailer][type] instead of [mailer.type].
						echo str_replace('"rsformConfig[mailer][', '"rsformConfig[mailer.', $form->renderField($field->fieldname));
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

	/**
	 * Override the mailer settings
	 *
	 * @param $args
	 *
	 * @return bool
	 */
	public function onRsformCreateMailer($args)
	{
		$mailer = RSFormProHelper::getConfig('mailer.type');

		if ($mailer != 'default')
		{
			switch ($mailer)
			{
				case 'smtp':
					$smtpauth   = (RSFormProHelper::getConfig('mailer.smtpauth') == '0') ? null : 1;
					$smtphost   = RSFormProHelper::getConfig('mailer.smtphost');
					$smtpuser   = RSFormProHelper::getConfig('mailer.smtpusername');
					$smtppass   = RSFormProHelper::getConfig('mailer.smtppassword');
					$smtpsecure = RSFormProHelper::getConfig('mailer.smtpsecurity');
					$smtpport   = (int) RSFormProHelper::getConfig('mailer.smtpport');
					$args['mailer']->useSmtp($smtpauth, $smtphost, $smtpuser, $smtppass, $smtpsecure, $smtpport);
					break;

				case 'sendmail':
					$sendmail = RSFormProHelper::getConfig('mailer.sendmailpath');
					$args['mailer']->useSendmail($sendmail);
					$args['mailer']->IsSendmail();
					break;

				case 'phpmail':
					$args['mailer']->IsMail();
					break;
			}
		}

		$enabledkim = RSFormProHelper::getConfig('mailer.enabledkim');

		if ($enabledkim)
		{
			if (RSFormProHelper::getConfig('mailer.dkimdomain') &&
				RSFormProHelper::getConfig('mailer.dkimselector') &&
				RSFormProHelper::getConfig('mailer.dkimprivatekey') &&
				RSFormProHelper::getConfig('mailer.dkimpublickey')
			)
			{
				$args['mailer']->DKIM_domain     = RSFormProHelper::getConfig('mailer.dkimdomain');
				$args['mailer']->DKIM_selector   = RSFormProHelper::getConfig('mailer.dkimselector');
				$args['mailer']->DKIM_identity   = RSFormProHelper::getConfig('mailer.dkimidentity');
				$args['mailer']->DKIM_passphrase = RSFormProHelper::getConfig('mailer.dkimpassphrase');

				// Create a temporary file to hold the private key
				if ($temp_file = tempnam(sys_get_temp_dir(), 'rsfpmailer'))
				{
					if (file_put_contents($temp_file, RSFormProHelper::getConfig('mailer.dkimprivatekey')))
					{
						$args['mailer']->DKIM_private = $temp_file;
					}
					else
					{
						JFactory::getApplication()->enqueueMessage(JText::_('PLG_SYSTEM_RSFPMAILER_ERROR_WRITE'), 'error');
					}
				}
				else
				{
					JFactory::getApplication()->enqueueMessage(JText::_('PLG_SYSTEM_RSFPMAILER_ERROR_TEMPNAM'), 'error');
				}
			}
		}

		$enableheaders = RSFormProHelper::getConfig('mailer.enableheaders');

		if ($enableheaders)
		{
			$headers = RSFormProHelper::getConfig('mailer.emailheaders');
			if (!empty($headers))
			{
				$headers = json_decode($headers);

				foreach ($headers as $header_name => $header_value)
				{
					$args['mailer']->addCustomHeader($header_name, $header_value);
				}
			}
		}

		return $args['mailer'];
	}
}