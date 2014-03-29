/* global MDG_GLOBALS */
/* global Modernizr */

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
				xxsMax  : (480 - 1),  // xx-small screen
				xsMin   : 480,        // x-small screen
				smMin   : 768,        // small screen / tablet
				mdMin   : 992,        // medium screen / desktop
				lgMin   : 1200,       // large screen / wide desktop
				xsMax   : (768 - 1),  // screen-sm-min - 1
				smMax   : (992 - 1),  // screen-md-min - 1
				mdMax   : (1200 - 1), // screen-lg-min - 1
				classes : {
					xxs : 'bp-screen-xxs',
					xs  : 'bp-screen-xs',
					sm  : 'bp-screen-sm',
					md  : 'bp-screen-md',
					lg  : 'bp-screen-lg'
				}
			}
	;

	bp.mediaQueriesSupported = function() {
		// Dependent on Modernizr and MEdia Query browser support
		if ( typeof Modernizr !== 'object' || ! Modernizr.mq('only all') ) {
			return false;
		} // if()

		return true;
	}; // if()

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
	 * Min width check like @media (min-width:...
	 *
	 * @param mediaSize Min device width.
	 */
	bp.min = function( mediaSize ) {
		if ( ! bp.mediaQueriesSupported() ) {
			return false;
		} // if()

		return Modernizr.mq('(min-width: ' + mediaSize + ')');
	}; // bp.min()

	/**
	 * Max width check like @media (max-width:...
	 *
	 * @param mediaSize Max device width.
	 */
	bp.max = function( mediaSize ) {
		if ( ! bp.mediaQueriesSupported() ) {
			return false;
		} // if()

		return Modernizr.mq('(max-width: ' + mediaSize + ')');
	}; // bp.max()

	/**
	 * Min/Max check like @media (min-width: min) and (max-width: max)...
	 *
	 * @param min Min device width.
	 * @param max Max device width.
	 */
	bp.minMax = function( min, max ) {
		if ( ! bp.mediaQueriesSupported() ) {
			return false;
		} // if()

		return Modernizr.mq('(min-width: ' + min + ') and (max-width: ' + max + ')');
	}; // bp.minMax()

	/**
	 * Checks if current screen width is a xx-small screen.
	 *
	 * @return {Boolean} If current screen width is a xx-small screen.
	 */
	bp.isScreenXXS = function () {
		var isScreenXXS = bp.max(bp.xxsMax + 'px');

		if ( isScreenXXS ) {
			bp.applyHtmlClass(bp.classes.xxs);
		} // if()
		return isScreenXXS;
	}; // bp.isScreenXS()

	/**
	 * Checks if current screen width is a x-small screen.
	 *
	 * @return {Boolean} If current screen width is a x-small screen.
	 */
	bp.isScreenXS = function () {
		var isScreenXS = bp.minMax(bp.xsMin + 'px', bp.xsMax + 'px');

		if ( isScreenXS ) {
			bp.applyHtmlClass(bp.classes.xs);
		} // if()
		return isScreenXS;
	}; // bp.isScreenXS()

	/**
	 * Checks if current screen width is a small screen.
	 *
	 * @return {Boolean} If current screen width is a small screen.
	 */
	bp.isScreenSm = function () {
		var isScreenSm = bp.minMax( bp.smMin + 'px', bp.smMax + 'px');
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
		var isScreenMd = bp.minMax( bp.mdMin + 'px', bp.mdMax + 'px');
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
		var isScreenLg = bp.min(bp.lgMin + 'px');
		if ( isScreenLg ) {
			bp.applyHtmlClass(bp.classes.lg);
		} // if()

		return isScreenLg;
	}; // bp.isScreenLg()

	/**
	 * Runs all of the breakpoint checks.
	 *
	 * @return {Void}
	 */
	bp.check = function() {
		if ( ! bp.mediaQueriesSupported() ) {
			return;
		} // if()

		var isScreenXXS = bp.isScreenXXS();
		var isScreenXS  = bp.isScreenXS();
		var isScreenSm  = bp.isScreenSm();
		var isScreenMd  = bp.isScreenMd();
		var isScreenLg  = bp.isScreenLg();

		// Remove the class if something goes wrong or not supported
		if ( ! isScreenXXS && ! isScreenXS && ! isScreenSm && ! isScreenMd && ! isScreenLg ) {
			bp.applyHtmlClass('');
		} // if()
	};

	/**
	 * Document Ready
	 */
	$(document).ready(function(){
		bp.check();
	});

	/**
	 * Window Resize.
	 * $(window).resizeEnd() requires jQuery.resizeEnd.js to be included in Grunt uglify configuration.
	 */
	if ( typeof $(window).resizeEnd === 'function' ) {
		$(window).resizeEnd(function() {
			bp.check();
		});
	} else {
		$(window).resize(function() {
			bp.check();
		});
	} // if/else()

	MDG_GLOBALS.bp = bp;
})(jQuery));