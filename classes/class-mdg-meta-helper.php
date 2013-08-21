<?php
/**
 * MDG Meta Helper
 *
 * Meta helpers should hold some grunt work for making
 * custom meta. This class should contain global work that should work
 * for any environment (that's the idea anyway).
 *
 * @author Matchbox Design Group <info@matchboxdesigngroup.com>
 */
class MDG_Meta_Helper extends MDG_Generic {
	/**
	 * Class Constructor
	 */
	public function __construct()
	{
		parent::__construct();
		$this->_add_actions();
	} // __construct()



	/**
	 * All action hooks that are required by the class using add_action.
	 *
	 * @return Void
	 */
	protected function _add_actions()
	{
		// Save custom meta action hook
		add_action( 'save_post', array( &$this, 'save_meta' ) );

		// Make meta box action hook
		add_action( 'add_meta_boxes', array( &$this, 'make_meta_box' ) );

		// Remove metaboxes action hook
		add_action( 'admin_menu' , array( &$this, 'remove_metaboxes' ) );
	} // _add_actions()



	/**
	 * Removes unwanted meta boxes from all post types.
	 *
	 * @return Void
	 */
	public function remove_metaboxes() {
		// hide stuff for all post types
		$post_types = get_post_types();
		foreach ( $post_types as $post_type )
			remove_meta_box( 'postcustom', $post_type, 'normal' );
	} // remove_metaboxes()



