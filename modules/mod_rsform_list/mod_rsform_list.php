<?php
/**
* @package RSForm!Pro
* @copyright (C) 2007-2020 www.rsjoomla.com
* @license GPL, http://www.gnu.org/copyleft/gpl.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Check if the helper exists
$helper = JPATH_ADMINISTRATOR.'/components/com_rsform/helpers/rsform.php';
if (!file_exists($helper)) {
	return;
}

// Load Helper functions
require_once $helper;
require_once dirname(__FILE__).'/helper.php';

// Objects
$user = JFactory::getUser();
$db	  = JFactory::getDbo();

// Params
$formId			 = (int) $params->def('formId', 1);
$moduleclass_sfx = $params->def('moduleclass_sfx', '');
$userId 		 = $params->def('userId', 0);

// Template params
$template_module      = $params->def('template_module', '');
$template_formdatarow = $params->def('template_formdatarow', '');
$template_formdetail  = $params->def('template_formdetail', '');

$app 				= JFactory::getApplication();
$detail 			= $app->input->getInt('detail'.$formId);
$helper 			= new ModRSFormListHelper($params);

if (!$detail)
{
	$submissions = $helper->getSubmissions();
	$pagination  = $helper->getPagination();
	$headers	 = $helper->getHeaders();
	
	$formdata = '';
	$i  	  = 0;
	
	foreach ($submissions as $SubmissionId => $submission)
	{
		$url 			= $helper->getUrl($SubmissionId);
		$deleteLink 	= JRoute::_('index.php?option=com_rsform&task=deletesubmission&hash=' . $submission['SubmissionHash']);
		$confirmLink 	= JRoute::_('index.php?option=com_rsform&task=confirm&hash=' . $submission['ConfirmationHash']);

		list($replace, $with) = $helper->getReplacements($submission['UserId'], true);

		$replace = array_merge($replace, array('{global:userip}', '{global:date_added}', '{global:submissionid}', '{global:submission_id}', '{global:counter}', '{global:naturalcounter}', '{details}', '{details_link}', '{global:confirmed}', '{global:formid}', '{global:deletion}', '{global:confirmation}'));
		$with 	 = array_merge($with, array($submission['UserIp'], $submission['DateSubmitted'], $SubmissionId, $SubmissionId, $pagination->getRowOffset($i), $params->get('sort_submissions') ? $pagination->getRowOffset($i) : ($pagination->total + 1 - $pagination->getRowOffset($i)), '<a href="'.$url.'">', $url, $submission['confirmed'], $submission['FormId'], $deleteLink, $confirmLink));

		foreach ($headers as $header)
		{
			if (!isset($submission['SubmissionValues'][$header]['Value']))
			{
				$submission['SubmissionValues'][$header]['Value'] = '';
			}

			$replace[] 	= '{'.$header.':value}';
			$with[] 	= $submission['SubmissionValues'][$header]['Value'];
			
			if (!empty($submission['SubmissionValues'][$header]['Path']))
			{
				$replace[] 	= '{'.$header.':path}';
				$with[] 	= $submission['SubmissionValues'][$header]['Path'];
			}

			if (!empty($submission['SubmissionValues'][$header]['Image']))
			{
				$replace[] 	= '{'.$header.':image}';
				$with[] 	= $submission['SubmissionValues'][$header]['Image'];
			}
		}
		
		$replace[] 	= '{_STATUS:value}';
		$with[] 	= isset($submission['SubmissionValues']['_STATUS']) ? JText::_('RSFP_PAYMENT_STATUS_'.$submission['SubmissionValues']['_STATUS']['Value']) : '';

		$replace[] 	= '{_TRANSACTION_ID:value}';
		$with[] 	= isset($submission['SubmissionValues']['_TRANSACTION_ID']) ? $submission['SubmissionValues']['_TRANSACTION_ID']['Value'] : '';
		
		$row = $template_formdatarow;
		
		// RSForm! Pro Scripting - Form Data Row
		// performance check
		if (strpos($row, '{/if}') !== false) {
			require_once JPATH_ADMINISTRATOR.'/components/com_rsform/helpers/scripting.php';
			RSFormProScripting::compile($row, $replace, $with);
		}
		
		$formdata .= str_replace($replace, $with, $row);
		
		$i++;
	}

	$html = str_replace('{formdata}', $formdata, $template_module);
	if ($params->get('show_pagination', 1)) {
		if ($params->get('show_pagination_counter', 1)) {
			$html .= '<div>'.$pagination->getResultsCounter().'</div>';
		}
		$html .= '<div class="pagination">'.$pagination->getPagesLinks().'</div>';
	}
}
else
{
	if ($userId != 'login' && $userId != 0)
	{
		$userId = explode(',', $userId);
		$userId = array_map('intval', $userId);
	}

	try
	{
		$query = $db->getQuery(true)
			->select('*')
			->from($db->qn('#__rsform_submissions'))
			->where($db->qn('SubmissionId').' = '.$db->q($detail));

		$submission = $db->setQuery($query)->loadObject();

		if (!$submission)
		{
			throw new Exception(JText::sprintf('MOD_RSFORMLIST_SUBMISSION_DOESNT_EXIST', $detail));
		}

		if ($submission->FormId != $formId)
		{
			throw new Exception(JText::sprintf('MOD_RSFORMLIST_SUBMISSION_DOES_NOT_BELONG_TO_FORM', $detail, $formId));
		}

		if ($userId == 'login' && $submission->UserId != $user->get('id'))
		{
			throw new Exception(JText::sprintf('MOD_RSFORMLIST_SUBMISSION_DOES_NOT_BELONG_TO_LOGGED_IN_USER', $detail));
		}

		if ($params->get('show_confirmed', 0) && !$submission->confirmed)
		{
			throw new Exception(JText::sprintf('MOD_RSFORMLIST_SUBMISSION_IS_NOT_CONFIRMED', $detail));
		}
	}
	catch (Exception $e)
	{
		$app->enqueueMessage($e->getMessage(), 'warning');
		return;
	}

	list($replace, $with) 	= RSFormProHelper::getReplacements($detail);
	list($replace2, $with2) = $helper->getReplacements($submission->UserId);

	$replace3 = array('{global:submissionid}', '{global:submission_id}', '{global:date_added}', '{global:confirmed}', '{global:formid}');
	$with3	  = array($detail, $detail, $helper->getDate($submission->DateSubmitted), $submission->confirmed ? JText::_('JYES') : JText::_('JNO'), $submission->FormId);
	
	$replace = array_merge($replace, $replace2, $replace3);
	$with 	 = array_merge($with, $with2, $with3);
	
	// RSForm! Pro Scripting - Form Detail
	// performance check
	if (strpos($template_formdetail, '{/if}') !== false) {
		require_once JPATH_ADMINISTRATOR.'/components/com_rsform/helpers/scripting.php';
		RSFormProScripting::compile($template_formdetail, $replace, $with);
	}
	
	$html = str_replace($replace, $with, $template_formdetail);
}

// Display template
require JModuleHelper::getLayoutPath('mod_rsform_list');