<?php
/**
 * @package       RSForm! Pro
 * @copyright (C) 2019 - 2020 www.rsjoomla.com
 * @license       GPL, http://www.gnu.org/copyleft/gpl.html
 */

defined('_JEXEC') or die;

define('RSFORM_FIELD_ADVANCED_SWITCH', 600);
define('RSFORM_FIELD_ADVANCED_RATING', 602);
define('RSFORM_FIELD_ADVANCED_TEXTAREA', 603);
define('RSFORM_FIELD_ADVANCED_COLORPICKER', 604);
define('RSFORM_FIELD_ADVANCED_SELECTIZE', 605);
define('RSFORM_FIELD_ADVANCED_CHECKBOX', 606);
define('RSFORM_FIELD_ADVANCED_RADIO', 607);
define('RSFORM_FIELD_ADVANCED_DATEDROPPER', 608);
define('RSFORM_FIELD_ADVANCED_TIMEDROPPER', 609);
define('RSFORM_FIELD_ADVANCED_DATEPICKER', 610);

/**
 * Class plgSystemRSFPAdvancedFormFields
 *
 * @since 1.0.0
 */
class plgSystemRsfpadvancedformfields extends JPlugin
{
	/**
	 * @var bool
	 * @since 1.0.0
	 */
	protected $autoloadLanguage = true;

	/**
	 * @var array
	 * @since 1.0.0
	 */
	protected $newComponents = array(
		RSFORM_FIELD_ADVANCED_SWITCH => array('label' => 'RSFP_RSFASWITCH_LABEL', 'name' => 'switch', 'id' => RSFORM_FIELD_ADVANCED_SWITCH),
		RSFORM_FIELD_ADVANCED_RATING => array('label' => 'RSFP_RSFARATING_LABEL', 'name' => 'rating', 'id' => RSFORM_FIELD_ADVANCED_RATING),
		RSFORM_FIELD_ADVANCED_TEXTAREA => array('label' => 'RSFP_RSFATEXTAREA_LABEL', 'name' => 'advtextarea', 'id' => RSFORM_FIELD_ADVANCED_TEXTAREA),
		RSFORM_FIELD_ADVANCED_COLORPICKER => array('label' => 'RSFP_RSFACOLORPICKER_LABEL', 'name' => 'colorpicker', 'id' => RSFORM_FIELD_ADVANCED_COLORPICKER),
		RSFORM_FIELD_ADVANCED_SELECTIZE => array('label' => 'RSFP_RSFASELECTIZE_LABEL', 'name' => 'selectize', 'id' => RSFORM_FIELD_ADVANCED_SELECTIZE),
		RSFORM_FIELD_ADVANCED_CHECKBOX => array('label' => 'RSFP_RSFACHECKBOX_LABEL', 'name' => 'advcheckbox', 'id' => RSFORM_FIELD_ADVANCED_CHECKBOX),
		RSFORM_FIELD_ADVANCED_RADIO => array('label' => 'RSFP_RSFARADIO_LABEL', 'name' => 'advradio', 'id' => RSFORM_FIELD_ADVANCED_RADIO),
		RSFORM_FIELD_ADVANCED_DATEDROPPER => array('label' => 'RSFP_RSFADATEDROPPER_LABEL', 'name' => 'datedropper', 'id' => RSFORM_FIELD_ADVANCED_DATEDROPPER),
		RSFORM_FIELD_ADVANCED_TIMEDROPPER => array('label' => 'RSFP_RSFATIMEDROPPER_LABEL', 'name' => 'timedropper', 'id' => RSFORM_FIELD_ADVANCED_TIMEDROPPER),
		RSFORM_FIELD_ADVANCED_DATEPICKER => array('label' => 'RSFP_RSFADATEPICKER_LABEL', 'name' => 'datepicker', 'id' => RSFORM_FIELD_ADVANCED_DATEPICKER),
	);