	/**
	 * Will cycle through your fields array, and create your form
	 *
	 * Your fields array should look something like the example provided
	 * and you can pass this array via	$args (e.g. $helper->make_form(array('meta_fields' => $fields_array);
	 *	array(
	 *		array(
	 *			'label'	=> 'Field one',
	 *			'desc'	=> 'helper text,
	 *			'id'	=> 'fieldOneID',
	 *			'type'	=> 'text'
	 *		),
	 *		array(
	 *			'label'	=> 'Field Two',
	 *			'desc'	=> 'helper text,
	 *			'id'	=> 'fieldTwoID',
	 *			'type'	=> 'text'
	 *		)
	 *	);
	 *
	 * @todo Finish doc block and clean up method
	 *
	 * @param  array  $args [description]
	 *
	 * @return [type]       [description]
	 */
	public function make_form( $args = array() ) {
		global $post;
		$meta_fields = isset( $args['meta_fields'] ) ? $args['meta_fields'] : '';
		$meta_form = '';

		// get descriptive info
		foreach ( $meta_fields as $field ) {
			if ( $field['type'] == 'info' )
				$meta_form .= $field['desc'];
		} // foreach()

		// Use nonce for verification
		$nonce = wp_create_nonce( basename( __FILE__ ) );
		$meta_form .= "<input type='hidden' name='custom_meta_box_nonce' value='{$nonce}' />";

		// Begin the field table and loop
		$meta_form .= '<table class="form-table">';
		foreach ( $meta_fields as $field ) {
			$field = $this->_esc_array_attr( $field );
			extract( $field );

			// get value of this field if it exists for this post
			$meta = get_post_meta( $post->ID, $id, true );

			$meta_form .= '<tr>';
			$meta_form .= "<th><label for='{$id}'>{$label}</label></th>";
				$meta_form .= '<td>';
					switch ( $type ) {
						case 'divider':
							$meta_form .= '<hr/>';
							break;
						case 'markup':
							// will look for the desc key and display whatever it holds
							// this is for general markup needs... (e.g. if you need a button or image etc...)
							$meta_form .=  $field['desc'];
							break;
						case 'text':
							$meta_form .=  "<input type='text' name='{$id}' id='{$id}' value='{$meta}' size='30' />";
							$meta_form .=  '<br />';
							$meta_form .=  "<span class='description'>{$desc}</span>";
							break;
						case 'file':
							$meta_form .=  "<input type='text' name='{$id}' id='{$id}' value='{$meta}' size='30' />";
							$meta_form .=  "<a href='javascript:void();' class='upload-link-{$id} button'>upload</a>";
							$meta_form .=  '<br />';
							$meta_form .=  "<span class='description'>{$desc}</span>";
							break;
						case 'textarea':
							$meta_form .=  "<textarea name='{$id}' id='{$id}' cols='55' rows='4'>{$meta}</textarea>";
							$meta_form .=  '<br />';
							$meta_form .=  "<span class='description'>{$desc}</span>";
							break;
						case 'checkbox':
							$checked = ( $meta ) ? ' checked="checked"' : '';
							$meta_form .= "<input type='checkbox' name='{$id}' id='{$id}'{$checked}/>";
							$meta_form .= "<label for='{$id}'>$desc</label>";
							break;
						case 'select':
							$meta_form .= "<select name='{$id}' id='{$id}'>";
								foreach ( $options as $option ) {
									$option = $this->_esc_array_attr( $option );
									extract( $option );
									$selected = ( $value ) ? ' selected="selected"' : '';
									$meta_form .= "<option{$selected} value='{$value}'>{$label}</option>";
								} // foreach()
							$meta_form .=  '</select>';
							$meta_form .= '<br />';
							$meta_form .= "<span class='description'>{$desc}</span>";
							break;
						case 'chosen_select':
							// Requires: Chosen jQuery plugin http://harvesthq.github.io/chosen/
							$meta_form .= "<select name='{$id}' id='{$id}' class='chzn-select' style='width:200px;'>";
								foreach ( $options as $option ) {
									$option = $this->_esc_array_attr( $option );
									extract( $option );
									$selected = ( $value ) ? ' selected="selected"' : '';
									$meta_form .= "<option{$selected} value='{$value}'>{$label}</option>";
								} // foreach()
							$meta_form .= '</select>';
							$meta_form .= '<br />';
							$meta_form .= "<span class='description'>{$desc}</span>";
							break;
						// case 'chosen_select_multi':
						// 	$selection_array = explode( ',', $meta );

						// 	echo '<input type="text" name='{$id}' id='{$id}' value="'.$meta.'" style="display:none" />';
						// 	echo '<select name="chz_'.$id.'" id="chz_'.$id.'" multiple class="chzn-select" style="width:200px;">';
						// 	foreach ( $field['options'] as $option ) {


						// 		foreach ( $selection_array as $selection ) {
						// 			echo '<option', $selection == esc_attr( $option['value'] ) ? ' selected="selected"' : '', ' value="'.esc_attr( $option['value'] ).'">'.esc_attr( $option['label'] ).'</option>';
						// 		}
						// 	}
						// 	echo '</select><br /><span class="description">'.esc_attr( $field['desc'] ).'</span>';
						// 	break;

						// 	//date
						// case 'date':
						// 	echo '<input type="text" class="datepicker" name='{$id}' id='{$id}' value="'.$meta.'" size="30" />
						// 			<br /><span class="description">'.esc_attr( $field['desc'] ).'</span>';
						// 	break;

						// 	//line break
						// case 'line':
						// 	echo '</td></tr></table><hr/><table class="form-table">';
						// 	break;

						// 	//Title
						// case 'title':
						// 	echo '<div class="form-group-title">'.$label.'</div>';
						// 	break;

						// 	// multi_input
						// case 'multi_input':

						// 	// sorry if this is starting to feel like spaghetti
						// 	// moved this to a method to hide and encapsulate the logic

						// 	$this->make_multi_input_field( array(
						// 			'multi_fields' => $field['multi_fields'],
						// 			'id'   => $id,
						// 			'desc'   => $field['desc'],
						// 			'meta'   => $meta
						// 		) );

						// 	break;
					} // switch()
				$meta_form .= '</td>';
			$meta_form .= '</tr>';
		} // foreach()
		$meta_form .= '</table>';
	} // make_form()



	/**
	 * Esacpes all of the attributes
	 *
	 * @uses  esc_attr()
	 *
	 * @param  array  $unescaped Any form of unescaped content can be contained inside the array
	 *
	 * @return array             The escaped content
	 */
	protected function _esc_array_attr( $unescaped = array() )
	{
		$escaped = array();

		foreach ( $unescaped as $key => $value )
			$escaped[$key] = esc_attr( $value );

		return $escaped;
	} // _esc_array_attr()



