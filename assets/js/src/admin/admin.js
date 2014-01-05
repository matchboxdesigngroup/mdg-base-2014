/* global pagenow */
// @codekit-prepend "../plugins/chosen.jquery.js"
// @codekit-prepend "../plugins/cleditor/jquery.cleditor.js"
// @codekit-prepend "../plugins/cleditor/jquery.cleditor.min.js"
// @codekit-prepend "meta-upload.js"
jQuery((function($) {
	var Meta   = {},
			Alerts = {}
	;

	/**
	 * Sets up the chosen select
	 *
	 * @return Void
	 */
	Meta.setupChosen = function() {
		var chosenElem = $(".mdg-chosen-select");

		if ( chosenElem === 0 ) {
			return false;
		} // if()

		chosenElem.chosen({
			allow_single_deselect    : true,
			disable_search_threshold : 5
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

		datePicker.datepicker({
			dateFormat  : 'DD, MM d, yy',
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
				// a callback to fire whenever the color changes to a valid color
				change       : function(event, ui) {},
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
	 * Sets up the WYWSIG Editor meta.
	 *
	 * @return Void
	 */
	Meta.setupWyswigEditor = function() {
		var editor = $('.mdg-wyswig-editor');

		if ( editor.length === 0 ) {
			return false;
		} // if()

		editor.cleditor();
	}; // Meta.setupWyswigEditor()

	/**
	 * Initializes all meta.
	 *
	 * @return Void
	 */
	Meta.init = function() {
		Meta.setupWyswigEditor();
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
				function( return_html ) {
					trigger.after(
						'<p class="mdg-image-reference"><a href="#" id="hide-image-grid-reference">hide image sizes</a></p>' +
						'<p class="mdg-image-reference">please note that image sizes may be smaller to fit into your screen</p>'
					);

					return_html = '<div class="mdg-image-reference">' +
													return_html +
													'<div style="clear:both"></div>' +
												'</div>';

					$('.image-size-reference').empty().append( return_html );

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