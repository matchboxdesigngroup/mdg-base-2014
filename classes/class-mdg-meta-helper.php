<?php
/**
 * MDG Meta Helper Class
 */

/**
 * Handles anything to do with custom meta.
 *
 * @package      WordPress
 * @subpackage   MDG_Base
 *
 * @author       Matchbox Design Group <info@matchboxdesigngroup.com>
 */
class MDG_Meta_Helper extends MDG_Form_Fields {
	/** @var string Sets the meta box title */
	public $meta_box_title;
	/** @var string Sets the meta box position */
	public $meta_box_position;
	/** @var string Sets the meta box priority */
	public $meta_box_priority;
	/** @var string Renames the featured image meta box */
	public $featured_image_title;
	/** @var array Meta box id(s) to be removed */
	public $meta_boxes_to_remove;



	/**
	 * Class Constructor
	 */
	public function __construct() {
		parent::__construct();

		$this->_add_actions();

		$this->meta_box_title       = ( isset( $this->meta_box_title ) ) ? $this->meta_box_title : "{$this->post_type_single} Details";
		$this->meta_box_position    = ( isset( $this->meta_box_position ) ) ? $this->meta_box_position : 'normal';
		$this->meta_box_priority    = ( isset( $this->meta_box_priority ) ) ? $this->meta_box_priority : 'high';
		$this->meta_boxes_to_remove = ( isset( $this->meta_boxes_to_remove ) ) ? $this->meta_boxes_to_remove : array();
		$this->featured_image_title = ( isset( $this->featured_image_title ) ) ? $this->featured_image_title : 'Featured Image';
	} // __construct()



	/**
	 * All of the allowed tags when outputting meta form fields.
	 *
	 * @return array Allowed HTML tags.
	 */
	public function get_meta_output_kses_allowed_html() {
		$allowed_tags          = wp_kses_allowed_html( 'post' );
		$allowed_tags['<hr>']  = array();
		$allowed_tags['input'] = array(
			'type'        => array(),
			'name'        => array(),
			'id'          => array(),
			'value'       => array(),
			'size'        => array(),
			'class'       => array(),
			'placeholder' => array(),
			'checked'     => array(),
		);
		$allowed_tags['option'] = array(
			'value'    => array(),
			'selected' => array(),
		);
		$allowed_tags['select'] = array(
			'name'     => array(),
			'id'       => array(),
			'class'    => array(),
			'style'    => array(),
			'multiple' => array()
		);
		$allowed_tags['span'] = array(
			'class' => array(),
			'id'    => array(),
		);
		$allowed_tags['textarea'] = array(
			'name'        => array(),
			'id'          => array(),
			'cols'        => array(),
			'rows'        => array(),
			'class'       => array(),
		);

		$allowed_tags['input']['data-format'] = array();
		return $allowed_tags;
	} // get_meta_output_kses_allowed_html()



	/**
	 * All action hooks that are required by the class using add_action.
	 *
	 * @return Void
	 */
	protected function _add_actions() {
		// Save custom meta action hook
		add_action( 'save_post', array( &$this, 'save_meta' ) );

		// Make meta box action hook
		add_action( 'add_meta_boxes', array( &$this, 'make_meta_box' ) );

		// Remove metaboxes action hook
		add_action( 'admin_menu' , array( &$this, 'remove_metaboxes' ) );

		// Renames the featured image meta box
		add_action( 'do_meta_boxes', array( &$this, 'rename_featured_image_meta_box' ) );
	} // _add_actions()



	/**
	 * Removes unwanted meta boxes
	 *
	 * @return Void
	 */
	public function remove_metaboxes() {
		// Remove from all post types
		$post_types = get_post_types();
		foreach ( $post_types as $post_type )
			remove_meta_box( 'postcustom', $post_type, 'normal' );

		// Remove from specific post type
		foreach ( $this->meta_boxes_to_remove as $meta_box ) {
			extract( $meta_box );
			if ( $id != '' and $context != '' and $page != '' )
				remove_meta_box( $id, $page, $context );
		} // foreach();
	} // remove_metaboxes()



