/** global MDG_GLOBALS */
/** global PIE */
jQuery((function($) {
	var site    = {};

	// Globals defined in scripts.php
	// bp      = MDG_GLOBALS.bp,
	// ajaxurl = MDG_GLOBALS.ajaxurl

	/**
	 * Initialize FlexSliders here
	 *
	 * @example http://flexslider.woothemes.com/
	 *
	 * @return boolean false
	 */
	site.initFlexslider = function() {
		if (typeof $.fn.flexslider !== 'function' ) {
			return;
		} // if()

		var slider = $('.flexslider');

		// Check if a slider exists
		if ( slider.length === 0 ) {
			return false;
		}

		return false;
	}; // site.initFlexslider()

	/**
	 * Initializes FitVid  jQuery plugin.
	 *
	 * @example http://fitvidsjs.com/
	 *
	 * @return  {Void}
	 */
	site.initFitVids = function() {
		if ( typeof $.fn.fitVids !== 'function' ) {
			return;
		} // if()

		$('.fitvid').fitVids();
	};

	/**
	 * Adding selectric jQuery plugin.
	 *
	 * @example http://lcdsantos.github.io/jQuery-Selectric/
	 *
	 * @return  {void}
	 */
	site.selectricInit = function() {
		if ( typeof $.fn.selectric !== 'function' ) {
			return;
		} // if()

		var selectElem = $('select');
		if ( selectElem.length === 0 ) {
			return;
		} // if()

		selectElem.selectric();

		if ( $('.selectricWrapper').length === 0 ) {
			selectElem.addClass('selectric-disabled');
			$('form').addClass('selectric-disabled-form');
		} // if()
	};

	/**
	 * Use for elements that need to be linked but should not be wrapped in a <a></a>
	 * Apply class faux-link to the element and a data attribute of data-link="{somelink}"
	 *
	 * @return Void
	 */
	site.initFauxLink = function() {
		$('.faux-link').on('click', function() {
			var that = $(this),
					location = that.data('link')
			;
			if ( location === undefined ) {
				location = '#';
			} // if()

			window.location = location;
		});
	}; // site.initFauxLink()

	/**
	 * Initializes the drop down menu
	 *
	 * @return Void
	 */
	site.initDropDownMenu = function() {
		// Activate Drop Down on hover non-touch devices
		$('.no-touch .dropdown').on('mouseover', function() {
			$(this).addClass('open');
		}).on('mouseout', function() {
			$(this).removeClass('open');
		});

		// Activate DropDown on click touch devices
		$('.touch .dropdown').on('click', function(e) {
			var that = $(this);

			if ( !that.hasClass('open') ) {
				that.addClass('open');
				e.preventDefault();
				return false;
			} // if()
		});
	}; // site.initDropDownMenu()

	/**
	 * Scrolls the page to the top of the provided element
	 *
	 * @param  {object}          elem            The jQuery selector object to scroll to.
	 * @param  {string}          [easing=linear] The easing used when scrolling.
	 * @param  {(string|number)} [speed=1500]    The speed to scroll.
	 * @param {number}           [offsetTop=10]  Offset above the top of the element to scroll to.
	 *
	 * @return boolean               false
	 */
	site.scollTo = function( elem, easing, speed, offsetTop ) {
		speed     = ( typeof speed === 'undefined' ) ? 1500 : speed;
		easing    = ( typeof easing === 'undefined' ) ? 'linear' : easing;
		offsetTop = ( typeof offsetTop === 'undefined' ) ? 10 : offsetTop;

		var offset = elem.offset().top - offsetTop;
		$('html,body').animate( { scrollTop : offset }, speed, easing );

		return false;
	}; // site.scollTo()

	/**
	 * Attaches CSS3Pie IE CSS3 helper.
	 *
	 * @return  {void}
	 */
	site.css3pieAttach = function() {
		if (window.PIE) {
			var PIE = window.PIE;
			$('.css3pie').each(function() {
				PIE.attach(this);
			});
		} // if()
	}; // site.css3pieAttach()

	/**
	 * Initializes the back to top button.
	 *
	 * @todo Possibly add parameters but we will see
	 *
	 * @return  {void}
	 */
	site.initBackToTop = function() {
		var pageTopLinkElem = $('.page-top-link');

		if ( pageTopLinkElem.length === 0 ) {
			return;
		} // if()

		pageTopLinkElem.click(function() {
			$(window.opera ? 'html' : 'html, body').stop(true, true).animate({ scrollTop : 0 }, 1500, 'easeInOutQuad');
			return false;
		});

		$(window).scroll(function() {
			if ($(window).scrollTop() > 150){
				pageTopLinkElem.stop(true, true).fadeIn(1000);
			} else {
				pageTopLinkElem.stop(true, true).fadeOut(1000);
			}
		});
	}; // site.initBackToTop()

	/**
	 * Affix an element on scroll.
	 * Requires Bootstrap affix plugin.
	 *
	 * @see http://getbootstrap.com/javascript/#affix
	 *
	 * @param {integer} topOffset Optional offset to above element to trigger, default 0.
	 * @param {object}  elem      Optional jQuery selector, defaults to .fix-elem
	 *
	 * @return Void
	 */
	site.affixElementTop = function(topOffset, elem) {
		elem = (typeof elem === 'undefined') ? $('.affix-elem') : elem;
		if ( elem.length === 0 ) {
			return false;
		} // if()

		if ( typeof elem.affix != 'function' ) {
			return false;
		} // if()

		topOffset = (typeof topOffset === 'undefined') ? 0 : topOffset;
		elem.each(function(index, el) {
			var that = $(el),
					top  = that.offset().top + topOffset
			;
			that.affix({
				offset : {
					top : top
				}
			});
		});

		return false;
	}; // site.affixElementTop()

	/**
	 * Initalizes sticky footer on pages shorter than the window height
	 *
	 * @return  {void}
	 */
	site.stickyFooterInit = function() {
		if ( $('html').outerHeight() < $(window).outerHeight() ) {
			$('body>.wrap').addClass('page-wrap');
			$('html,body').addClass('sticky-footer-wrap');
		} else {
			$('body>.wrap').removeClass('page-wrap');
			$('html,body').removeClass('sticky-footer-wrap');
		} // if/else()

		return;
	}; // site.stickyFooterInit()

	/**
	 * Document Ready
	 */
	$(document).ready(function() {
		site.initFauxLink();
		site.initDropDownMenu();
		site.css3pieAttach();
		site.initFitVids();
		site.selectricInit();
		site.stickyFooterInit();
		site.affixElementTop();
	});

	/**
	 * Window Resize.
	 */
	$(window).resize(function() {
	});

	/**
	 * Window Load
	 */
	$(window).load(function() {
		site.initFlexslider();
		site.initBackToTop();
	});
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
