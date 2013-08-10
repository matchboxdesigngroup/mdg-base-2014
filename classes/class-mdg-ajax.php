<?php
/**
* MDG Ajax
*
* All AJAX callbacks should reside in this class for easier maintenance and testing
*/
class MDG_Ajax extends MDG_Generic
{
	/**
	 * Class constructor
	 *
	 * @param array $config Class configuration options
	 */
	function __construct( $config = array() )
	{

	} // __construct()
} // END Class MDG_Ajax()

global $mdg_ajax;
$mdg_ajax = new MDG_Ajax();