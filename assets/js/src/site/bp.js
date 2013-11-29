/* global MDG_GLOBALS */
/**
 * Handles checking what size the window is and applies a class to  the HTML element.
 * Also applies all methods and properties to MDG_Globals.bp
 * .bp-screen-xs X-small screen
 * .bp-screen-sm Small screen / tablet
 * .bp-screen-md Medium screen / desktop
 * .bp-screen-lg Large screen / wide desktop
 */
jQuery((function($){
	var bp = {
				xsMin   : 480,				// X-Small screen
				smMin   : 768,				// Small screen / tablet
				mdMin   : 992,				// Medium screen / desktop
				lgMin   : 1200,				// Large screen / wide desktop
				xsMax   : (768 - 1),	// screen-sm-min - 1
				smMax   : (992 - 1),	// screen-md-min - 1
				mdMax   : (1200 - 1),	// screen-lg-min - 1
				classes : {
					xs: 'bp-screen-xs',
					sm: 'bp-screen-sm',
					md: 'bp-screen-md',
					lg: 'bp-screen-lg'
				}
			}
	;


	/**
	 * Applies the current bp-{size} class and removes all others
	 *
	 * @param  {string} newClass The class to apply.
	 *
	 * @return {boolean}         false
	 */
	bp.applyHtmlClass = function(newClass) {
		if (typeof bp.testElem === 'undefined') {
			bp.testElem = $('html');
		} // if()

		// Remove any current class
		$.each( bp.classes, function(index, val) {
			if ( val !== newClass ) {
				bp.testElem.removeClass(val);
			} // if()
		});

		// Add new class
		bp.testElem.addClass(newClass);

		return false;
	}; // bp.applyHtmlClass()



	/**
	 * Sets bp.testElem = jQuery selector for the test element if not already defined.
	 */
	bp.getTestElemWidth = function() {
		if (typeof bp.testElem === 'undefined') {
			bp.testElem = $('html');
		} // if()

		return parseInt( bp.testElem.css('width').replace('px', ''), 10);
	}; // bp.setTestElem()



	/**
	 * Min width check like @media (min-width:...
	 *
	 * @param screenSize Min device width.
	 */
	bp.min = function( screenSize ) {
		screenSize = parseInt( screenSize, 10);
		return screenSize <= bp.getTestElemWidth();
	}; // bp.min()



	/**
	 * Max width check like @media (max-width:...
	 *
	 * @param screenSize Max device width.
	 */
	bp.max = function( screenSize ) {
		screenSize = parseInt( screenSize, 10);
		return screenSize >= bp.getTestElemWidth();
	}; // bp.max()



	/**
	 * Min/Max check like @media (min-width: min) and (max-width: max)...
	 *
	 * @param min Min device width.
	 * @param max Max device width.
	 */
	bp.minMax = function( min,max ) {
		min   = parseInt( min, 10);
		max   = parseInt( max, 10);
		var width = bp.getTestElemWidth();

		return ( min <= width && max >= width );
	}; // bp.minMax()



	/**
	 * Checks if current screen width is a x-small screen.
	 *
	 * @return {Boolean} If current screen width is a x-small screen.
	 */
	bp.isScreenXs = function () {
		var isScreenXs = bp.max(bp.xsMax);

		if ( isScreenXs ) {
			bp.applyHtmlClass(bp.classes.xs);
		} // if()
		return isScreenXs;
	}; // bp.isScreenXs()



	/**
	 * Checks if current screen width is a small screen.
	 *
	 * @return {Boolean} If current screen width is a small screen.
	 */
	bp.isScreenSm = function () {
		var isScreenSm = bp.minMax( bp.smMin, bp.smMax);
		if ( isScreenSm ) {
			bp.applyHtmlClass(bp.classes.sm);
		} // if()

		return isScreenSm;
	}; // bp.isScreenSm()



	/**
	 * Checks if current screen width is a medium screen.
	 *
	 * @return {Boolean} If current screen width is a medium screen.
	 */
	bp.isScreenMd = function () {
		var isScreenMd = bp.minMax( bp.mdMin, bp.mdMax);
		if ( isScreenMd ) {
			bp.applyHtmlClass(bp.classes.md);
		} // if()

		return isScreenMd;
	}; // bp.isScreenMd()



	/**
	 * Checks if current screen width is a large screen.
	 *
	 * @return {Boolean} If current screen width is a large screen.
	 */
	bp.isScreenLg = function () {
		var isScreenLg = bp.min(bp.lgMin);
		if ( isScreenLg ) {
			bp.applyHtmlClass(bp.classes.lg);
		} // if()

		return isScreenLg;
	}; // bp.isScreenLg()



	/**
	 * Runs all of the breakpoint checks.
	 *
	 * @return Void
	 */
	bp.check = function() {
		bp.isScreenXs();
		bp.isScreenSm();
		bp.isScreenMd();
		bp.isScreenLg();
	};



	/**
	 * Document Ready
	 */
	$(document).ready(function(){
		bp.check();
	});



	/**
	 * Window Resize.
	 * Resize end requires /assets/js/src/plugins/jQuery.resizeEnd.js
	 * to be included if it is not included change resizeEnd to resize.
	 */
	$(window).resizeEnd(function() {
		bp.check();
	});

	MDG_GLOBALS.bp = bp;
})(jQuery));