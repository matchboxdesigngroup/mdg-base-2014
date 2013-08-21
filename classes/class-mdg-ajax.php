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
	} // __construct()
} // END Class MDG_Ajax()

global $mdg_ajax;
$mdg_ajax = new MDG_Ajax();