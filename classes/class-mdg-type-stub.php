<?php
/**
 * MDG Type Stub Class.
 */

/**
 * You basically need to change [stub/Stub] to be your post
 * type name and then add your custom meta if needed, if no
 * custom meta is needed then delete the get_custom_meta_fields.
 * Please do take a look at MDG_Type_Base to see what parameters
 * and methods are already available to use.
 *
 * The properties of MDG_Type_Base that you should/can alter are
 * all in __construct(). Anything thay isn't REQUIRED that you
 * do not use please remove before deploying to production. Also
 * any property that is optional has the defaults as an example.
 */


/**
 * This class can be used as a starting point to add new post types.
 *
 * @package      WordPress
 * @subpackage   MDG_Base
 *
 * @author       Matchbox Design Group <info@matchboxdesigngroup.com>
 */
class MDG_Type_Stub extends MDG_Type_Base {
	/**
	 * Class constructor, handles instantiation functionality for the class
	 */
	function __construct() {
		/** @var string  REQUIRED slug for post type */
		$this->post_type = 'stub';

		/** @var string  REQUIRED title of post type */
		$this->post_type_title = 'Stubs';

		/** @var string  REQUIRED singular title */
		$this->post_type_single = 'Stub';

		// MDG_Type_Base Properties.
		$this->_set_mdg_type_base_options();

		// MDG_Meta_Helper Properties
		$this->_set_mdg_meta_helper_options();

		parent::__construct();

		$this->_add_type_actions_filters();
	} // __construct()



