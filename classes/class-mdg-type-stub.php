<?php
/**
* MDG Type Base Stub
*
* This class can be used as a starting point to add new post types
*/
class MDG_Type_Stub extends MDG_Type_Base
{

	function __construct()
	{
		$this->transient_title  = 'stub';
		$this->post_type        = 'stub';
		$this->post_type_title  = 'Stubs';
		$this->post_type_single = 'Stub';
		parent::__construct();
	} // __construct()
} // END Class MDG_Type_Stub()

global $mdg_stub;
$mdg_stub = new MDG_Type_Stub();