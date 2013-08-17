/* Author: Matchbox Design Group */
// @codekit-prepend "vendor/imagesloaded.js"
// @codekit-prepend "vendor/plugin.js"
// @codekit-prepend "vendor/jquery.flexslider.js"
jQuery(function(){
	var generic = {},
			navMenu = {}
	;

	/**
	 * Initializes the primary drop down menu to make it work
	 * on hover instead of the default Bootstrap on click
	 *
	 * @return boolean
	 */
	navMenu.initDropDownMenu = function( dropdown ) {
		dropdown = (typeof dropdown === "undefined") ? $('.dropdown') : dropdown;

		// Activate Drop Down on Toggle
		dropdown.on('mouseover', function () {
			$(this).addClass('open');
		}).on('mouseout', function(){
			$(this).removeClass('open');
		});

		return false;
	}; // initDropDownMenu()

	// Window Load
	$(window).load(function(){
		navMenu.initDropDownMenu();
	}); // $(window).load()
}($));