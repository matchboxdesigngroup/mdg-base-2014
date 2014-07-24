<?php
/**
 * MDG Meta Form Fields Class.
 */

/**
 * Contains all of the custom meta form fields.
 *
 * @package      WordPress
 * @subpackage   MDG_Base
 *
 * @author       Matchbox Design Group <info@matchboxdesigngroup.com>
 */
class MDG_Form_Fields extends MDG_Generic {
	/**
	 * Class constructor
	 *
	 * @param array   $config Class configuration
	 */
	function __construct( $config = array() ) {
		parent::__construct();
	} // __construct()



	/**
	 * Creates a label for a form input field.
	 *
	 * <code>$this->label( $label, $id );</code>
	 *
	 * @since   0.2.3
	 *
	 * @param   string  $id     The input fields ID value.
	 * @param   string  $label  The text to be displayed in the label.
	 *
	 * @return  string          The label for the form input field.
	 */
	public function label( $id, $label ) {
		if ( $label == '' ) {
			return '';
		} // if()

		return "<label for='{$id}' class='pull-left'>{$label}</label>";
	} // label()



	/**
	 * Creates a description for a form input field.
	 *
	 * <code>$this->description( $description, $id );</code>
	 *
	 * @since   0.2.3
	 *
	 * @param   string  $description  The text to be displayed in the description.
	 *
	 * @return  string          The description for the form input field.
	 */
	public function description( $description ) {
		if ( $description == '' ) {
			return '';
		} // if()

		return "<p class='description'>{$description}</p>";
	} // description()



	/**
	 * Merges two sets of attributes together and combines them for a HTML element.
	 *
	 * <code>$input_attrs = $this->merge_element_attributes( $default_attrs, $attrs );</code>
	 *
	 * @since   0.2.3
	 *
	 * @param   array   $defaults  The default attributes.
	 * @param   array   $attrs     The supplied attributes
	 *
	 * @return  string             The merged HTML element attributes.
	 */
	public function merge_element_attributes( $defaults, $attrs ) {
		if ( gettype( $defaults ) != 'array' or gettype( $attrs ) != 'array' ) {
			return $attrs;
		} // if()

		// Merge the attributes together
		foreach ( $defaults as $key => $value ) {
			if ( isset( $attrs[$key] ) ) {
				$attrs[$key] = "{$attrs[$key]} {$value}";
			} else {
				$attrs[$key] = $value;
			} // if/else()
		} // foreach()

		// Flatten the attributes
		$input_attrs = array();
		foreach ( $attrs as $attr => $attr_value ) {
			$attr_value    = ( $attr == 'class' ) ? "{$attr_value} pull-left" : $attr_value;
			$input_attrs[] = esc_attr( "{$attr}={$attr_value}" );
		} // foreach()
		$input_attrs = trim( implode( ' ', $input_attrs ) );

		return $input_attrs;
	} // merge_element_attributes()



	/**
	 * All of the allowed tags when outputting form fields.
	 *
	 * <code>$allowed_html = $this->get_form_kses_allowed_html();</code>
	 *
	 * @since   0.2.3
	 *
	 * @return  array  Allowed HTML tags.
	 */
	public function get_form_kses_allowed_html() {
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
			'data-toggle' => array(),
		);

		$allowed_tags['checkbox'] = array(
			'type'        => array(),
			'name'        => array(),
			'id'          => array(),
			'value'       => array(),
			'size'        => array(),
			'class'       => array(),
			'placeholder' => array(),
			'checked'     => array(),
			'data-toggle' => array(),
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
		return $allowed_tags;
	} // get_form_kses_allowed_html()



	/**
	 * Creates a HTML text field and description.
	 *
	 * @param string  $id    id attribute
	 * @param string  $meta  meta value
	 * @param string  $desc  description
	 * @param array   $attrs Input attributes.
	 *
	 * @return string       The text field and description
	 */
	public function text_field( $id, $meta, $desc, $attrs = array() ) {
		$defaults = array(
			'class' => 'pull-left',
			'id'    => $id,
			'name'  => $id,
			'type'  => 'text',
			'size'  => '30',
		);
		$input_attrs = $this->merge_element_attributes( $defaults, $attrs );
		$text_field  = "<input {$input_attrs} value='{$meta}'>";
		$text_field .= $this->description( $desc );

		return $text_field;
	} // text_field()



