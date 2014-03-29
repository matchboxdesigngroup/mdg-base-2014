<?php
/**
 * Sidebar/Widgets.
 */

/**
 * Determines whether or not to display the sidebar based on an array of conditional tags or page templates.
 * If any of the is_* conditional tags or is_page_template(template_file) checks return true, the sidebar will NOT be displayed.
 *
 * @package      WordPress
 * @subpackage   MDG_Base
 *
 * @param array   list of conditional tags (http://codex.wordpress.org/Conditional_Tags)
 * @param array   list of page templates. These will be checked via is_page_template()
 *
 * @return boolean True will display the sidebar, False will not
 */
class MDG_Sidebar {
	/**
	 * WordPress conditional tags to check against.
	 *
	 * @see https://codex.wordpress.org/Conditional_Tags
	 * @var  array
	 */
	private $conditionals;



	/**
	 * Page template checks (via is_page_template())
	 *
	 * @var  array
	 */
	private $templates;



	/**
	 * If the sidebar should be displayed.
	 *
	 * @var  boolean
	 */
	public $display = true;



	/**
	 * Class constructor.
	 *
	 * @param  array  $conditionals  WordPress conditional tags to check against.
	 * @param  array  $templates     Page template checks (via is_page_template())
	 */
	function __construct( $conditionals = array(), $templates = array() ) {
		$this->conditionals = $conditionals;
		$this->templates    = $templates;

		$conditionals = array_map( array( $this, 'check_conditional_tag' ), $this->conditionals );
		$templates    = array_map( array( $this, 'check_page_template' ), $this->templates );

		if ( in_array( true, $conditionals ) || in_array( true, $templates ) ) {
			$this->display = false;
		} // if()
	} // __construct()



	/**
	 * Checks the supplied conditional tag.
	 *
	 * @param   string   $conditional_tag  The conditional tag to check against.
	 *
	 * @return  boolean                    The conditional tag check result.
	 */
	private function check_conditional_tag( $conditional_tag ) {
		if ( is_array( $conditional_tag ) ) {
			return $conditional_tag[0]( $conditional_tag[1] );
		} else {
			return $conditional_tag();
		} // if/else()
	} // check_conditional_tag()



	/**
	 * Checks the supplied page template.
	 *
	 * @param   string   $page_template  Page template to check against.
	 *
	 * @return  boolean                  The page template check result.
	 */
	private function check_page_template( $page_template ) {
		return is_page_template( $page_template );
	} // check_page_template()
} // MDG_Sidebar()