	/**
	 *
	 * @since 1.0.0
	 */
	public function onRsformBackendAfterShowComponents()
	{
        RSFormProAssets::addStyleSheet(JHtml::_('stylesheet', 'plg_system_rsfpadvancedformfields/fontello/fontello.css', array('pathOnly' => true, 'relative' => true)));
		?>
		<li class="rsform_navtitle"><?php echo JText::_('RSFP_ADVANCED_FORM_FIELDS_PLUGIN_TITLE') ?></li>
		<?php
		foreach ($this->newComponents as $component)
		{
		    ?>
		    <li>
                <a href="javascript: void(0);" onclick="<?php echo 'displayTemplate(' . $component['id'] . ')'; ?>;return false;" id="rsfpc<?php echo $component['id']; ?>"><span  class="rsficon rsfaicon-<?php echo $component['name']; ?>"></span><span class="inner-text" style="margin-left:5px;"><?php echo JText::_( $component['label'] ); ?></span>
            </a>
            </li>
            <?php
		}
	}

	public function onRsformBackendCreateConditionOptionFields($args)
    {
        $args['types'][] = RSFORM_FIELD_ADVANCED_SWITCH;
        $args['types'][] = RSFORM_FIELD_ADVANCED_SELECTIZE;
        $args['types'][] = RSFORM_FIELD_ADVANCED_CHECKBOX;
        $args['types'][] = RSFORM_FIELD_ADVANCED_RADIO;

	    if ($componentIds = RSFormProHelper::componentExists($args['formId'], RSFORM_FIELD_ADVANCED_RATING))
	    {
	    	$args['types'][] = RSFORM_FIELD_ADVANCED_RATING;

	    	foreach ($componentIds as $componentId)
		    {
			    $properties =& RSFormProHelper::getComponentProperties($componentId);

			    $increment = $properties['HALFSTAR'] === 'YES' ? 0.5 : 1;
			    $max       = (int) $properties['NUMBERSTARS'];

			    $properties['ITEMS'] = array();
			    for ($i = 0; $i <= $max; $i = $i + $increment)
			    {
				    $properties['ITEMS'][] = $i;
			    }

			    $properties['ITEMS'] = implode("\n", $properties['ITEMS']);
		    }
	    }
    }

	/**
	 * @param $args
	 *
	 * @since 1.0.0
	 */
	public function onRsformAfterCreatePlaceholders($args)
	{
		$formId       = $args['form']->FormId;
		$submission   = &$args['submission'];
		$placeholders = &$args['placeholders'];
		$values       = &$args['values'];

        if ($componentIds = RSFormProHelper::componentExists($formId, RSFORM_FIELD_ADVANCED_COLORPICKER))
        {
            $all_data = RSFormProHelper::getComponentProperties($componentIds);

            foreach ($all_data as $componentId => $data)
            {
                // {:color} placeholder
                $placeholders[] = '{' . $data['NAME'] . ':color}';
                if (!empty($submission->values[$data['NAME']]))
                {
                    $values[] = '<span style="width:20px; height:20px; display:inline-block; background-color:' . RSFormProHelper::htmlEscape($submission->values[$data['NAME']]) . '"></span>';
                }
                else
                {
                    $values[] = '';
                }

                // {:circle} placeholder
                $placeholders[] = '{' . $data['NAME'] . ':circle}';
                if (!empty($submission->values[$data['NAME']]))
                {
                    $values[] = '<span style="width:20px; height:20px; display:inline-block; border-radius:50px; background-color:' . RSFormProHelper::htmlEscape($submission->values[$data['NAME']]) . '"></span>';
                }
                else
                {
                    $values[] = '';
                }
            }
        }

		if ($args['form']->TextareaNewLines && ($componentIds = RSFormProHelper::componentExists($formId, RSFORM_FIELD_ADVANCED_TEXTAREA)))
		{
			$all_data = RSFormProHelper::getComponentProperties($componentIds);

			foreach ($all_data as $componentId => $data)
			{
				$pos = array_search('{' . $data['NAME'] . ':value}', $placeholders);

				if ($pos !== false)
				{
					$values[$pos] = nl2br($values[$pos]);
				}
			}
		}
	}

	/**
	 * @param $placeholders
	 * @param $componentId
	 *
	 * @return mixed
	 * @since 1.0.0
	 */
	public function onRsformAfterCreateQuickAddPlaceholders(& $placeholders, $componentId)
	{
		$placeholder_type = array(
			RSFORM_FIELD_ADVANCED_COLORPICKER => array('color', 'circle')
		);

		foreach ($placeholder_type as $id => $values)
		{
			if ($componentId == $id)
			{
				foreach ($values as $placeholder)
				{
					$placeholders['display'][] = '{' . $placeholders['name'] . ':' . $placeholder . '}';
				}
			}
		}

		return $placeholders;
	}