	/**
	 * Creates a multi-input style form input
	 *
	 * @param  array  $args [description]
	 *
	 * @return [type]       [description]
	 */
	private function make_multi_input_field( $args = array() ) {
		// this method creates the multi-input field

		// get the fields
		$multi_fields  = isset( $args['multi_fields'] )  ? $args['multi_fields'] : '';
		$id    = isset( $args['id'] )    ? $args['id']    : '';
		$description  = isset( $args['desc'] )    ? $args['desc']   : '';
		$meta    = isset( $args['meta'] )    ? $args['meta']   : '';

		$json_fields = '\''.json_encode( $multi_fields ).'\' ';
		echo $description;
		echo '<div class="multi-input" id="'.$id.'_container">';
		echo '<input '.
			'type="text" '.
			'style="display:none;"'.
			'name="'.$id.'" '.
			'id="'.$id.'" '.
			'value="'.$meta.'" '.
			'size="30" '.
			'class="multi-input-field" '.   // JS will grab this class to start the magic
		'data-field-id="'.$id.'" '.    // JS uses this to identify this multi-input field
		'data-fields='.$json_fields.'" '.  // JS converts this to an object to manage the fields
		'/>';
		echo '</div>';
	} // make_multi_input_field()



	/**
	 * Saves your custom meta when the post is saved
	 * requires post_id and the meta fields in an array as an argument
	 *
 	 * Example:
	 * 	$meta_helper->save_custom_meta(array(
	 * 	'post_id' => 12,
	 * 	'fields'  => $meta_fields
	 * 	));
	 *
	 * @param string[]  $args {
	 * 	@type integer $post_id The post ID of the post the meta should be saved to
	 * 	@type array   $fields  The meta fields to be saved
	 * }
	 *
	 * @return Void
	 */
	public function save_custom_meta( $args = array() ) {
		extract( $args );

		$post_id = isset( $post_id ) ? $post_id : '';
		$fields = isset( $fields ) ? $fields : '';

		// verify nonce
		$mb_nonce = isset( $_POST['custom_meta_box_nonce'] ) ? $_POST['custom_meta_box_nonce'] : '';
		if ( !wp_verify_nonce( $mb_nonce, basename( __FILE__ ) ) )
			return $post_id;

		// check autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;

		// loop through fields and save the data
		foreach ( $fields as $field ) {
			$current = get_post_meta( $post_id, esc_attr( $field['id'] ), true );
			$new = isset( $_POST[esc_attr( $field['id'] )] ) ? $_POST[esc_attr( $field['id'] )] : '';

			if ( $new AND $new != $current )
				update_post_meta( $post_id, esc_attr( $field['id'] ), $new );
			elseif ( '' == $new && $current )
				delete_post_meta( $post_id, esc_attr( $field['id'] ), $current );
		} // foreach()
	} // save_custom_meta()



	/**
	 * Override this method to create custom meta fields.
	 *
	 * By returning an empty array in this method, we're telling the class to not to
	 * do anything will custom meta (e.g. meta boxes, and saving meta etc...)
	 * The overridden method should return an array like..
	 * return array(
	 * 	array(
	 * 		'label' => 'Title/Position',
	 * 		'desc'  => '',
	 * 		'id'    => $prefix.'Title',
	 * 		'type'  => 'text'
	 * 	),
	 * 	array(
	 * 		'label' => 'Quote',
	 * 		'desc'  => '',
	 * 		'id'    => $prefix.'Quote',
	 * 		'type'  => 'textarea'
	 * 	)
	 * );
	 *
	 * @return Array Custom meta fields for the current post type
	 */
	public function get_custom_meta_fields() {
		return array();
	} // get_custom_meta_fields()



	/**
	 * Handles registering and generating the custom meta box
	 *
	 * @return Void
	 */
	public function make_meta_box() {
		$custom_meta_fields = $this->get_custom_meta_fields();
		if ( empty( $custom_meta_fields ) )
			return;

		add_meta_box(
			$this->post_type_id.'_meta_box', // $id
			'Details',                       // $title
			array( $this, 'show_meta_box' ), // $callback
			$this->post_type,                // $page
			'normal',                        // $context
			'high'                           // $priority
		);
	} // make_meta_box()



	/**
	 * Handles outputting of the metabox form
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
	 * Handles the saving of custom meta
	 *
	 * @param  integer $post_id ID of the post that you wish to save custom meta for
	 *
	 * @return Void
	 */
	public function save_meta( $post_id ) {
		$custom_meta_fields = $this->get_custom_meta_fields();
		if ( empty( $custom_meta_fields ) )
			return;

		$this->save_custom_meta(array(
			'post_id'            => $post_id,
			'custom_meta_fields' => $custom_meta_fields
		));
	} // save_meta()
} // END Class MDG_Meta_Helper
