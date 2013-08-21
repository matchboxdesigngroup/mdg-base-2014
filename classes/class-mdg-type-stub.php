<?php
/**
* MDG Type Base Stub
*
* This class can be used as a starting point to add new post types.
*
* You basically need to change [stub/Stub] to be your post
* type name and then add your custom meta if needed, if no
* custom meta is needed then delete the get_custom_meta_fields.
* Please do take a look at MDG_Type_Base to see what parameters
* and methods are already available to use.
*
* @author Matchbox Design Group <info@matchboxdesigngroup.com>
*/
class MDG_Type_Stub extends MDG_Type_Base
{
	/**
	 * Class constructor, handles instantiation functionality for the class
	 */
	function __construct()
	{
		$this->transient_title  = 'stub';
		$this->post_type        = 'stub';
		$this->post_type_title  = 'Stubs';
		$this->post_type_single = 'Stub';
		parent::__construct();
	} // __construct()



	/**
	 * Creates custom meta fields array.
	 *
	 * @return ArrayObject Custom meta fields
	 */
	public function get_custom_meta_fields() {
		$description = '<div class="mdg-note"></div>';
		return array(
			array(
				'label'   => '',
				'desc'    => $description,
				'id'      => 'info',
				'type'    => 'info',
				'visible' => false
			),
			array(
				'label' => 'Title/Position',
				'desc'  => '',
				'id'    => $prefix.'Title',
				'type'  => 'text'
			)
		);
	} // get_custom_meta_fields()
} // END Class MDG_Type_Stub()

global $mdg_stub;
$mdg_stub = new MDG_Type_Stub();