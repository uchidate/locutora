/**
 * jQuery File:    formplate.js
 * Type:            plugin
 * Author:            Chris Humboldt
 * Last Edited:    1 October 2014
 */


// Plugin
;(function ($, window, document, undefined) {
	// Plugin setup & settings
	var $plugin_name = 'formplate', $defaults =
	{};

	// The actual plugin constructor
	function Plugin($element, $options) {
		this.element = $element;
		this.settings = $.extend({}, $defaults, $options);
		this._defaults = $defaults;
		this._name = $plugin_name;

		// Initialize plugin
		this.init();
	}

 
	// Plugin
	// ---------------------------------------------------------------------------------------
	Plugin.prototype =
	{
		init: function () {
			// Execute
			// ---------------------------------------------------------------------------------------
			// Setup
			this.setup_formplate();
		},

		// Public functions
		// ---------------------------------------------------------------------------------------
		setup_formplate: function () {
			var $toggler = $('.formplate input[type="checkbox"].toggler');
			if ($toggler.length)
			{
				RSFormPro.AdvancedFormFields.isCheckedBackup = RSFormPro.isChecked;
				RSFormPro.isChecked = RSFormPro.AdvancedFormFields.isChecked;
			}

			$toggler.each(function () {
				// Wrap input
				$(this).wrap('<span class="fp-toggler"></span>');

				// Trigger change event
				RSFormPro.triggerEvent(this, 'change');
			});

			// Checkboxes
			$('.formplate input[type="checkbox"].rsform-advcheckbox').each(function () {
				// Wrap input
				$(this).wrap('<span class="fp-checkbox"></span>');

				// Check state
				if ($(this).is(':checked')) {
					$(this).parents('.fp-checkbox').addClass('checked');
				}

                if ($(this).is(':disabled')) {
                    $(this).parents('.fp-checkbox').addClass('disabled');
                }
			});

			// Add handle to togglers
			$('.fp-toggler').prepend('<span class="handle"></span>');

			// Radio inputs
			$('.formplate input[type="radio"].rsform-advradio').each(function () {
				// Wrap input
				$(this).wrap('<span class="fp-radio"></span>');

				// Check state
				if ($(this).is(':checked')) {
					$(this).parents('.fp-radio').addClass('checked');
				}

                if ($(this).is(':disabled')) {
                    $(this).parents('.fp-radio').addClass('disabled');
                }
			});
		}
	};


	// Global calls
	// ---------------------------------------------------------------------------------------
	// Change events
	// Styled Radio.
	$(document).on('change', '.formplate input[type="radio"]', function () {
		if ($(this).is(':checked')) {
			// Check for all other similarly named elements
			var $radio_name = $(this).attr('name');
			$('input[name="' + $radio_name + '"]').parents('.fp-radio').removeClass('checked');

			// Check this one
			$(this).parents('.fp-radio').addClass('checked');
		} else {
			// Uncheck this one
			$(this).parents('.fp-radio').removeClass('checked');
		}
	});

	// Switch - when the input is changed, adjust the parent's class.
	$(document).on('change', '.formplate input[type="checkbox"].toggler', function () {
		var parent = $(this).parents('.fp-toggler');
		parent.find('input[type="hidden"]').remove();
		if ($(this).is(':checked')) {
			parent.addClass('checked');
		} else {
			var input = document.createElement('input');
			input.setAttribute('type', 'hidden');
			input.setAttribute('name', this.getAttribute('name'));
			input.setAttribute('value', '0');
			parent.append(input);
			parent.removeClass('checked');
		}
	});

	// Styled Checkbox - when the input is changed the parent's class should be adjusted.
	$(document).on('change', '.formplate input[type="checkbox"].rsform-advcheckbox', function () {
		if ($(this).is(':checked')) {
			$(this).parents('.fp-checkbox').addClass('checked');
		} else {
			$(this).parents('.fp-checkbox').removeClass('checked');
		}
	});


	// Plugin wrapper
	// ---------------------------------------------------------------------------------------
	$.fn[$plugin_name] = function ($options) {
		var $plugin;

		this.each(function () {
			$plugin = $.data(this, 'plugin_' + $plugin_name);

			if (!$plugin) {
				$plugin = new Plugin(this, $options);
				$.data(this, 'plugin_' + $plugin_name, $plugin);
			}
		});

		return $plugin;
	};
})(jQuery, window, document);