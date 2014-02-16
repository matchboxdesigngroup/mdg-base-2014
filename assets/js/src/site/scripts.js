/** global MDG_GLOBALS */
/** global PIE */
/**
 * To activate the plugins for CodeKit remove the space between @ and codekit-prepend this
 * mirrors the order and default setup from Gruntfile.js
 */
// @codekit-prepend "../plugins/bootstrap/plugins.js"
// @ codekit-prepend "../plugins/imagesloaded.pkgd.js"
// @ codekit-prepend "../plugins/jquery.flexslider.js"
// @ codekit-prepend "../plugins/placeholders.jquery.min.js"
// @codekit-prepend "../plugins/jQuery.resizeEnd.js"
// @ codekit-prepend "../plugins/jquery.selectric.js"
// @codekit-prepend "../plugins/responsive-img.js"
// @codekit-prepend "bp.js"
jQuery((function($) {
	var site    = {};

	// Globals defined in scripts.php
	// bp      = MDG_GLOBALS.bp,
	// ajaxurl = MDG_GLOBALS.ajaxurl

	/**
	 * Initialize FlexSliders here
	 *
	 * @return boolean false
	 */
	site.initFlexslider = function() {
		var slider = $('.flexslider');

		// Check if a slider exists
		if ( slider.length === 0 ) {
			return false;
		}

		return false;
	}; // site.initFlexslider()

	site.initFitVids = function() {
		$("body").fitVids();
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
		$('html,body').animate( { scrollTop: offset }, speed, easing );

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

		pageTopLinkElem.click(function(){
			$(window.opera ? "html" : "html, body").stop(true , true).animate({scrollTop: 0} , 1500 , "easeInOutQuad");
			return false;
		});

		$(window).scroll(function(){
			if($(window).scrollTop() > 150){
				pageTopLinkElem.stop(true , true).fadeIn(1000);
			}else{
				pageTopLinkElem.stop(true , true).fadeOut(1000);
			}
		});
	}; // site.initBackToTop()

	/**
	 * Handles the locking of an element on scroll.
	 *
	 * @param {integer} offsetTop The distance from the top to trigger the fixing of the element.
	 *
	 * @return Void
	 */
	// site.fixElement = function(offsetTop) {
	//	var fixedElem = $('.fixed-elem'),
	//			offset    = (typeof offsetTop === 'undefined') ? 150:offsetTop
	//	;

	//	if ( fixedElem.length === 0 ) {
	//		return false;
	//	} // if

	//	$(window).scroll(function(){
	//		fixedElem.each(function(index,el) {
	//			var that = $(el);

	//			var offsetTop             = that.offset().top,
	//					scrollTop             = $(window).scrollTop(),
	//					// direction            = ( true ) ? 'up' : 'down',
	//					fixedElemOffset       = ( ( offsetTop - offset ) <= scrollTop ),
	//					activeFixedElemOffset = ( ( offsetTop - offset ) <= scrollTop )
	//			;
	//			if ( fixedElemOffset || activeFixedElemOffset ) {
	//				if ( ! that.hasClass('fixed') ) {
	//					that.addClass('fixed');
	//				} // if()
	//			} else {
	//				// that.removeClass('fixed').removeClass('up').removeClass('down');
	//				// console.log(that.attr('class'));
	//			} // if/else()
	//		}); // fixedElem.each()
	//	}); // $(window).scroll()
	// }; // site.fixElement()

	/**
	 * Document Ready
	 */
	$(document).ready(function() {
		site.initFauxLink();
		site.initDropDownMenu();
		site.css3pieAttach();
		site.initFitVids();
		// site.fixElement();
	});

	/**
	 * Window Resize.
	 * Resize end requires /assets/js/src/plugins/jQuery.resizeEnd.js
	 * to be included if it is not included change resizeEnd to resize.
	 */
	$(window).resizeEnd(function() {
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