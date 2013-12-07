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
 * The properties of MDG_Type_Base that you should/can alter are
 * all in __construct(). Anything thay isn't REQUIRED that you
 * do not use please remove before deploying to production. Also
 * any property that is optional has the defaults as an example.
 *
 * @author Matchbox Design Group <info@matchboxdesigngroup.com>
 */
class MDG_Type_Stub extends MDG_Type_Base
{
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
	} // __construct()



	/**
	 * Handles setting of the optional properties of MDG_Type_Base
	 *
	 * return Void
	 */
	private function _set_mdg_type_base_options() {
		/** @var array   The taxonomy "name" used in register_taxonomy() */
		$this->taxonomy_name = "{$this->post_type}-categories";

		/** @var array   Custom taxonomy arguments used in register_taxonomy() */
		$this->custom_taxonomy_args  = array(
			'hierarchical'      => true,
			'labels'            => $labels,
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

		/** @var boolean  Disable/Enable Categories per post type */
		$this->disable_post_type_categories = false;

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
			'not_found'          => __( "No {$lowercase_post_type_title} found" ),
			'not_found_in_trash' => __( "No {$lowercase_post_type_title} found in Trash" ),
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
			'has_archive'        => true,
			'hierarchical'       => true,
			'menu_position'      => 5,
			'can_export'         => true,
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
		$this->meta_box_title = 'Details';

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
	 * @return ArrayObject Custom meta fields
	 */
	public function get_custom_meta_fields() {
		global $post;
		$description = '<div class="mdg-note">Meta description.</div>';
		return array(
			// Description
			array(
				'label'   => '',
				'desc'    => $description,
				'id'      => 'info',
				'type'    => 'info',
				'visible' => false,
			),
			// Text
			array(
				'label' => 'Text',
				'desc'  => 'Text description.',
				'id'    => "{$this->post_type}Text",
				'type'  => 'text',
			),
			// Divider
			array(
				'type'  => 'divider',
			),
			// Markup
			array(
				'label' => 'Markup',
				'desc'  => '<span>Custom markup: </span><a href="#">Link to nowhere</a>',
				'id'    => "{$this->post_type}Markup",
				'type'  => 'markup',
			),
			// File Upload
			array(
				'label' => 'File Upload 1',
				'desc'  => 'File description.',
				'id'    => "{$this->post_type}File1",
				'type'  => 'file',
			),
			// File Upload
			array(
				'label' => 'File Upload 2',
				'desc'  => 'File description.',
				'id'    => "{$this->post_type}File2",
				'type'  => 'file',
			),
			// Textarea
			array(
				'label' => 'Textarea',
				'desc'  => 'Textarea description.',
				'id'    => "{$this->post_type}Textarea",
				'type'  => 'textarea',
			),
			// Checkbox
			array(
				'label' => 'Checkbox',
				'desc'  => 'Checkbox description.',
				'id'    => "{$this->post_type}Checkbox",
				'type'  => 'checkbox',
			),
			// Select
			array(
				'label'   => 'Select',
				'desc'    => 'Select description.',
				'id'      => "{$this->post_type}Select",
				'type'    => 'select',
				'options' => array(
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
			),
			// Chosen Select
			array(
				'label'   => 'Chosen Select',
				'desc'    => 'Chosen select description.',
				'id'      => "{$this->post_type}ChosenSelect",
				'type'    => 'chosen_select',
				'options' => array(
					array(
						'value' => 'value_1',
						'label' => 'Label 1',
					),
					array(
						'value' => 'value_2',
						'label' => 'Label 2',
					),
				),
			),
			// Chosen Select Multi
			array(
				'label'   => 'Chosen Select Multi',
				'desc'    => 'Chosen select multi description.',
				'id'      => "{$this->post_type}ChosenSelectMulti",
				'type'    => 'chosen_select_multi',
				'options' => array(
					array(
						'value' => 'value_1',
						'label' => 'Label 1',
					),
					array(
						'value' => 'value_2',
						'label' => 'Label 2',
					),
				),
			),
			// Date
			array(
				'label' => 'Date',
				'desc'  => 'Date description.',
				'id'    => "{$this->post_type}Date",
				'type'  => 'date',
			),
			// Line
			array(
				'type'  => 'line',
			),
			// Title
			array(
				'label' => 'Title',
				'type'  => 'title',
			),
			// Color picker
			array(
				'label' => 'Color Picker',
				'desc'  => 'Color Picker description.',
				'id'    => "{$this->post_type}ColorPicker",
				'type'  => 'color_picker',
			),
			// WYSIWG Editor
			// You have to use html_entity_decode() when outputting the meta.
			array(
				'label' => 'WYSIWG Editor',
				'desc'  => 'WYSIWG Editor description.',
				'id'    => "{$this->post_type}WYSIWGEditor",
				'type'  => 'wysiwg_editor',
			),
		);
	} // get_custom_meta_fields()
} // END Class MDG_Type_Stub()

global $mdg_stub;
$mdg_stub = new MDG_Type_Stub();