	/**
	 * Creates a HTML email field and description.
	 *
	 * @param string  $id   id attribute
	 * @param string  $meta meta value
	 * @param string  $desc description
	 *
	 * @return string       The email field and description
	 */
	public function email_field( $id, $meta, $desc, $attrs = array() ) {
		$email_field = $this->text_field( $id, $meta, $desc, array( 'type' => 'email' ) );

		return $email_field;
	} // email_field()



	/**
	 * Creates a HTML URL field and description.
	 *
	 * @param string  $id   id attribute
	 * @param string  $meta meta value
	 * @param string  $desc description
	 *
	 * @return string       The URL field and description
	 */
	public function url_field( $id, $meta, $desc, $attrs = array() ) {
		$url_field = $this->text_field( $id, $meta, $desc, array( 'type' => 'url' ) );

		return $url_field;
	} // email_field()



	/**
	 * Creates a color picker.
	 *
	 * @param string  $id   id attribute
	 * @param string  $meta meta value
	 * @param string  $desc description
	 *
	 * @return string       The color picker and description
	 */
	public function color_picker( $id, $meta, $desc, $attrs = array() ) {
		$color_picker = $this->text_field( $id, $meta, $desc, array( 'class' => 'mdg-color-picker' ) );

		return $color_picker;
	} // color_picker()



	/**
	 * Creates a HTML input field and description.
	 *
	 * @param string  $id       id attribute
	 * @param string  $file_src meta value
	 * @param string  $desc     description
	 *
	 * @return string            The input field and description
	 */
	public function file_upload_field( $id, $file_src, $desc, $attrs = array() ) {
		$image_thumbnail = $this->file_upload_field_thumbnail( $file_src );

		$input_field  = '<div id="meta_upload_'.esc_attr( $id ).'" class="mdg-meta-upload">';
		$input_field .= '<input type="text" name="'.esc_attr( $id ).'" id="'.esc_attr( $id ).'" value="'.$file_src.'" size="30" />';
		$input_field .= '<a href="#" id="meta_upload_link_'.esc_attr( $id ).'" class="upload-link button">upload</a>';
		$input_field .= '<br>';
		$input_field .= '<div class="description">'.wp_kses( $desc, 'post' ).'</div>';
		$input_field .= $image_thumbnail;
		$input_field .= '</div>';
		return $input_field;
	}



	/**
	 * Retrieves file upload field thumbnails
	 *
	 * @param string  $file_src The files source url
	 *
	 * @return string           The image HTML or an empty string
	 */
	public function file_upload_field_thumbnail( $file_src ) {
		$file_id         = $this->get_attachment_id_from_src( $file_src );
		$image_thumbnail = '';

		if ( is_null( $file_id ) )
			return '';

		if ( ! wp_attachment_is_image( $file_id ) )
			return '';

		$image_sizes = get_intermediate_image_sizes();
		$width  = get_option( 'thumbnail' . '_size_w' );
		$height = get_option( 'thumbnail' . '_size_h' );

		$image_thumbnail .= '<br>';
		$image_thumbnail .= wp_get_attachment_image(
			$file_id,
			'thumbnail',
			false,
			array(
				'width'  => '150',
				'height' => '150',
				'class'  => 'meta-upload-thumb',
			)
		);

		return $image_thumbnail;
	} // file_upload_field_thumbnail()



	/**
	 * Creates a HTML textarea and description.
	 *
	 * @param string  $id   id attribute
	 * @param string  $meta meta value
	 * @param string  $desc description
	 *
	 * @return string            The input field and description
	 */
	public function textarea( $id, $meta, $desc, $attrs = array() ) {
		$textarea  = '<textarea name="'.esc_attr( $id ).'" id="'.esc_attr( $id ).'" cols="55" rows="4">'.$meta.'</textarea>';
		$textarea .= '<br>';
		$textarea .= '<div class="description">'.wp_kses( $desc, 'post' ).'</div>';

		return $textarea;
	} // textarea()



	/**
	 * Creates a HTML checkbox and description.
	 *
	 * @param string  $id   id attribute
	 * @param string  $meta meta value
	 * @param string  $desc description
	 *
	 * @return string            The input field and description
	 */
	public function checkbox( $id, $meta, $desc, $attrs = array() ) {
		$attrs = array(
			'type' => 'checkbox',
		);

		if ( $meta == 'on' )  {
			$attrs['checked'] = 'checked';
		} // if()

		$checkbox  = $this->text_field( $id, 'on', '', $attrs );
		$checkbox .= $this->label( $id, $desc );

		return $checkbox;
	} // checkbox()