	/**
	 * @param $args
	 *
	 * @since 1.0.0
	 */
	public function onRsformBackendManageSubmissions($args)
	{
		$componentIds = RSFormProHelper::componentExists($args['formId'], RSFORM_FIELD_ADVANCED_COLORPICKER);
		$all_data     = RSFormProHelper::getComponentProperties($componentIds);

		foreach ($args['submissions'] as $SubmissionId => $submission)
		{
			foreach ($all_data as $data)
			{
				if (isset($args['submissions'][$SubmissionId]['SubmissionValues'][$data['NAME']]['Value']))
				{
					$args['submissions'][$SubmissionId]['SubmissionValues'][$data['NAME']]['Value'] =
						'<span style="width:15px;height:15px;display:inline-block;border-radius:3px;background-color:' . RSFormProHelper::htmlEscape($args['submissions'][$SubmissionId]['SubmissionValues'][$data['NAME']]['Value']) . '" ></span>';
				}

			}
		}

	}

	/**
	 * @param $args
	 *
	 * @since 1.0.0
	 */
	public function onRsformBackendManageSubmissionsCreateUnescapedFields($args)
	{
		$unescaped_fields = array(RSFORM_FIELD_ADVANCED_COLORPICKER);

		foreach ($unescaped_fields as $field)
		{
			$componentIds = RSFormProHelper::componentExists($args['formId'], $field);
			$all_data     = RSFormProHelper::getComponentProperties($componentIds);

			foreach ($all_data as $data)
			{
				$args['fields'][] = $data['NAME'];
			}
		}

	}

	public function onRsformBackendGetTranslatableProperties(&$translatable)
    {
        $translatable[] = 'OFFVALUE';
        $translatable[] = 'ONVALUE';
    }

    public function onRsformFrontendGetEditFields(&$return, $submission)
    {
        $this->onRsformBackendGetEditFields($return, $submission);
    }