	/**
	 * Renames the featured image meta box.
	 *
	 * @return Void
	 */
	public function rename_featured_image_meta_box() {
		$post_type_supports_thumbnail = post_type_supports( get_post_type(), 'thumbnail' );
		if ( ! $this->featured_image_title or $this->featured_image_title == '' or ! $post_type_supports_thumbnail ) {
			return;
		} // if()
		remove_meta_box( 'postimagediv', $this->post_type, 'side' );
		add_meta_box( 'postimagediv', __( $this->featured_image_title ), 'post_thumbnail_meta_box', $this->post_type, 'side', 'low' );
	} // rename_featured_image_meta_box



	/**
	 * Will cycle through your fields array, and create your form
	 *
	 * Your fields array should look something like the example provided
	 * and you can pass this array via $args (e.g. $helper->make_form(array('meta_fields' => $fields_array);
	 * array(
	 *  array(
	 *   'label' => 'Field one',
	 *   'desc' => 'helper text,
	 *   'id' => 'fieldOneID',
	 *   'type' => 'text'
	 *  ),
	 *  array(
	 *   'label' => 'Field Two',
	 *   'desc' => 'helper text,
	 *   'id' => 'fieldTwoID',
	 *   'type' => 'text'
	 *  )
	 * );
	 *
	 * @param array   $args [description]
	 *
	 * @return [type]       [description]
	 */
	public function make_form( $args = array() ) {
		global $post;
		$meta_fields  = isset( $args['meta_fields'] ) ? $args['meta_fields'] : '';
		$allowed_tags = $this->get_meta_output_kses_allowed_html();

		// Output description information
		foreach ( $meta_fields as $field ){
			if ( $field['type'] == 'info' ) {
				echo wp_kses( $field['desc'], $allowed_tags );
			} // if()
		} // foreach()

			// Use nonce for verification
			echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce( basename( __FILE__ ) ).'" />';

		// Begin the field table and loop
		echo '<table class="form-table">';

		foreach ( $meta_fields as $field ) {
			extract( $field );

			// get value of this field if it exists for this post
			$meta = get_post_meta( $post->ID, esc_attr( $id ), true );
			// begin a table row with
			echo '<tr>
			<th><label for="'.esc_attr( $id ).'">'.esc_attr( $label ).'</label></th>
				<td>';
				$this->select_form_field( $field, $meta );
			echo '</td></tr>';
		} // foreach()
		echo '</table>'; // end table
	} // make_form()



	/**
	 * Handles sanitizing the post meta value dependent of the field type.
	 *
	 * @param   string  $field_type  The field id/type.
	 * @param   mixed   $value       The meta value to be sanitized.
	 *
	 * @return  mixed               The sanitized meta data.
	 */
	public function sanitize_post_meta( $field_type, $value ) {
		switch ( $field_type ) {
			case 'text':
				$value = sanitize_text_field( $value );
				break;

			case 'file':
				$value = esc_url_raw( $value, $protocols );
				break;

			case 'url':
				$value = esc_url_raw( $value, $protocols );
				break;

			case 'email':
				$value = sanitize_email( $value );
				break;

			case 'textarea':
				$value = wp_kses( $value, 'post' );
				break;

			case 'wysiwg_editor':
				$value = wp_kses( $value, 'post' );
				break;

			case 'multi_input':
				$value = wp_kses( $value, 'post' );
				break;

			default:
				$value = esc_attr( $value );
				break;
		} // switch()

		return $value;
	} // sanitize_post_meta()



	/**
	 * Saves your custom meta when the post is saved.
	 *
	 * @param   integer $post_id             The post id to attribute the meta.
	 * @param   array   $custom_meta_fields  All of the meta fields to save.
	 *
	 * @return  Void
	 */
	public function save_custom_meta( $post_id = null, $custom_meta_fields = array() ) {
		if ( is_null( $post_id ) ) {
			return '';
		} // if()

		// verify nonce
		$mb_nonce = isset( $_POST['custom_meta_box_nonce'] ) ? $_POST['custom_meta_box_nonce'] : '';
		if ( ! wp_verify_nonce( $mb_nonce, basename( __FILE__ ) ) ){
			return $post_id;
		} // if()

		// check autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
			return $post_id;
		} // if()

