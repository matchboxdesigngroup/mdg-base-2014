<?php
/**
* MDG Ajax
*
* All AJAX callbacks should reside in this class for easier maintenance and testing
*
* @author Matchbox Design Group <info@matchboxdesigngroup.com>
*/
class MDG_Ajax extends MDG_Generic
{
	/**
	 * Class constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_add_actions();
	} // __construct()


	/**
	 * Place all add_action calls here
	 *
	 * @return Void
	 */
	private function _add_actions() {
		// Meta upload thumbnail
		add_action( 'wp_ajax_mdg_meta_upload_thumb', array( &$this, 'mdg_meta_upload_thumb_callback' ) );
	} // _add_actions()


	public function mdg_meta_upload_thumb_callback() {
		if ( ! isset( $_GET['fileSrc'] ) ) {
			echo json_encode( '' );
			exit;
		} // if()

		global $mdg_meta_form_fields;
		$thumbnail = $mdg_meta_form_fields->file_upload_field_thumbnail( $_GET['fileSrc'] );
		echo json_encode( $thumbnail );
		exit;
	} // mdg_meta_upload_thumb_callback
} // END Class MDG_Ajax()

global $mdg_ajax;
$mdg_ajax = new MDG_Ajax();