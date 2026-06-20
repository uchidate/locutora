<?php
/**
* @package RSForm!Pro
* @copyright (C) 2007-2020 www.rsjoomla.com
* @license GPL, http://www.gnu.org/copyleft/gpl.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

class ModRSFormListHelper
{
	protected $formId = 1;
	protected $params;
	protected $textareaFields = array();
	
	protected $_form;
	protected $_data = array();
	protected $_total = 0;
	protected $_query = '';
	protected $_pagination;
	protected $_db;
	protected $_state;
	
	public function __construct($params)
	{
		$this->params = $params;
		$this->formId = (int) $this->params->def('formId', 1);
		$this->_state = new JObject();
		
		$this->_db 		= JFactory::getDbo();
		$this->_query 	= $this->_buildQuery();
		
		// Get pagination request variables
		$limit 		= $this->params->def('limit', 30);
		$limitstart	= JFactory::getApplication()->input->getInt('mod_rsform_listlimitstart', 0);
		
		// In case limit has been changed, adjust it
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
		
		$this->setState('mod_rsform_list.submissions.'.$this->formId.'.limit', $limit);
		$this->setState('mod_rsform_list.submissions.'.$this->formId.'.limitstart', $limitstart);
	}
	
	public function getUrl($submissionId) {
		static $type = array(); 
		static $itemId;
		
		if (!isset($type[$this->formId])) {
			$type[$this->formId]	= 'module';
			$itemId					= (int) $this->params->get('menu_type_itemid');
			
			// Do we have menu item ID set?
			if ($itemId) {
				// Let's check the menu item type
				if (($item = JFactory::getApplication()->getMenu()->getItem($itemId)) // Menu item exists
					&& (isset($item->query) && is_array($item->query)) // Has query element and it's an array
					&& (isset($item->query['option']) && ($item->query['option'] == 'com_rsform')) // Is an RSForm! Pro menu item
					&& (isset($item->query['view']) && ($item->query['view'] == 'submissions' || $item->query['view'] == 'directory')) // Points to Submissions or Directory.
					) {
						// Everything looks good here, grab the menu type
						$type[$this->formId] = $item->query['view'];
				}
			}
		}
		
		switch ($type[$this->formId])
		{
			case 'submissions':
				return JRoute::_("index.php?option=com_rsform&view=submissions&layout=view&cid=$submissionId&Itemid=$itemId");
			break;
			
			case 'directory':
				return JRoute::_("index.php?option=com_rsform&view=directory&layout=view&id=$submissionId&Itemid=$itemId");
			break;
			
			case 'module':
			default:
				// Build base URL.
				static $baseUrl;
				if (!$baseUrl) {
					$uri = JUri::getInstance();
					$uri->delVar('detail'.$this->formId);
					$baseUrl  = (string) $uri;
					$baseUrl .= strpos($baseUrl, '?') !== false ? '&' : '?';
				}
				
				return JRoute::_("{$baseUrl}detail{$this->formId}=$submissionId");
			break;
		}
	}
	
	public function getDate($date)
	{
		return RSFormProHelper::getDate($date);
	}
	
	public function getForm()
	{
		$query = $this->_db->getQuery(true)
			->select($this->_db->qn('MultipleSeparator'))
			->select($this->_db->qn('TextareaNewLines'))
			->from($this->_db->qn('#__rsform_forms'))
			->where($this->_db->qn('FormId') . ' = ' . $this->_db->q($this->formId));
		$form = $this->_db->setQuery($query)->loadObject();

		$form->MultipleSeparator = str_replace(array('\n', '\r', '\t'), array("\n", "\r", "\t"), $form->MultipleSeparator);

		return $form;
	}
	
	protected function _buildQuery()
	{
		$query  = "SELECT SQL_CALC_FOUND_ROWS DISTINCT(sv.SubmissionId), s.* FROM #__rsform_submissions s";
		$query .= " LEFT JOIN #__rsform_submission_values sv ON (s.SubmissionId=sv.SubmissionId)";
		$query .= " WHERE s.FormId='".$this->formId."'";
		
		$confirmed = $this->params->get('show_confirmed', 0);
		if ($confirmed)
			$query .= " AND s.confirmed='1'";
		
		$lang = $this->params->get('lang', '');
		if ($lang)
			$query .= " AND s.Lang='".$this->_db->escape($lang)."'";
		
		$userId = $this->params->def('userId', 0);
		if ($userId == 'login')
		{
			$user = JFactory::getUser();
			if ($user->get('guest'))
				$query .= " AND 1>2";
			
			$query .= " AND s.UserId='".(int) $user->get('id')."'";
		}
		elseif ($userId == 0)
		{
			// Show all submissions
		}
		else
		{
			$userId = explode(',', $userId);
			$userId = array_map('intval', $userId);
			
			$query .= " AND s.UserId IN (".implode(',', $userId).")";
		}
		
		$dir = $this->params->get('sort_submissions') ? 'ASC' : 'DESC';
		
		$query .= " ORDER BY s.DateSubmitted $dir";
		
		return $query;
	}
	
	public function getPagination()
	{
		if (empty($this->_pagination))
		{
			$this->_pagination = new JPagination($this->getTotal(), $this->getState('mod_rsform_list.submissions.'.$this->formId.'.limitstart'), $this->getState('mod_rsform_list.submissions.'.$this->formId.'.limit'), 'mod_rsform_list');
		}
		
		return $this->_pagination;
	}
	
	public function getTotal()
	{
		return $this->_total;
	}
	
	public function getSubmissions()
	{
		if (empty($this->_data))
		{
			$this->getComponents();

			$this->_db->setQuery("SET SQL_BIG_SELECTS=1");
			$this->_db->execute();
			
			$submissionIds = array();
			
			$this->_db->setQuery($this->_query, $this->getState('mod_rsform_list.submissions.'.$this->formId.'.limitstart'), $this->getState('mod_rsform_list.submissions.'.$this->formId.'.limit'));
			$results = $this->_db->loadObjectList();
			$this->_db->setQuery("SELECT FOUND_ROWS()");
			$this->_total = $this->_db->loadResult();

			foreach ($results as $result)
			{
				$submissionIds[] = $result->SubmissionId;

				$this->_data[$result->SubmissionId]['FormId'] = $result->FormId;
				$this->_data[$result->SubmissionId]['DateSubmitted'] = $this->getDate($result->DateSubmitted);
				$this->_data[$result->SubmissionId]['UserIp'] = $result->UserIp;
				$this->_data[$result->SubmissionId]['Username'] = $result->Username;
				$this->_data[$result->SubmissionId]['UserId'] = $result->UserId;
				$this->_data[$result->SubmissionId]['confirmed'] = $result->confirmed ? JText::_('RSFP_YES') : JText::_('RSFP_NO');
				$this->_data[$result->SubmissionId]['SubmissionHash'] = $result->SubmissionHash;
				$this->_data[$result->SubmissionId]['ConfirmationHash'] = md5($result->SubmissionId . $result->FormId . $result->DateSubmitted);
				$this->_data[$result->SubmissionId]['SubmissionValues'] = array();
			}
			
			$form = $this->getForm();
			
			if (!empty($submissionIds))
			{
				$this->_db->setQuery("SELECT * FROM `#__rsform_submission_values` WHERE `SubmissionId` IN (".implode(',',$submissionIds).")");
				$results = $this->_db->loadObjectList();
				
				$config = JFactory::getConfig();
				$secret = $config->get('secret');
				foreach ($results as $result)
				{
					// Check if this is an upload field
					if (in_array($result->FieldName, $this->uploadFields) && !empty($result->FieldValue))
					{
						$result->FilePath = $result->FieldValue;

						$files = RSFormProHelper::explode($result->FieldValue);
						$actualValues = array();
						foreach ($files as $file)
						{
							$actualValues[] = '<a href="' . JRoute::_('index.php?option=com_rsform&task=submissions.viewfile&hash=' . md5($result->SubmissionId . $secret . $result->FieldName) . '&file=' . md5($file)) . '">' . RSFormProHelper::htmlEscape(basename($file)) . '</a>';
						}
						$result->FieldValue = implode('<br />', $actualValues);
					}
					// Check if this is a multiple field
					elseif (in_array($result->FieldName, $this->multipleFields))
					{
						$result->FieldValue = str_replace("\n", $form->MultipleSeparator, $result->FieldValue);
					}
					elseif ($form->TextareaNewLines && in_array($result->FieldName, $this->textareaFields))
					{
						$result->FieldValue = nl2br($result->FieldValue);
					}
						
					$this->_data[$result->SubmissionId]['SubmissionValues'][$result->FieldName] = array('Value' => $result->FieldValue, 'Id' => $result->SubmissionValueId);

					if (!empty($result->FilePath))
					{
						$files = RSFormProHelper::explode($result->FilePath);

						$actualValues = array();
						$images = array();
						foreach ($files as $filepath)
						{
							$filepath = str_replace(JPATH_SITE.DIRECTORY_SEPARATOR, JUri::root(), $filepath);
							$filepath = str_replace(array('\\', '\\/', '//\\'), '/', $filepath);

							$actualValues[] = $filepath;
							$images[] = '<img src="' . RSFormProHelper::htmlEscape($filepath) . '">';
						}

						$this->_data[$result->SubmissionId]['SubmissionValues'][$result->FieldName]['Path'] = implode('<br />', $actualValues);
						$this->_data[$result->SubmissionId]['SubmissionValues'][$result->FieldName]['Image'] = implode('<br />', $images);
					}
				}
			}
			unset($results);
		}
		
		return $this->_data;
	}
	
	public function getReplacements($user_id=0, $globals = false)
	{
		static $sitename, $siteurl, $mailfrom, $fromname;

		if (is_null($siteurl))
		{
			$config 	= JFactory::getConfig();
			$sitename 	= $config->get('sitename');
			$siteurl	= JUri::root();
			$mailfrom	= $config->get('mailfrom');
			$fromname	= $config->get('fromname');
		}

		$user = JFactory::getUser((int) $user_id);

		if ($globals)
		{
			$replace = array('{global:sitename}', '{global:siteurl}', '{global:userid}', '{global:username}', '{global:email}', '{global:fullname}', '{global:mailfrom}', '{global:fromname}', '{/details}', '{/detailspdf}');
			$with 	 = array($sitename, JUri::root(), $user->get('id'), $user->get('username'), $user->get('email'), $user->get('name'), $mailfrom, $fromname, '</a>', '</a>');
		}
		else
		{
			$replace = array('{global:email}', '{/details}', '{/detailspdf}');
			$with 	 = array($user->get('email'), '</a>', '</a>');
		}
			
		return array($replace, $with);
	}
	
	protected function getComponents()
	{
		list($multipleSeparator, $this->uploadFields, $this->multipleFields, $this->textareaFields, $secret) = RSFormProHelper::getDirectoryFormProperties($this->formId);
	}
	
	public function getHeaders()
	{
		$headers = array();

		if ($fields = RSFormProHelper::getComponents($this->formId))
		{
			foreach ($fields as $field)
			{
				$headers[] = $field->name;
			}
		}
		
		return $headers;
	}
	
	protected function getState($property) {
		return $this->_state->get($property);
	}
	
	protected function setState($property, $value) {
		return $this->_state->set($property, $value);
	}
}