		foreach ( $custom_meta_fields as $field ) {
			extract( $field );

			$old = get_post_meta( $post_id, esc_attr( $id ), true );
			$new = isset( $_POST[esc_attr( $id )] ) ? $_POST[esc_attr( $id )] : '';

			$new = $this->sanitize_post_meta( $id, $new );

			if ( $new && $new != $old ) {
				update_post_meta( $post_id, esc_attr( $id ), $new );
			} elseif ( '' == $new && $old ) {
				delete_post_meta( $post_id, esc_attr( $id ), $old );
			} // if/elseif()
		} // end foreach
	} // save_custom_meta()



	/**
	 * Retrieves custom post meta.
	 *
	 * <code>
	 * global $my_post_type;
	 *
	 * // Retrieves all the current posts meta.
	 * $all_post_meta    = $my_post_type->get_post_meta();
	 * extract( $all_post_meta );
	 *
	 * // Retrieves a single post meta value.
	 * $single_post_meta = $my_post_type->get_post_meta( get_the_id(), 'meta_key');
	 * extract( $single_post_meta );
	 * </code>
	 *
	 * @param   integer        $post_id  Optional post id, defaults to current post.
	 * @param   string         $key      Optional meta key minus the post type, to return one meta value instead of all of them.
	 *
	 * @return string|array              Specific post meta value | All all post meta values.
	 */
	public function get_post_meta( $post_id = null, $key = null ) {
		if ( is_null( $post_id ) ) {
			global $post;
			$post_id = $post->ID;
		} // if()

		$post_type = $this->post_type;
		if ( ! isset( $post_type ) ) {
			$post_type = get_post_type( $post_id );
		} // if()

		if ( ! is_null( $key ) ) {
			// Protects against absent mindedness.
			$key = str_replace( "{$this->post_type}_", '', $key );
			$key = str_replace( "{$this->post_type}-", '', $key );
			$key = str_replace( $this->post_type, '', $key );
			return get_post_meta( $post_id, "{$post_type}{$key}", true );
		} // if()

		$meta_fields = $this->get_custom_meta_fields();
		$all_meta    = array();
		foreach ( $meta_fields as $field ) {
			extract( $field );

			if ( $type !== 'info' ) {
				$meta_key            = trim( str_replace( "{$this->post_type}_", '', strtolower( $id ) ) );
				$all_meta[$meta_key] = get_post_meta( $post_id, $id, true );
			} // if()
		} // foreach()

		ksort( $all_meta );

		return $all_meta;
	} // get_post_meta()



	/**
	 * Override this method to create custom meta fields.
	 *
	 * By returning an empty array in this method, we're telling the class to not to
	 * do anything will custom meta (e.g. meta boxes, and saving meta etc...)
	 * The overridden method should return an array like..
	 * <code>
	 * return array(
	 *  array(
	 *   'label' => 'Title/Position',
	 *   'desc'  => '',
	 *   'id'    => $prefix.'Title',
	 *   'type'  => 'text',
	 *  ),
	 *  array(
	 *   'label' => 'Quote',
	 *   'desc'  => '',
	 *   'id'    => $prefix.'Quote',
	 *   'type'  => 'textarea',
	 *  )
	 * );
	 * </code>
	 *
	 * @return array Custom meta fields.
	 */
	public function get_custom_meta_fields() {
		return array();
	} // get_custom_meta_fields()



	/**
	 * Handles registering and generating the custom meta box.
	 *
	 * @return Void
	 */
	public function make_meta_box() {
		$custom_meta_fields = $this->get_custom_meta_fields();
		if ( empty( $custom_meta_fields ) )
			return;

		add_meta_box(
			"{$this->post_type}_id_meta_box", // $id
			$this->meta_box_title,            // $title
			array( $this, 'show_meta_box' ),  // $callback
			$this->post_type,                 // $page
			$this->meta_box_position,         // $context
			$this->meta_box_priority          // $priority
		);
	} // make_meta_box()



	/**
	 * Handles outputting of the meta box form.
	 *
	 * @return Void
	 */
	public function show_meta_box() {
		$custom_meta_fields = $this->get_custom_meta_fields();
		if ( empty( $custom_meta_fields ) )
			return;

		global $post;
		$this->make_form( array( 'meta_fields' => $custom_meta_fields ) );
	} // show_meta_box()



	/**
	 * Handles the saving of custom meta.
	 *
	 * @param integer $post_id ID of the post that you wish to save custom meta for
	 *
	 * @return Void
	 */
	public function save_meta( $post_id ) {
		$custom_meta_fields = $this->get_custom_meta_fields();
		if ( empty( $custom_meta_fields ) )
			return;

		$this->save_custom_meta( $post_id, $custom_meta_fields );
	} // save_meta()
} // END Class MDG_Meta_Helper