	/**
	 * Creates a HTML radio and description.
	 *
	 * @param string  $id      id attribute
	 * @param string  $meta    meta value
	 * @param string  $desc    description
	 * @param array   $options select options
	 *
	 * @return string            The input field and description
	 */
	public function radio( $id, $meta, $desc, $options, $attrs = array() ) {
		$i     = 1;
		$radio = '';
		foreach ( $options as $option ) {
			extract( $option );
			$attrs = array(
				'type' => 'radio',
				'name' => $id,
			);

			if ( $value == $meta )  {
				$attrs['checked'] = 'checked';
			} // if()

			$radio .= $this->text_field( "{$id}_{$i}", $value, '', $attrs );
			$radio .= $this->label( "{$id}_{$i}", $desc ) . '<br>';
			$i      = $i + 1;
		} // foreach()
		$radio .= $this->description( $desc );

		return $radio;
	} // radio()


	/**
	 * Creates a HTML select and description.
	 *
	 * @param string  $id      id attribute
	 * @param string  $meta    meta value
	 * @param string  $desc    description
	 * @param array   $options select options
	 *
	 * @return string            The input field and description
	 */
	public function select( $id, $meta, $desc, $options, $attrs = array() ) {
		$defaults = array(
			'id'    => $id,
			'name'  => $id,
		);
		$input_attrs = $this->merge_element_attributes( $defaults, $attrs );

		$select = "<select {$input_attrs}>";
		foreach ( $options as $option ) {
			extract( $option );
			$selected = ( $value == $meta ) ? ' selected="selected"' : '';
			$select  .= '<option value="'.esc_attr( $value ).'"'.$selected.'>'.esc_attr( $label ).'</option>';
		} // foreach()
		$select .= '</select>';
		$select .= $this->description( $desc );

		return $select;
	} // select()



	/**
	 * Creates a HTML chosen select and description.
	 *
	 * @param string  $id      id attribute
	 * @param string  $meta    meta value
	 * @param string  $desc    description
	 * @param array   $options select options
	 *
	 * @return string            The input field and description
	 */
	public function chosen_select( $id, $meta, $desc, $options, $attrs = array() ) {
		$attrs = array(
			'class' => 'mdg-chosen-select',
			'style' => 'width:200px;',
		);
		$select = $this->select( $id, $meta, $desc, $options, $attrs );

		return $select;
	} // chosen_select()



	/**
	 * Creates a HTML chosen select multiple and description.
	 *
	 * @todo    Fix chosen multi not saving correctly.
	 *
	 * @param string  $id      id attribute
	 * @param string  $meta    meta value
	 * @param string  $desc    description
	 * @param array   $options select options
	 *
	 * @return string            The input field and description
	 */
	public function chosen_select_multi( $id, $meta, $desc, $options, $attrs = array() ) {
		$id = "{$id}_multi_chosen";

		$attrs = array(
			'name'    => $id,
			'multiple' => 'multiple',
			'class'    => 'mdg-chosen-select',
			'style'    => 'width:200px;',
		);
		$select = $this->select( $id, $meta, $desc, $options, $attrs );

		return $select;

		return $select;
	} // chosen_select_multi()



	/**
	 * Creates a date picker.
	 *
	 * @param string  $id           Id attribute.
	 * @param string  $meta         Meta value.
	 * @param string  $desc         Description.
	 * @param string  $date_format  Optional, JavaScript date format default DD, MM d, yy.
	 *
	 * @return string       The date picker and description
	 */
	public function datepicker( $id, $meta, $desc, $date_format = 'DD, MM d, yy', $attrs = array() ) {
		$attrs = array(
			'data-format' => $date_format,
			'class'       => 'mdg-datepicker datepicker',
		);

		$datepicker = $this->text_field( $id, $meta, $desc, $attrs );

		return $datepicker;
	} // datepicker()