    public function onRsformBackendGetEditFields(&$return, $submission)
    {
        if ($componentIds = RSFormProHelper::componentExists($submission->FormId, array_keys($this->newComponents)))
        {
	        $app        = JFactory::getApplication();
	        $isSite     = $app->isClient('site');
            $isPDF      = $app->input->get('format') == 'pdf';
	        $values		= JFactory::getApplication()->input->get('form', array(), 'array');
            $all_data   = RSFormProHelper::getComponentProperties($componentIds, false);

            // Translate properties in requested language
            if ($translations = RSFormProHelper::getTranslations('properties', $submission->FormId, $submission->Lang))
            {
                foreach ($all_data as $componentId => $properties)
                {
                    foreach ($properties as $property => $value)
                    {
                        $reference_id = $componentId.'.'.$property;
                        if (isset($translations[$reference_id]))
                        {
                            $properties[$property] = $translations[$reference_id];
                        }
                    }
                    $all_data[$componentId] = $properties;
                }
            }

            if ($isPDF)
            {
                $db = JFactory::getDbo();
                $query = $db->getQuery(true)
                    ->select($db->qn('MultipleSeparator'))
                    ->select($db->qn('TextareaNewLines'))
                    ->from($db->qn('#__rsform_forms'))
                    ->where($db->qn('FormId') . ' = ' . $db->q($submission->FormId));
                $form = $db->setQuery($query)->loadObject();

                $form->MultipleSeparator = str_replace(array('\n', '\r', '\t'), array("\n", "\r", "\t"), $form->MultipleSeparator);
            }

            foreach ($all_data as $componentId => $data)
            {
                $typeId = RSFormProHelper::getComponentTypeId($data['NAME'], $submission->FormId);

                foreach ($return as $key => $field)
                {
                    if (isset($field[3]) && $field[3] == $data['NAME'])
                    {
                        $name = $data['NAME'];

	                    if (isset($values[$name]))
                        {
	                        $value = $values[$name];
                        }
	                    else
	                    {
		                    $value = isset($submission->values[$name]) ? $submission->values[$name] : '';
	                    }

                        switch ($typeId)
                        {
	                        case RSFORM_FIELD_ADVANCED_CHECKBOX:
	                        case RSFORM_FIELD_ADVANCED_RADIO:
                            case RSFORM_FIELD_ADVANCED_SELECTIZE:
                            case RSFORM_FIELD_ADVANCED_SWITCH:
                            case RSFORM_FIELD_ADVANCED_RATING:
                                if ($isPDF)
                                {
                                    $return[$key][1] = str_replace("\n", $form->MultipleSeparator, $value);
                                    break;
                                }

								$options = array();

                                $value = !empty($values) ? $value : RSFormProHelper::explode($value);
                                $value = (array) $value;

                                if ($typeId == RSFORM_FIELD_ADVANCED_CHECKBOX || ($typeId == RSFORM_FIELD_ADVANCED_SELECTIZE && $data['MULTIPLE'] == 'YES'))
                                {
                                    $data['SIZE'] = 5;
                                    $data['MULTIPLE'] = 'YES';
                                }
                                elseif ($typeId == RSFORM_FIELD_ADVANCED_SWITCH)
                                {
                                    $data['ITEMS'] = implode("\n", array(
                                       $data['OFFVALUE'],
                                       $data['ONVALUE']
                                    ));

                                    $data['SIZE'] = 0;
                                    $data['MULTIPLE'] = 'NO';
                                }
                                elseif ($typeId == RSFORM_FIELD_ADVANCED_RATING)
                                {
                                    $data['ITEMS'] = array();
                                    if ($data['HALFSTAR'] == 'YES')
                                    {
                                        $increment = 0.5;
                                    }
                                    else
                                    {
                                        $increment = 1;
                                    }

                                    for ($i = 0; $i <= $data['NUMBERSTARS']; $i += $increment)
                                    {
                                        $data['ITEMS'][] = $i;
                                    }

                                    $data['ITEMS'] = implode("\n", $data['ITEMS']);

                                    $data['SIZE'] = 0;
                                    $data['MULTIPLE'] = 'NO';
                                }
                                else
                                {
                                    $data['SIZE'] = 0;
                                    $data['MULTIPLE'] = 'NO';
                                }

                                if ($typeId == RSFORM_FIELD_ADVANCED_RADIO)
								{
									$options[] = JHtml::_('select.option', '', JText::_('PLG_SYSTEM_RSFPADVANCEDFORMFIELDS_NO_VALUE'));
								}

                                require_once JPATH_ADMINISTRATOR . '/components/com_rsform/helpers/fields/fielditem.php';
                                require_once JPATH_ADMINISTRATOR . '/components/com_rsform/helpers/fieldmultiple.php';
                                $field = new RSFormProFieldMultiple(array(
                                    'formId' 			=> $submission->FormId,
                                    'componentId' 		=> $componentId,
                                    'data' 				=> $data,
                                    'value' 			=> array('formId' => $submission->FormId, $data['NAME'] => $value),
                                    'invalid' 			=> array()
                                ));

                                if ($items = $field->getItems())
                                {
                                    foreach ($items as $item)
                                    {
                                        $item = new RSFormProFieldItem($item);

                                        if ($item->flags['optgroup']) {
                                            $options[] = JHtml::_('select.option', '<OPTGROUP>', $item->label, 'value', 'text');
                                        } elseif ($item->flags['/optgroup']) {
                                            $options[] = JHtml::_('select.option', '</OPTGROUP>', $item->label, 'value', 'text');
                                        } else {
                                            $options[] = JHtml::_('select.option', $item->value, $item->label, 'value', 'text', $item->flags['disabled']);
                                        }
                                    }
                                }

                                $attribs = array();

                                if ((int) $data['SIZE'] > 0)
                                {
                                    $attribs[] = 'size="'.(int) $data['SIZE'].'"';
                                }

                                if ($data['MULTIPLE'] == 'YES')
                                {
                                    $attribs[] = 'multiple="multiple"';
                                }

                                $attribs = implode(' ', $attribs);

                                $return[$key][1] = JHtml::_('select.genericlist', $options, 'form['.$name.'][]', $attribs, 'value', 'text', $value);

                                break;

                            case RSFORM_FIELD_ADVANCED_TEXTAREA:
                                if ($isPDF)
                                {
                                    if ($form->TextareaNewLines)
                                    {
                                        $value = nl2br(RSFormProHelper::htmlEscape($value));
                                    }

                                    $return[$key][1] = $value;
                                }
                                else
                                {
                                    $return[$key][1] = '<textarea style="width: 95%" class="rs_textarea" rows="10" cols="60" name="form['.$name.']">'.RSFormProHelper::htmlEscape($value).'</textarea>';
                                }

                                break;
                        }

	                    if ($isSite)
	                    {
		                    switch ($typeId)
		                    {
			                    case RSFORM_FIELD_ADVANCED_CHECKBOX:
			                    case RSFORM_FIELD_ADVANCED_RADIO:
				                    $options = array();
                                    $value = !empty($values) ? $value : RSFormProHelper::explode($value);
                                    $value = (array) $value;

				                    if ($typeId == RSFORM_FIELD_ADVANCED_CHECKBOX)
				                    {
					                    $htmlType = 'checkbox';
					                    $htmlName = 'form[' . RSFormProHelper::htmlEscape($name) . '][]';
				                    }
				                    else
				                    {
					                    $htmlName = 'form[' . RSFormProHelper::htmlEscape($name) . ']';
					                    $htmlType = 'radio';
				                    }

				                    require_once JPATH_ADMINISTRATOR . '/components/com_rsform/helpers/fields/fielditem.php';
				                    require_once JPATH_ADMINISTRATOR . '/components/com_rsform/helpers/fieldmultiple.php';
				                    $f = new RSFormProFieldMultiple(array(
					                    'formId' 			=> $submission->FormId,
					                    'componentId' 		=> $componentId,
					                    'data' 				=> $data,
					                    'value' 			=> array('formId' => $submission->FormId, $data['NAME'] => $value),
					                    'invalid' 			=> array()
				                    ));

				                    if ($items = $f->getItems())
				                    {
					                    $i = 0;
					                    foreach ($items as $item)
					                    {
						                    $item = new RSFormProFieldItem($item);

						                    $html = '<label><input type="' . $htmlType . '" ' .
							                    ' name="' . $htmlName . '"' .
							                    ' value="' . RSFormProHelper::htmlEscape($item->value) . '"' .
							                    ' id="' . RSFormProHelper::htmlEscape($name) . $i . '"';

						                    if ($item->flags['disabled']) {
							                    $html .= ' disabled="disabled"';
						                    }

						                    if (in_array($item->value, $value)) {
							                    $html .= ' checked="checked"';
						                    }

						                    $html .= '> ' . $item->label . '</label>';

						                    $options[] = $html;

						                    $i++;
					                    }
				                    }

				                    if ($max = (int) $f->getProperty('MAXSELECTIONS'))
				                    {
					                    $id = $f->getId();
					                    RSFormProAssets::addScriptDeclaration("RSFormPro.limitSelections({$submission->FormId}, '{$id}', {$max});");
				                    }

			                        $return[$key][1] = '<p>' . implode('</p><p>', $options) . '</p>';
				                    break;
		                    }
	                    }
                    }
                }
            }
        }
    }
	
	public function onRsformFrontendAJAXScriptCreate($data) {
		if (RSFormProHelper::componentExists($data['formId'], RSFORM_FIELD_ADVANCED_DATEPICKER))
		{
			$data['script'] .= '
		function rsf_advanced_datepicker_unfocus(task) {
			if (task == "afterSend" && typeof jQuery !== "undefined") {
                var datepickers = jQuery(\'input[data-rsfp-type="datepicker"]:focus\');

                if (datepickers.length) {
                    datepickers.each(function(){
                        var datepicker_name = jQuery(this).attr("id");

                        if (RSFormPro.AdvancedFormFields.datepickers[datepicker_name].pickadate("get","open")) {
                            RSFormPro.AdvancedFormFields.datepickers[datepicker_name].pickadate("close");
                        }

                    });
                }
			}
		}
		rsf_advanced_datepicker_unfocus(task);'."\n";
		}
    }
}