	/**
	 * Handles setting of the optional properties of MDG_Type_Base
	 *
	 * return Void
	 */
	private function _set_mdg_type_base_options() {
		/** @var array   The taxonomy "name" used in register_taxonomy() */
		$this->taxonomy_name = "{$this->post_type}-categories";

		/** @var array   Custom taxonomy labels used in register_taxonomy() */
		$this->custom_taxonomy_labels = array(
			'name'                       => _x( "{$this->post_type_single} Categories", 'taxonomy general name' ),
			'singular_name'              => _x( "{$this->post_type_single} Category", 'taxonomy singular name' ),
			'search_items'               => __( "Search {$this->post_type_single} Categories" ),
			'all_items'                  => __( "All {$this->post_type_single} Categories" ),
			'parent_item'                => __( "Parent {$this->post_type_single} Category" ),
			'parent_item_colon'          => __( "Parent {$this->post_type_single} Category:" ),
			'edit_item'                  => __( "Edit {$this->post_type_single} Category" ),
			'update_item'                => __( "Update {$this->post_type_single} Category" ),
			'add_new_item'               => __( "Add New {$this->post_type_single} Category" ),
			'new_item_name'              => __( "New {$this->post_type_single} Category Name" ),
			'menu_name'                  => __( "{$this->post_type_single} Categories" ),
			'view_item'                  => __( "View {$this->post_type_single} Category" ),
			'popular_items'              => __( "Popular {$this->post_type_single} Categories" ),
			'separate_items_with_commas' => __( "Separate {$this->post_type_single} Categories with commas" ),
			'add_or_remove_items'        => __( "Add or remove  {$this->post_type_single} Categories" ),
			'choose_from_most_used'      => __( "Choose from the most used {$this->post_type_single} Categories" ),
			'not_found'                  => __( "No  {$this->post_type_single} Categories found." ),
		);

		/** @var array   Custom taxonomy arguments used in register_taxonomy() */
		$this->custom_taxonomy_args = array(
			'hierarchical'      => true,
			// 'labels'          => This is handled by $this->custom_taxonomy_labels do not set directly
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_ui'           => true,
			'show_tagcloud'     => true,
			'show_admin_column' => true,
			'query_var'         => $this->taxonomy_name,
			'rewrite'           => array(
				'slug'         => $this->post_type,
				'with_front'   => false,
				'hierarchical' => true,
			),
		);

		/** @var boolean  Disable/Enable Categories per post type */
		$this->disable_post_type_categories = false;

		/** @var array   Custom post type supports array used in register_post_type() */
		$this->custom_post_type_supports = array(
			'title',
			'editor',         // (content)
			'author',
			'thumbnail',      // (featured image) (current theme must also support Post Thumbnails)
			'excerpt',
			'trackbacks',
			'custom-fields',
			'comments',      // (also will see comment count balloon on edit screen)
			'revisions',     // (will store revisions)
			'page-attributes', // (template and menu order) (hierarchical must be true)
			'post-formats',
		);

		// To disable all supports except title, you should always support title no mater what.
		// $this->custom_post_type_supports = false;

		/** @var array   The post types custom labels used in register_post_type() */
		$this->custom_post_type_labels = array(
			'name'               => __( $this->post_type_title ),
			'singular_name'      => __( $this->post_type_single ),
			'add_new'            => __( "Add New {$this->post_type_single}" ),
			'add_new_item'       => __( "Add New {$this->post_type_single}" ),
			'edit_item'          => __( "Edit {$this->post_type_single}" ),
			'new_item'           => __( "New {$this->post_type_single}" ),
			'all_items'          => __( "All {$this->post_type_title}" ),
			'view_item'          => __( "View {$this->post_type_single}" ),
			'search_items'       => __( "Search {$this->post_type_title}" ),
			'not_found'          => __( "No {$this->post_type_title} found" ),
			'not_found_in_trash' => __( "No {$this->post_type_title} found in Trash" ),
			'parent_item_colon'  => __( '' ),
			'menu_name'          => __( $this->post_type_title ),
		);

		/** @var array   Custom post type arguments used in register_post_type() */
		$this->custom_post_type_args = array(
			// 'labels'          => This is handled by $this->custom_post_type_labels do not set directly
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => $this->post_type, 'with_front' => false ),
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => true,
			'menu_position'      => 5,
			'can_export'         => true,
			'menu_icon'          => 'dashicons-edit',
			// 'supports'        => This is handled by $this->post_type_supports do not set directly
		);
	} // _set_mdg_type_base_options()


	/**
	 * Handles setting of the optional properties of MDG_Meta_Helper
	 *
	 * return Void
	 */
	private function _set_mdg_meta_helper_options() {
		/** @var string Sets the meta box title */
		$this->meta_box_title = "{$this->post_type_single} Details";

		/** @var string Sets the meta box position */
		$this->meta_box_position = 'normal'; // normal|advanced|side

		/** @var string Sets the meta box priority */
		$this->meta_box_priority = 'high'; // high|core|default|low

		/** @var string Renames the featured image meta box */
		$this->featured_image_title = "{$this->post_type_single} Image"; // set to '' or false to keep default title.

		/** @var array Meta box id(s) to be removed */
		$this->meta_boxes_to_remove = array(
			// array(
			//  'id'      => 'authordiv',
			//  'context' => 'normal',
			//  'page'    => $this->post_type,
			// ),
			// array(
			//  'id'      => 'categorydiv',
			//  'context' => 'side',
			//  'page'    => $this->post_type,
			// ),
			// array(
			//  'id'      => "{$this->post_type}-categoriesdiv", // Default custom taxonomy
			//  'context' => 'side',
			//  'page'    => $this->post_type,
			// ),
			// array(
			//  'id'      => 'commentstatusdiv',
			//  'context' => 'normal',
			//  'page'    => $this->post_type,
			// ),
			// array(
			//  'id'      => 'commentsdiv',
			//  'context' => 'normal',
			//  'page'    => $this->post_type,
			// ),
			// array(
			//  'id'      => 'formatdiv',
			//  'context' => 'normal',
			//  'page'    => $this->post_type,
			// ),
			// array(
			//  'id'      => 'pageparentdiv',
			//  'context' => 'side',
			//  'page'    => $this->post_type,
			// ),
			// array(
			//  'id'      => 'postexcerpt',
			//  'context' => 'normal',
			//  'page'    => $this->post_type,
			// ),
			// array(
			//  'id'      => 'revisionsdiv',
			//  'context' => 'normal',
			//  'page'    => $this->post_type,
			// ),
			// array(
			//  'id'      => 'slugdiv',
			//  'context' => 'normal',
			//  'page'    => $this->post_type,
			// ),
			// array(
			//  'id'      => 'submitdiv',
			//  'context' => 'side',
			//  'page'    => $this->post_type,
			// ),
			// array(
			//  'id'      => 'tagsdiv-post_tag',
			//  'context' => 'side',
			//  'page'    => $this->post_type,
			// ),
			// array(
			//  'id'      => 'trackbacksdiv',
			//  'context' => 'normal',
			//  'page'    => $this->post_type,
			// ),
		);

		/** @var array   Used to disable the addition of the featured image column */
		$this->disable_image_column = false;
	} // _set_mdg_meta_helper_options()



	/**
	 * Creates custom meta fields array.
	 *
	 * @return array Custom meta fields
	 */
	public function get_custom_meta_fields() {
		$meta_fields = array();

		if ( ! $this->is_current_post_type() ) {
			return $meta_fields;
		} // if()

		// Description
		$meta_fields[] = array(
			'label'   => '',
			'desc'    => '<div class="mdg-note">Meta description.</div>',
			'id'      => 'info',
			'type'    => 'info',
			'visible' => false,
		);

		// Text
		$meta_fields[] = array(
			'label' => 'Text',
			'desc'  => 'Text description.',
			'id'    => "{$this->post_type}_text",
			'type'  => 'text',
		);

		// URL
		$meta_fields[] = array(
			'label' => 'URL',
			'desc'  => 'URL description.',
			'id'    => "{$this->post_type}_url",
			'type'  => 'url',
		);

		// Email
		$meta_fields[] = array(
			'label' => 'Email',
			'desc'  => 'Email description.',
			'id'    => "{$this->post_type}_email",
			'type'  => 'email',
		);

		// Divider
		$meta_fields[] = array(
			'type'  => 'divider',
		);

		// Markup
		$meta_fields[] = array(
			'label' => 'Markup',
			'desc'  => '<span>Custom markup: </span><a href="#">Link to nowhere</a>',
			'id'    => "{$this->post_type}_markup",
			'type'  => 'markup',
		);

		// File Upload
		$meta_fields[] = array(
			'label' => 'File Upload 1',
			'desc'  => 'File description.',
			'id'    => "{$this->post_type}_file_1",
			'type'  => 'file',
		);

		// File Upload
		$meta_fields[] = array(
			'label' => 'File Upload 2',
			'desc'  => 'File description.',
			'id'    => "{$this->post_type}_file_2",
			'type'  => 'file',
		);

		// Textarea
		$meta_fields[] = array(
			'label' => 'Textarea',
			'desc'  => 'Textarea description.',
			'id'    => "{$this->post_type}_textarea",
			'type'  => 'textarea',
		);

		// Checkbox
		$meta_fields[] = array(
			'label' => 'Checkbox',
			'desc'  => 'Checkbox description.',
			'id'    => "{$this->post_type}_checkbox",
			'type'  => 'checkbox',
		);

		// Radio
		$meta_fields[] = array(
			'label'   => 'Radio',
			'desc'    => 'Radio description.',
			'id'      => "{$this->post_type}_radio",
			'type'    => 'radio',
			'options' => array(
				array(
					'value' => 'value_1',
					'label' => 'Radio Label 1',
				),
				array(
					'value' => 'value_2',
					'label' => 'Radio Label 2',
				),
				array(
					'value' => 'value_3',
					'label' => 'Radio Label 3',
				),
				array(
					'value' => 'value_4',
					'label' => 'Radio Label 4',
				),
			),
		);

		// Select
		$meta_fields[] = array(
			'label'   => 'Select',
			'desc'    => 'Select description.',
			'id'      => "{$this->post_type}_select",
			'type'    => 'select',
			'options' => array(
				array(
					'value' => '',
					'label' => '-- Select an option --',
				),
				array(
					'value' => 'value_1',
					'label' => 'Select Label 1',
				),
				array(
					'value' => 'value_2',
					'label' => 'Select Label 2',
				),
				array(
					'value' => 'value_3',
					'label' => 'Select Label 3',
				),
				array(
					'value' => 'value_4',
					'label' => 'Select Label 4',
				),
			),
		);

		// Chosen Select
		$meta_fields[] = array(
			'label'   => 'Chosen Select',
			'desc'    => 'Chosen select description.',
			'id'      => "{$this->post_type}_chosen_select",
			'type'    => 'chosen_select',
			'options' => array(
				array(
					'value' => '',
					'label' => '-- Select an option --',
				),
				array(
					'value' => 'value_1',
					'label' => 'Label 1',
				),
				array(
					'value' => 'value_2',
					'label' => 'Label 2',
				),
			),
		);

		// Chosen Select Multi (Does not save correctly)
		// $meta_fields[] = array(
		// 	'label'   => 'Chosen Select Multi',
		// 	'desc'    => 'Chosen select multi description.',
		// 	'id'      => "{$this->post_type}_chosen_select_multi",
		// 	'type'    => 'chosen_select_multi',
		// 	'options' => array(
		// 		array(
		// 			'value' => 'value_1',
		// 			'label' => 'Label 1',
		// 		),
		// 		array(
		// 			'value' => 'value_2',
		// 			'label' => 'Label 2',
		// 		),
		// 	),
		// );

		// Date
		$meta_fields[] = array(
			'label' => 'Date',
			'desc'  => 'Date description.',
			'id'    => "{$this->post_type}_date",
			'type'  => 'date',
		);

		// Title
		$meta_fields[] = array(
			'label' => 'Title',
			'type'  => 'title',
		);

		// Color picker
		$meta_fields[] = array(
			'label' => 'Color Picker',
			'desc'  => 'Color Picker description.',
			'id'    => "{$this->post_type}_color_picker",
			'type'  => 'color_picker',
		);

		// WYSIWG Editor
		// You have to use html_entity_decode() when outputting the meta.
		$meta_fields[] = array(
			'label' => 'WYSIWG Editor',
			'desc'  => 'WYSIWG Editor description.',
			'id'    => "{$this->post_type}_wysiwg_editor",
			'type'  => 'wysiwg_editor',
		);

		return $meta_fields;
	} // get_custom_meta_fields()



	/**
	 * Creates custom meta fields array for display after the post title.
	 * Note: probably only should be textual inputs...
	 *
	 * @since   0.2.3
	 *
	 * @return  array Custom meta fields
	 */
	public function get_custom_after_title_meta_fields() {
		$meta_fields = array();

		if ( ! $this->is_current_post_type() ) {
			return $meta_fields;
		} // if()

		// Text
		$meta_fields[] = array(
			'label' => 'Text',
			'desc'  => 'Text description.',
			'id'    => "{$this->post_type}_text",
			'type'  => 'text',
		);


		return $meta_fields;
	} // get_custom_after_title_meta_fields()



	/**
	 * Add post type actions & filters
	 */
	private function _add_type_actions_filters() {
		// Uncomment to redirect the single page to the landing page.
		// add_action( 'template_redirect', array( &$this, 'single_redirect' ) );
	} // _add_type_actions_filters()



	/**
	 * Handles redirecting the single templates to the main team page.
	 *
	 * @return  void
	 */
	public function single_redirect() {
		if ( is_single() and get_post_type() == $this->post_type ) {
			wp_redirect( home_url( "/{$this->post_type}/" ) );
			exit();
		} // if()
	} // single_redirect()
} // END Class MDG_Type_Stub()

global $mdg_stub;
$mdg_stub = new MDG_Type_Stub();
