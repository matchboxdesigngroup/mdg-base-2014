jQuery(function($){
	/**
	 * Creates the file uploader model window
	 *
	 * @param  object that Reference to the element that activates the uploader
	 *
	 * @return object      A reference to the file uploader
	 */
	mdgAdmin.createFileUploader = function(that) {
		// Create the media frame.
		fileFrame = wp.media.frames.fileFrame = wp.media({
			title: that.data( 'uploader_title' ),
			button: { text: 'Add Attachments' },
			multiple: true
		});

		return fileFrame;
	}; // createFileUploader()


	$(window).load(function(){
		var fileFrame,
				saveElem = $('.wpba-saving')
		;

		/**
		* Attach Image
		*/
		// Uploading files
		$('#wpba_attachments_button, #wpba_form_attachments_button').on('click', function( event ){
			event.preventDefault();
			var that = $(this);

			// If the media frame already exists, reopen it.
			if ( fileFrame ) {
				fileFrame.open();
				return;
			} // if()

			mdgAdmin.createFileUploader( that );

			fileFrame.on( 'select', function() {
				var attachments = fileFrame.state().get('selection').toJSON(),
						ajaxData = {
							attachments: attachments,
							action: 'wpba_add_attachment',
							parentid: $('.wpba').data('postid')
						}
				;
				saveElem.removeClass('hide');
				$.post(ajaxurl, ajaxData, function(data) {
					resp = $.parseJSON(data);
					if ( resp ) {
						$( "#wpba_image_sortable" ).append( resp.image );
						wpba.updateSortOrder($( "#wpba_image_sortable" ));
						wpba.resetClickHandlers();
					}

				});
			});

			// Finally, open the modal
			fileFrame.open();
		});

	}); // $(window).load()
}(jQuery));