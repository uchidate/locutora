/*

 Based on jQuery Fullscreen Editor v1.0
 Fullscreen text editor plugin for jQuery.

 For more details visit http://github.com/burakson/fseditor

 - Burak Son <hello@burakson.com>
 - http://github.com/burakson

 Licensed under MIT - http://opensource.org/licenses/MIT

*/
(function($) {
    "use strict";

    var isFullscreen = false,
		isPlaceholderDestroyed = false,
		transitionDuration = 300;

    var $defaults = {
		overlay: true,
		expandOnFocus: false,
		transition: 'fade',
		placeholder: '',
		maxWidth: '',
		maxHeight: '',
		onExpand: function() {},
		onMinimize: function() {}
	};

    function FSEditor($element, $options) {
		this.element = $element;
		this.settings = $.extend({}, $defaults, $options);

		this.init();
	}

	function relocate(el) {
    	var $window = $(window);
		var yPos = 0|((($window.height() - el.height()) / 2));
		var xPos = 0|(($window.width() - el.width()) / 2);
		el.css({
			'top' : yPos,
			'left': xPos
		});
	}



	FSEditor.prototype = {
    	init: function() {
			var settings = this.settings;
			var self = this;

			var $el = $(this.element);
			if (!$el.is('textarea')) {
				$.error('Error initializing FSEditor Plugin. It can only work on <textarea> element.');
				return;
			}

			var $elementValue = ($.trim($el.val()) !== '' ? $el.val() : '');
			$el.hide();

			var content = '<div class="fs-editor-wrapper">\
                     <div class="fs-editor"><a href="#" class="fs-icon"></a>\
                     <div class="fs-editable" contenteditable="true"></div>\
                     </div></div>';

			var $insertContent = $(content).insertAfter($el);
			var $editor        = $insertContent.find('.fs-editor');
			var $editable      = $editor.find('.fs-editable');
			var $icon          = $editor.find('.fs-icon');

			this.$editor = $editor;
			this.$editable = $editable;
			this.$icon = $icon;

			// add height of the original element as min-height for non-fullscreen mode
			$editable.css('min-height', $el.css('height'))
				.parent('.fs-editor-wrapper')
				.css('min-height', $el.css('height'));

			// ESC = closes the fullscreen mode
			$($editable).on('keyup.fseditor', function(e) {
				self.setValue();

				if (e.keyCode === 27 && isFullscreen) {
					self.minimize();
				}
			});

			// open the fullscreen mode when user focuses on editor
			if (settings.expandOnFocus) {
				$editable.on("focus.fseditor", function() {
					self.expand();
				});
			}

			// fullscreen icon click event
			$icon.on('click.fseditor.icon', function(e) {
				e.preventDefault();
				isFullscreen ? self.minimize() : self.expand();
			});

			// add placeholder unless it has a value
			if (settings.placeholder && $el.val() === ''){
				this.placeholder();
			} else if ($el.val() !== '') {
				$editable.html($elementValue.replace(/[\r\n]/gi, '<br>'));
			}

			return this;
		},
		placeholder: function() {
    		var settings = this.settings;
    		var $editable = this.$editable;

			if (typeof settings.placeholder === 'string') {
				$editable.addClass('placeholder')
					.html(settings.placeholder)
					.on({
						focus: function() {
							if (!isPlaceholderDestroyed && $editable.html() === settings.placeholder) {
								$editable.html('')
									.removeClass('placeholder');
							}
						},
						blur: function() {
							if (!isPlaceholderDestroyed && $editable.html() === '') {
								$editable.html(settings.placeholder)
									.addClass('placeholder');
							}
						}
					});

				return this;
			}
		},
		setValue: function() {
    		var $editable = this.$editable;
			var $el = $(this.element);
			var parse = $editable.html()
				.replace(/<div>/gi, '')
				.replace(/<br>/gi, '')
				.replace(/<\/div>/gi, String.fromCharCode(13) + String.fromCharCode(10));
			$el.val(parse === this.settings.placeholder ? '' : parse);

			return $el.val();
		},
		minimize: function() {
			$(window).off('resize.fseditor');

			var $editor = this.$editor;
			var settings = this.settings;

			$editor.removeClass('expanded transition-'+ settings.transition)
				.css({
					'max-width' : 'none',
					'max-height': 'none'
				});
			if (settings.transition === 'fade') {
				$editor.fadeTo(0, 0);
			}
			if (settings.overlay) {
				this.removeOverlay();
			}
			this.fx(settings.transition);

			return this;
		},
		expand: function() {
    		var settings = this.settings;
    		var $editor = this.$editor;
			if (settings.transition === 'fade') {
				$editor.fadeTo(0, 0);
			}

			settings.maxWidth  ? $editor.css('max-width',  settings.maxWidth) : '';
			settings.maxHeight ? $editor.css('max-height', settings.maxHeight) : '';
			if (settings.overlay) {
				this.showOverlay();
			}

			$(window).on('resize.fseditor', function() {
				relocate($editor);
			});

			$editor.addClass('expanded transition-'+ settings.transition);
			this.fx(settings.transition);

			return this;
		},
		showOverlay: function() {
			var self = this;

			$('<div class="fs-editor-overlay" />').appendTo('body')
				.fadeTo(this.settings.transition === '' ? 0 : transitionDuration, 1)
				.click(function() { self.minimize(); });

			return this;
		},
		removeOverlay: function() {
			var $overlay = $('.fs-editor-overlay');
			var settings = this.settings;

			if ($overlay.length) {
				$overlay.fadeTo(settings.transition === '' ? 0 : transitionDuration, 0, function() {
					$(this).remove();
				});
			}

			return this;
		},
		destroy: function() {
    		var $el = $(this.element);

			this.removeOverlay();

			$el.show()
				.nextAll('.fs-editor-wrapper')
				.remove();

			$(window).off('keyup.fseditor').off('resize.fseditor');

			return this;
		},


		// Transitions
		// ---------------------------------------------------------------------------------
		fx: function(t) {
			var $editor = this.$editor;

			relocate($editor);

			switch (t) {
				case 'fade':
					(isFullscreen ? this.fadeComplete('minimize') : $editor.fadeTo(transitionDuration, 1, this.fadeComplete('expand')));
					break;

				case 'slide-in':
					(isFullscreen ? this.slideInComplete('minimize') : this.slideInComplete('expand'));
					break;

				default:
					(isFullscreen ? this.noTransition('minimize') : this.noTransition('expand'));
					break;
			}
		},

		noTransition: function(e) {
    		var settings = this.settings;
    		var $editable = this.$editable;
    		var $editor = this.$editor;

			if (e === 'expand') {
				if (!settings.placeholder) {
					$editable.focus();
				}
				$editor.css('opacity', 1);
				isFullscreen = true;
				settings.onExpand.call(this);
			} else if (e === 'minimize') {
				if (!settings.placeholder) {
					$editable.focus();
				}
				isFullscreen = false;
				settings.onMinimize.call(this);
			}
		},

		fadeComplete: function(e) {
			var settings = this.settings;
			var $editable = this.$editable;
			var $editor = this.$editor;

			if (e === 'expand') {
				if (!settings.placeholder) {
					$editable.focus();
				}
				isFullscreen = true;
				settings.onExpand.call(this);
			} else if(e === 'minimize') {
				$editor.fadeTo(0, 1);
				if (!settings.placeholder) {
					$editable.focus();
				}
				isFullscreen = false;
				settings.onMinimize.call(this);
			}
		},

		slideInComplete: function(e) {
			var settings = this.settings;
			var $editor = this.$editor;

			if (e === 'expand') {
				$editor.css({'top': -999, opacity: 1})
					.animate({top: 0|((($(window).height() - $editor.height()) / 2))}, transitionDuration);
				isFullscreen = true;
				settings.onExpand.call(this);
			}
			else if (e === 'minimize')
			{
				$editor.animate({top:-999}, transitionDuration);
				isFullscreen = false;
				settings.onMinimize.call(this);
			}
		}
	};

	// Plugin wrapper
	// ---------------------------------------------------------------------------------------
	var $plugin_name = 'fseditor';
	$.fn[$plugin_name] = function ($options) {
		var $plugin;

		this.each(function () {
			$plugin = $.data(this, $plugin_name);

			if (!$plugin) {
				$plugin = new FSEditor(this, $options);
				$.data(this, $plugin_name, $plugin);
			}
		});

		return $plugin;
	};
})(jQuery, window, document);
