// @codekit-prepend "src/_old-media-uploader.js"
jQuery(function(){
	var mdgAdmin = {},
			chosenSelect = {}
	;

	/**
	 * This updates the hidden text box that holds selections
	 *
	 * @param  Event e Event object from the chosen change method
	 *
	 * @return boolean
	 */
	chosenSelect.changeChosen = function(e){
		var chz,
				selectId,
				textField
		;
		chz = $('#' + e.currentTarget.id).val();
		selectId = e.currentTarget.id.replace('chz_', '');
		textField = $("#" + selectId);
		textField.val(chz);

		return false;
	}; // changeChosen


	/**
	 * Sets up the chosen plugin
	 *
	 * @example http://harvesthq.github.io/chosen/
	 *
	 * @return boolean
	 */
	chosenSelect.setupChosen =  function(){
		$(".chzn-select").chosen({
			allow_single_deselect:true
		});

		$(".chzn-select").chosen().change(function(e){
			chosenSelect.changeChosen(e);
		});

		return false;
	}; // setupChosen()


	// Window Load
	$(window).load(function(){
		// Setup chosen JavaScript dropdowns when the document is ready
		chosenSelect.setupChosen();
	});

	// Chosen Plugin
	$(document).ajaxSuccess(function(e, xhr, settings) {
		// setup chosen javascript after a widget is saved
		chosenSelect.setupChosen();
	});
}($));