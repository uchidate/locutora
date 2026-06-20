if (typeof RSFormPro === 'undefined') {
	RSFormPro = {};
}

RSFormPro.AdvancedFormFields = {
	elements: [],
	datepickers: {},
	initiate: function () {
		var $formplate = jQuery('.formplate');

		if ($formplate.length) {
			jQuery('body').formplate();
		}
		jQuery.each(RSFormPro.AdvancedFormFields.elements, function () {
			var $self = jQuery(document.getElementById(this));
			var type = $self.data('rsfp-type');
			var options;
			var that = this;

			switch (type) {
				case 'datepicker':
					// init the options with the submit format (used only in the picker javascript) and unfocus the field when the picker is closed
					var picker_options = {formatSubmit: 'yyyy/mm/dd', hiddenPrefix: 'rsignore_', onClose: function(){
						jQuery(':focus').blur();
						if ($self.data('rsfp-editable')) {
							// unbind so that the calendar won't open again
							$self.unbind('focus');
							// focus again so that it can be written in the input
							$self.focus();
						}
					}};
					var picker_exception = [];

					jQuery.each($self.data(), function(index, value){
						if (index.indexOf('rsfp') > -1 && index != 'rsfpType' && index != 'rsfpOffset') {
							// remove the prefix
							var new_index = index.replace('rsfp', '');

							// first letter should be lower case
							new_index = new_index.charAt(0).toLowerCase() + new_index.slice(1);

							// if there is no value make it false
							if (value.length == 0) {
								value = false;
							}
							// some exceptions
							var skip = value === false;
							switch(new_index) {
								case 'min':
								case 'max':
									if (value) {
										value = RSFormPro.AdvancedFormFields.getDateArray(value);
									}
								break;
								case 'disableall':
									if (value) {
										new_index = 'disable';
										value = [true]
									}
								break;
								case 'selectMonths':
								case 'selectYears':
									value = value == 1;
								break;

								case 'daysdisabled':
									// the value must always be string
									value = value.toString();

									var days = value.split(',');
									var new_values = [];
									jQuery.each(days, function(i, val) {
										val = val.trim();
										val = parseInt(val);
										if (new_values.indexOf(val) < 0 && val != 0) {
											new_values.push(val);
										}
									});

									if (new_values.length > 0) {
										value = new_values;
										new_index = 'disable';
									}
								break;

								case 'exceptions':
									// the value must always be string
									value = value.toString();
									
									var value_data = value.split(',');

									jQuery.each(value_data, function(i, val) {
										if (!isNaN(val)) {
											val = parseInt(val);

											if (picker_exception.indexOf(val) < 0 && val != 0) {
												picker_exception.push(val);
											}

										} else {
											if (val.indexOf('|') > -1) {
												var dates = val.split('|');
												picker_exception.push({from:RSFormPro.AdvancedFormFields.getDateArray(dates[0]), to:RSFormPro.AdvancedFormFields.getDateArray(dates[1])});
											} else {
												picker_exception.push(RSFormPro.AdvancedFormFields.getDateArray(val));
											}
										}
									});

									// will skip this because we will process these exceptions later
									skip = true;
								break;

								case 'next':
									new_index = 'onSet';
									var other_calendar_id = value;
									var offset = typeof $self.data('rsfp-offset') === 'undefined' ? 0 : $self.data('rsfp-offset');

									value = function(context) {
										// set this only when a selection is made (set in this case)
										if (typeof context.select !== 'undefined') {
											RSFormPro.AdvancedFormFields.setMin(other_calendar_id, context, offset);
										}
									};
								break;

								case 'previous':
									new_index = 'onSet';
									var other_calendar_id = value;
									var offset = typeof $self.data('rsfp-offset') === 'undefined' ? 0 : $self.data('rsfp-offset');

									value = function(context) {
										// set this only when a selection is made (set in this case)
										if (typeof context.select !== 'undefined') {
											RSFormPro.AdvancedFormFields.setMax(other_calendar_id, context, offset);
										}
									};

								break;
							}

							if (!skip) {
								picker_options[new_index] = value;
							}
						}
					});

					// handle the found exceptions
					if (picker_exception.length && typeof picker_options.disable !== 'undefined') {

						// if daysdisabled is used we must remove integers and use the inverted parameter
						if (picker_options.disable[0] !== true) {
							var allowweekdays = [];
							var allowdates = [];

							jQuery.each(picker_exception, function(index, value){
								if (typeof value === 'number') {
									allowweekdays.push(value);
								} else {
									if (Array.isArray(value)){
										// add inverted
										value.push('inverted');
									} else {
										value.inverted = true;
									}
									// add to the dates array
									allowdates.push(value);
								}
							});

							var diffweekdays = jQuery(picker_options.disable).not(allowweekdays).get();
							picker_options.disable = diffweekdays.concat(allowdates);

						} else {
							picker_options.disable = picker_options.disable.concat(picker_exception);
						}
					}

					RSFormPro.AdvancedFormFields.datepickers[that] = $self.pickadate(picker_options);

					$self[0].rsfpOnChange = function(func) {
                        $self.pickadate('picker').on('set', function() {
                            if (typeof func === 'function') {
                                func();
                            }
                        });
					};

                    $self[0].rsfpGetValue = function() {
                    	var object = $self.pickadate('picker').get('select');

                    	if (object && object.hasOwnProperty('pick'))
						{
							return (object.pick / 1000).toString();
						}

                    	return '0';
                    };
				break;

				case 'colorpicker':
					$self.spectrum({
                        allowEmpty: true,
						chooseText: Joomla.JText._('RSFP_RSFA_COLOR_PICKER_CHOOSE'),
						cancelText: Joomla.JText._('RSFP_RSFA_COLOR_PICKER_CANCEL'),
                        preferredFormat: 'hex',
						showInput: $self.data('rsfp-showinput')
					});
				break;

				case 'selectize':
					options = {
						sortField       : [[]],
						searchField     : 'text',
						allowEmptyOption: true,
                        plugins: ['remove_button']
					};

					if (parseInt($self.data('rsfp-multiple')) === 1 && parseInt($self.data('rsfp-nritems')) > 0) {
                        options['maxItems'] = parseInt($self.data('rsfp-nritems'));
					}

					options['onChange'] = function(value) {
						RSFormPro.triggerEvent($self[0], 'change');
					};

					$self.selectize(options);
				break;

				case 'advtextarea':
					$self.fseditor({
						placeholder: $self.attr('placeholder'),
						transition : 'fade',
						overlay    : true,
						maxWidth   : $self.data('rsfp-max-width'),
						maxHeight  : $self.data('rsfp-max-height')
					});
				break;

				case 'rating':
					//set defaults
					options = {
						rating    : $self.data('rsfp-rating'),
						numStars  : $self.data('rsfp-nrstars'),
						starWidth : "40px",
                        normalFill: $self.data('rsfp-basecolor')
					};

					options['maxValue'] = options['numStars'];

                    if ($self.data('rsfp-halfstar'))
					{
						options['halfStar'] = true;
					}
					else
					{
                        options['fullStar'] = true;
					}

					if ($self.data('rsfp-ratingtype') === 'multicolor')
					{
						options['multiColor'] = {
							"startColor": $self.data('rsfp-startcolor'),
							"endColor"  : $self.data('rsfp-endcolor')
						};
					}
					else
					{
                        options['ratedFill'] = $self.data('rsfp-fillcolor');
					}
					$self.rateYo(options);
					$self.on('rateyo.set', function (e, data) {
						var input = document.getElementById($self.attr('id') + '-value');
						input.value = data.rating;
						RSFormPro.triggerEvent(input, 'change');
					});
				break;

				case 'datedropper':
					//set defaults
					options = {
						dropPrimaryColor   : $self.data('rsfp-primary-color'),
						dropTextColor      : $self.data('rsfp-text-color'),
						dropBackgroundColor: $self.data('rsfp-background-color'),
						dropBorder         : $self.data('rsfp-border'),
						dropBorderRadius   : $self.data('rsfp-border-radius'),
						dropShadow         : $self.data('rsfp-dropshadow'),
						dropWidth          : $self.data('rsfp-dropwidth'),
						dropTextWidth      : 500,
						animate            : true,
						init_animation     : $self.data('rsfp-init-animation'),
						format             : $self.data('rsfp-format'),
						lang               : $self.data('rsfp-lang'),
						lock               : $self.data('rsfp-lock'),
						minYear            : $self.data('rsfp-minyear'),
						maxYear            : !isNaN(parseInt($self.data('rsfp-maxyear'))) ? $self.data('rsfp-maxyear') : new Date().getFullYear(),
						yearsRange         : $self.data('rsfp-yearsrange')
					};

					$self.dateDropper(options);

                    $self[0].rsfpGetValue = function() {
                    	if ($self[0].getAttribute('data-rsfp-unixtimestamp'))
						{
							return $self[0].getAttribute('data-rsfp-unixtimestamp').toString();
						}

                        return '0';
                    };
				break;

				case 'timedropper':
					//set defaults
					options = {
						primaryColor   : $self.data('rsfp-primary-color'),
						textColor      : $self.data('rsfp-text-color'),
						backgroundColor: $self.data('rsfp-background-color'),
						borderColor    : $self.data('rsfp-border-color'),
						init_animation : $self.data('rsfp-init-animation'),
						format         : $self.data('rsfp-format'),
						meridians      : $self.data('rsfp-meridians'),
						setCurrentTime : $self.data('rsfp-setcurrenttime')
					};

					$self.timeDropper(options);

                    $self[0].rsfpGetValue = function() {
                        if ($self[0].getAttribute('data-rsfp-unixtimestamp'))
                        {
                            return $self[0].getAttribute('data-rsfp-unixtimestamp').toString();
                        }

                        return '0';
                    };
				break;
			}
		});

		// if calendar exists check if thy have date modifiers set (next and previous attributes)
		RSFormPro.AdvancedFormFields.checkPickers();
	},

	setMin: function (other_calendar_id, selected_date, offset) {
		if (typeof RSFormPro.AdvancedFormFields.datepickers[other_calendar_id] !== 'undefined') {
			var other_calendar = RSFormPro.AdvancedFormFields.datepickers[other_calendar_id].pickadate('picker');

			// transform the offset in milliseconds
			offset = 86400000 * offset;
			var min_seconds = (typeof selected_date === 'object' ? selected_date.select : selected_date) + offset;

			// verify that the other calendars doesn't have a min date bigger the the result one
			var other_calendar_min = RSFormPro.AdvancedFormFields.datepickers[other_calendar_id].data('rsfp-min');//other_calendar.get('min');
			other_calendar_min = other_calendar_min.length == 0 ? false : new Date(other_calendar_min);

			if (other_calendar_min) {
				other_calendar_min = other_calendar_min.getTime();
			}

			var ref_min = false;
			var selected = other_calendar.get('select');
			if (!other_calendar_min || min_seconds >= other_calendar_min) {
				other_calendar.set('min', new Date(min_seconds));
				ref_min = min_seconds;
			} else if (other_calendar_min) {
				other_calendar.set('min', new Date(other_calendar_min));
				ref_min = other_calendar_min;
			}

			if (ref_min && ref_min > selected.pick) {
				other_calendar.clear();
			}
		}
	},

	setMax: function (other_calendar_id, selected_date, offset) {
		if (typeof RSFormPro.AdvancedFormFields.datepickers[other_calendar_id] !== 'undefined') {
			var other_calendar = RSFormPro.AdvancedFormFields.datepickers[other_calendar_id].pickadate('picker');

			// transform the offset in milliseconds
			offset = 86400000 * offset;
			var max_seconds = (typeof selected_date === 'object' ? selected_date.select : selected_date) + offset;

			// verify that the other calendars doesn't have a max date smaller the the result one
			var other_calendar_max = RSFormPro.AdvancedFormFields.datepickers[other_calendar_id].data('rsfp-max');//other_calendar.get('min');
			other_calendar_max = other_calendar_max.length == 0 ? false : new Date(other_calendar_max);

			if (other_calendar_max) {
				other_calendar_max = other_calendar_max.getTime();
			}

			var ref_max = false;
			var selected = other_calendar.get('select');
			if (!other_calendar_max || max_seconds <= other_calendar_max) {
				other_calendar.set('max', new Date(max_seconds));
				ref_max = max_seconds;
			} else if (other_calendar_max) {
				other_calendar.set('max', new Date(other_calendar_max));
				ref_max = other_calendar_max;
			}
			
			if (ref_max && ref_max < selected.pick) {
				other_calendar.clear();
			}
		}
	},

	getDateArray: function(date) {
		date = date.split('-');

		var year = parseInt(date[0]);
		var month = parseInt(date[1]) - 1;
		var day = parseInt(date[2]);

		return [year, month, day];
	},

    limitSelections: function(formId, field, max) {
        RSFormProUtils.addEvent(window, 'load', function() {
            var fields = RSFormPro.getFieldsByName(formId, field);
            var objects = [];
            var i;
            var tagName;

            if (!fields || !fields.length) {
				return;
			}

			for (i = 0; i < fields.length; i++) {
                tagName = fields[i].tagName || fields[i].nodeName;
                tagName = tagName.toUpperCase();

                if (tagName === 'INPUT' && fields[i].type && fields[i].type.toUpperCase() === 'CHECKBOX' && !fields[i].disabled) {
                    objects.push(fields[i]);
				}
			}

            if (!objects.length) {
                return;
            }

            function limitSelections() {
                var values = RSFormProUtils.getChecked(objects);

                // Remove disabled attribute
                RSFormProUtils.remAttr(objects, 'disabled');

                // Remove disabled class
                for (var j = 0; j < objects.length; j++) {
                    if (RSFormProUtils.hasClass(objects[j].parentNode, 'fp-checkbox')) {
                        RSFormProUtils.removeClass(objects[j].parentNode, 'disabled');
                    }
                }

                if (values && values.length > 0 && values.length >= max) {
                    var unchecked = RSFormProUtils.getUnchecked(objects);
                    RSFormProUtils.setAttr(unchecked, 'disabled', true);

                    // Add disabled class
                    for (var k = 0; k < unchecked.length; k++) {
                        if (RSFormProUtils.hasClass(unchecked[k].parentNode, 'fp-checkbox')) {
                            RSFormProUtils.addClass(unchecked[k].parentNode, 'disabled');
                        }
                    }
                }
            }

            for (i = 0; i < objects.length; i++) {
                RSFormProUtils.addEvent(objects[i], 'change', limitSelections);
            }

            limitSelections();
        });
    },
	isChecked: function(formId, name, value) {
		var form = RSFormPro.getForm(formId);

		if (typeof form != 'undefined')
		{
			for (var i=0; i<form.elements.length; i++)
			{
				var element = form.elements[i];
				var tagName = element.tagName || element.nodeName;

				if (tagName == 'INPUT' && RSFormProUtils.hasClass(element, 'rsform-switcher-box'))
				{
					if (!element.name || element.name != 'form[' + name + '][]') continue;
					if ((value == 1 && element.checked == true) || (value == 0 && element.checked == false))
					{
						return true;
					}
					else
					{
						return false;
					}
				}
			}
		}

		return RSFormPro.AdvancedFormFields.isCheckedBackup(formId, name, value);
	},

	checkPickers: function() {
		jQuery.each(RSFormPro.AdvancedFormFields.datepickers,function(calendar_id, calendar_instance){
			// detect if the calendar has a data value
			var current_calendar = jQuery('#'+calendar_id);
			// use the data value, as this one is the standard format
			var current_date = current_calendar.data('value');

			if (typeof current_date !== 'undefined') {
				// convert the current_date in milliseconds
				current_date = new Date(current_date);
				current_date = current_date.getTime();

				var offset = typeof current_calendar.data('rsfp-offset') === 'undefined' ? 1 :current_calendar.data('rsfp-offset');

				var other_calendar_id_next = current_calendar.data('rsfp-next');
				var other_calendar_id_previous = current_calendar.data('rsfp-previous');

				// check if the calendar has a next defined
				if (typeof other_calendar_id_next !== 'undefined') {
					RSFormPro.AdvancedFormFields.setMin(other_calendar_id_next, current_date, offset);
				}

				// check if the calendar has a previous defined
				if (typeof other_calendar_id_previous !== 'undefined') {
					RSFormPro.AdvancedFormFields.setMax(other_calendar_id_previous, current_date, offset);
				}
			}
		});
	}
};

if ( typeof jQuery !== 'undefined' ){
    jQuery(document).ready(RSFormPro.AdvancedFormFields.initiate);
}