	/**
	 * Creates a HTML text area WYSWIG editor and description.
	 *
	 * @param string  $id    id attribute
	 * @param string  $meta  meta value
	 * @param string  $desc  description
	 * @param string  $args  Customize wp_editor arguments.
	 *
	 * @return string            The text area and description
	 */
	public function wysiwg_editor( $id, $meta, $desc = '', $args = array() ) {
		$meta = html_entity_decode( $meta );
		$wysiwg_editor = '';
		$default_args  = array(
			'teeny'         => false,
			'editor_class'  => 'mdg-wyswig-editor',
			'textarea_rows' => 8,
		);
		$wp_editor_settings = array_merge( $default_args, $args );
		ob_start();
		wp_editor( $meta, $id, $wp_editor_settings );
		$wysiwg_editor .= ob_get_clean();

		$wysiwg_editor .= '<br>';
		$wysiwg_editor .= '<span class="description">'.esc_attr( $desc ).'</span>';

		return $wysiwg_editor;
	} // wysiwg_editor()



	/**
	 * Makes the multi field input
	 *
	 * @todo Document and fix this method better.
	 *
	 * @param array   $args  The input field arguments.
	 *
	 * @return string The multi input field and description.
	 */
	public function multi_input_field( $args = array() ) {
		// get the fields
		$multi_fields = isset( $multi_fields ) ? $multi_fields : '';
		$id           = isset( $id ) ? $id : '';
		$description  = isset( $args['desc'] ) ? $args['desc'] : '';
		$meta         = isset( $args['meta'] ) ? $args['meta'] : '';

		$json_fields = '\''.json_encode( $multi_fields ).'\' ';
		echo wp_kses( $description, 'post' );
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
	} // multi_input_field()



	/**
	 * Handles selecting and optionally outputting
	 *
	 * @since   0.2.3
	 *
	 * @param   boolean  Optional, if the form field should be output, default true.
	 *
	 * @return  string  The form field HTML
	 */
	public function select_form_field( $field, $value, $echo = true ) {
		$allowed_tags = $this->get_form_kses_allowed_html();
		$input_field  = '';
		$type         = ( isset( $field['type'] ) ) ? $field['type'] : '';
		$id           = ( isset( $field['id'] ) ) ? $field['id'] : '';
		$meta         = $value;
		$desc         = ( isset( $field['desc'] ) ) ? $field['desc'] : '';
		$options      = ( isset( $field['options'] ) ) ? $field['options'] : array();
		$date_format  = ( isset( $field['date_format'] ) ) ? $field['date_format'] : 'DD, MM d, yy';
		$label        = ( isset( $field['label'] ) ) ? $field['label'] : '';
		$args         = ( isset( $field['args'] ) ) ? $field['args'] : array();

		switch ( $type ) {
			case 'divider':
				$input_field = '<hr>';
				break;

			case 'markup':
				$input_field = $desc;
				break;

			case 'text':
				$input_field = $this->text_field( $id, $meta, $desc );
				break;

			case 'email':
				$input_field = $this->email_field( $id, $meta, $desc );
				break;

			case 'url':
				$input_field = $this->url_field( $id, $meta, $desc );
				break;

			case 'file':
				$input_field = $this->file_upload_field( $id, $meta, $desc );
				break;

			case 'textarea':
				$input_field = $this->textarea( $id, $meta, $desc );
				break;

			case 'checkbox':
				$input_field = $this->checkbox( $id, $meta, $desc );
				break;

			case 'radio':
				$input_field = $this->radio( $id, $meta, $desc, $options );
				break;

			case 'select':
				$input_field = $this->select( $id, $meta, $desc, $options );
				break;

			case 'chosen_select':
				$input_field = $this->chosen_select( $id, $meta, $desc, $options );
				break;

			case 'chosen_select_multi':
				$input_field = $this->chosen_select_multi( $id, $meta, $desc, $options );
				break;

			case 'date':
				$input_field = $this->datepicker( $id, $meta, $desc, $date_format );
				break;

			case 'title':
				$input_field = '<div class="form-group-title">'.esc_attr( $label ).'</div>';
				break;

			case 'wysiwg_editor':
				$input_field = $this->wysiwg_editor( $id, $meta, $desc, $args );
				break;

			case 'multi_input':
				$input_field = $this->multi_input_field(
					array(
						'multi_fields' => $multi_fields,
						'id'           => $id,
						'desc'         => $desc,
						'meta'         => $meta,
					)
				);
				break;

			case 'color_picker':
				$input_field = $this->color_picker( $id, $meta, $desc );
				break;
		} // switch()

		if ( $echo ) {
			echo wp_kses( $input_field, $allowed_tags );
		} // if()

		return $input_field;
	} // select_form_field()
} // End class MDG_Form_Fields()

global $mdg_form_fields;
$mdg_form_fields = new MDG_Form_Fields();
