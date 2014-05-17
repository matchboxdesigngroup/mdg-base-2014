/* global pagenow */
jQuery((function($) {
	var Meta   = {},
			Alerts = {}
	;

	Meta.changeChosen = function(e){
		// this updates the hidden text box that holds selections
		var chosenElem = $('#' + e.currentTarget.id).val(),
				select_id  = e.currentTarget.id.replace('_multi_chosen', ''),
				textField  = $("#" + select_id)
		;
		textField.val(chosenElem);
	}; // MEta.changeChosen()

	/**
	 * Sets up the chosen select
	 *
	 * @return Void
	 */
	Meta.setupChosen = function() {
		var chosenElem = $('.mdg-chosen-select');

		if ( chosenElem === 0 ) {
			return false;
		} // if()

		chosenElem.chosen({
			allow_single_deselect    : true,
			disable_search_threshold : 5
		});

		chosenElem.chosen().change(function(e){
			Meta.changeChosen(e);
		});
	}; // Meta.setupChosen()

	/**
	 * Sets up the meta date picker.
	 *
	 * @return Void
	 */
	Meta.setupDatepicker = function() {
		var datePicker = $('.mdg-datepicker');

		if ( datePicker.length === 0 ) {
			return false;
		} // if()

		var dateFormat = datePicker.data('format');
		console.log(dateFormat);
		dateFormat = (typeof dateFormat === 'undefined' || dateFormat === '' ) ? 'DD, MM d, yy' : dateFormat;
		datePicker.datepicker({
			dateFormat  : dateFormat,
			changeMonth : true,
			changeYear  : true
		});
	}; // Meta.setupDatepicker()

	/**
	 * Sets up the meta color picker.
	 *
	 * @return Void
	 */
	Meta.setupColorPicker = function() {
		var colorPicker = $('.mdg-color-picker');

		if ( colorPicker.length === 0 ) {
			return false;
		} // if()

		var options = {
			// you can declare a default color here,
			// or in the data-default-color attribute on the input
			defaultColor : false,
			// a callback to fire whenever the color changes to a valid color(optional args event, ui)
			change       : function() {},
			// a callback to fire when the input is emptied or an invalid color
			clear        : function() {},
			// hide the color picker controls on load
			hide         : true,
			// show a group of common colors beneath the square
			// or, supply an array of colors to customize further
			palettes     : true
		};
		colorPicker.wpColorPicker( options );
	}; // Meta.setupColorPicker()


	/**
	 * Initializes all meta.
	 *
	 * @return Void
	 */
	Meta.init = function() {
		Meta.setupChosen();
		Meta.setupDatepicker();
		Meta.setupColorPicker();
	}; // Meta.init()

	/**
	 * Adds an alert for all image sizes
	 *
	 * @todo make this work better.
	 *
	 * @return boolean false
	 */
	Alerts.getImageReferenceGrid = function() {
		if ( pagenow !== 'upload' ) {
			return false;
		} // if()

		$('h2').after( '<div class="updated"><p><a href="#" id="image-size-reference-trigger">View image size reference.</a></p></div><div class="image-size-reference"></div>' );

		var trigger = $('#image-size-reference-trigger');

		trigger.click(function() {
			$.get(
				ajaxurl,
				{ action : 'mdg-image-reference-grid' },
				function( returnHtml ) {
					trigger.after(
						'<p class="mdg-image-reference"><a href="#" id="hide-image-grid-reference">hide image sizes</a></p>' +
						'<p class="mdg-image-reference">please note that image sizes may be smaller to fit into your screen</p>'
					);

					returnHtml = '<div class="mdg-image-reference">' +
													returnHtml +
													'<div style="clear:both"></div>' +
												'</div>';

					$('.image-size-reference').empty().append( returnHtml );

					trigger.hide();

					$('#hide-image-grid-reference').click(function() {
						$('.mdg-image-reference').remove();
						trigger.show();
					});

				} // end success function
			);
		});

		return false;
	}; // Alerts.getImageReferenceGrid()

	/**
	 * Initializes all administrator alerts
	 *
	 * @return Void
	 */
	Alerts.init = function() {
		Alerts.getImageReferenceGrid();
	}; // Alerts.init()

	/**
	 * Document ready
	 */
	$(document).ready(function() {
		Meta.init();
		Alerts.init();
	}); // $(document).ready()
})(jQuery));

/**
 * Avoid `console` errors in browsers that lack a console.
 */
(function() {
	var method,
			noop    = function() {},
			methods = [
				'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
				'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
				'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
				'timeStamp', 'trace', 'warn'
			],
			length  = methods.length,
			console = ( window.console = window.console || {} )
	;

	while ( length-- ) {
		method = methods[length];

		// Only stub undefined methods.
		if (!console[method]) {
			console[method] = noop;
		}
	}
}());
