jQuery((function($){
	var lb = {
		backgroundElem : undefined,
		openElem       : undefined,
		closeElem      : undefined,
		contentElem    : undefined,
		html           : undefined
	};


	/**
	 * Injects the LightBox(s)
	 *
	 * @todo Possibly integrate a slider/gallery for multiple images.
	 *
	 * @return {boolean}             false
	 */
	lb.injectLightBox = function() {
		lb.html  = $('html');
		var html = '';
		html = html + '<div id="mdg_lightbox_bg" class="close">';
			html = html + '<div class="inner">';
				html = html + '<button class="close">×</button>';
			html = html + '</div>';
		html = html + '</div>';

		lb.html.append(html);
	};



	/**
	 * Adds the content to the LightBox.
	 *
	 * @param  {object}   Elem jQuery selector object for the open element to get data from.
	 * @param  {function} Callback Function to be executed after all operations are finished.
	 *
	 * @return boolean    false
	 */
	lb.addContent = function(elem, callback) {
		lb.contentElem.empty();
		lb.contentElem.html('test');

		callback();

		return false;
	};



	/**
	 * Centers the lightbox
	 *
	 * @param  {function} callback Function to be executed after all operations are finished.
	 *
	 * @return {boolean}           false
	 */
	lb.centerLightBoxForm = function( callback ) {
		// We only want to center it if it is open.
		if ( !lb.backgroundElem.hasClass('close') ) {
			return false;
		} // if()

		var currentWindow = $(window),
				windowWidth   = currentWindow.outerWidth(),
				windowHeight  = currentWindow.outerHeight(),
				content       = lb.contentElem,
				contentWidth  = content.outerWidth(),
				contentHeight = content.outerHeight(),
				left          = ( windowWidth - contentWidth ) / 2,
				top           = ( windowHeight - contentHeight ) / 2
		;
		content.css({'left':left, 'top':top});

		callback();

		return false;
	}; // lb.centerLightBoxForm()



	/**
	 * Opens the LightBox
	 *
	 * @param  {object}  elem jQuery selector object for the open element to get data from.
	 *
	 * @return {boolean}          false
	 */
	lb.open = function( elem ) {
		if ( lb.backgroundElem.hasClass('open') ) {
			return false;
		} // if()

		// Center LightBox Form
		lb.centerLightBoxForm(function(){
			// Add content to the LightBox
			lb.addContent( elem, function() {
				// Open Light box
				lb.backgroundElem.removeClass('close').addClass('open');

				// Add scroll top to html element.
				lb.html.addClass('mdg-lightbox-opened');
			});
		});

		return false;
	}; // lb.open()



	/**
	 * Closes the LightBox
	 *
	 * @param  object  backgroundElem jQuery selector object for the background element
	 *
	 * @return boolean                false
	 */
	lb.close = function( backgroundElem ) {
		// if ( backgroundElem.hasClass('active') ) {
		//	backgroundElem.removeClass('active').animate({'opacity':0}, 500, function(){
		//		$(this).css({'visibility':'hidden', 'display':'none'});
		//	});
		// } // if()

		return false;
	}; // lb.close()



	/**
	 * Initializes the LightBox
	 *
	 * @param  object  openElem   jQuery selector object for the activation element
	 * @param  object  backgroundElem jQuery selector object for the background element
	 *
	 * @todo Allow for multiple initializations.
	 *
	 * @return boolean                false
	 */
	lb.initLightBox = function(openElem) {
		// Add LightBox to page.
		lb.injectLightBox();

		// Set the LightBox elements.
		lb.openElem       = openElem;
		lb.backgroundElem = $('#mdg_lightbox_bg');
		lb.contentElem    = lb.backgroundElem.find('.inner');
		lb.closeElem      = lb.backgroundElem.find('.close');

		// Open LightBox click handler
		lb.openElem.on('click', function( e ) {
			e.preventDefault();
			lb.open( $(this) );
			return false;
		});

		// Close LightBox click handler.
		lb.closeElem.on('click', function( e ){
			e.preventDefault();
			lb.close();
			return false;
		});

		// Make sure the LightBoxstays in the center.
		$(window).on('resize', function(){
			lb.centerLightBoxForm();
		});

		// Allows for having a modal open on page load.
		var openOnLoad = $('.mdg-lightbox.open-on-load');
		if ( openOnLoad.length !== 0 ) {
			lb.open( openOnLoad.first() );
		} // if()

		return false;
	}; // lb.initLightBox()


	// Document Load
	$(document).ready(function(){
		lb.initLightBox( $('.mdg-lightbox') );
	});
}(jQuery)));