<?php
/**
 * This class contains anything to do with the AJAX requests.
 *
 * @version      0.2.3
 *
 * @package      WordPress
 * @subpackage   MDG_Base
 *
 * @since        0.2.3
 *
 * @author       Dan Holloran          <dholloran@matchboxdesigngroup.com>
 *
 * @copyright    2013 - Present         Dan Holloran
 */
if ( ! class_exists( 'MDG_Settings' ) ) {
	class MDG_Settings extends MDG_Form_Fields {
		/**
		 * The slug to be used for the options page.
		 *
		 * @since  0.2.3
		 *
		 * @var    string
		 */
		public $page_slug = 'mdg';



		/**
		 * @since  0.2.3 The options group to use.
		 *
		 * @var    string
		 */
		public $option_group = 'mdg_settings_group';



		/**
		 * MDG_Settings class constructor.
		 *
		 * @since  0.2.3
		 *
		 * @param  array  $config  Class configuration.
		 */
		public function __construct( $config = array() ) {
			parent::__construct();

			$this->_add_mdg_settings_actions_filters();
		} // __construct()



		/**
		 * Retrieves the settings fields for a specific settings group.
		 *
		 * <code$settings_fields = $this->get_settings_fields( $settings_group );</code>
		 *
		 * @since   0.2.3
		 *
		 * @param   array  $settings_group  The settings group to retrieve fields for.
		 *
		 * @return  array                   The setting fields for the specified group.
		 */
		public function get_settings_fields( $settings_group ) {
			$settings_fields = array();
			$options        = get_option( $this->option_group, array() );

			// General settings
			$settings_fields["{$this->page_slug}_general"] = $this->_get_general_settings_fields();

			if ( isset( $settings_fields[$settings_group] ) ) {
				return $settings_fields[$settings_group];
			}
			return array();
		} // get_settings_fields()


		/**
		 * Settings fields for the general settings group.
		 *
		 * <code>$settings_fields["{$this->page_slug}_general"] = $this->_get_general_settings_fields();</code>
		 *
		 * @since   0.2.3
		 *
		 * @todo    Fix WYSWIG not loading correct assets.
		 *
		 * @return  array  The setting fields for the general option group.
		 */
		private function _get_general_settings_fields() {
			$settings_fields = array();
			$prefix          = "{$this->page_slug}_general";

			// Description
			$settings_fields[] = array(
				'label'   => '',
				'desc'    => '<div class="mdg-note">Meta description.</div>',
				'id'      => 'info',
				'type'    => 'info',
				'visible' => false,
			);

			// Text
			$settings_fields[] = array(
				'label' => 'Text',
				'desc'  => 'Text description.',
				'id'    => "{$prefix}_text",
				'type'  => 'text',
			);

			// URL
			$settings_fields[] = array(
				'label' => 'URL',
				'desc'  => 'URL description.',
				'id'    => "{$prefix}_url",
				'type'  => 'url',
			);

			// Email
			$settings_fields[] = array(
				'label' => 'Email',
				'desc'  => 'Email description.',
				'id'    => "{$prefix}_email",
				'type'  => 'email',
			);

			// Divider
			$settings_fields[] = array(
				'type'  => 'divider',
			);

			// Markup
			$settings_fields[] = array(
				'label' => 'Markup',
				'desc'  => '<span>Custom markup: </span><a href="#">Link to nowhere</a>',
				'id'    => "{$prefix}_markup",
				'type'  => 'markup',
			);

			// File Upload
			$settings_fields[] = array(
				'label' => 'File Upload 1',
				'desc'  => 'File description.',
				'id'    => "{$prefix}_file_1",
				'type'  => 'file',
			);

			// File Upload
			$settings_fields[] = array(
				'label' => 'File Upload 2',
				'desc'  => 'File description.',
				'id'    => "{$prefix}_file_2",
				'type'  => 'file',
			);

			// Textarea
			$settings_fields[] = array(
				'label' => 'Textarea',
				'desc'  => 'Textarea description.',
				'id'    => "{$prefix}_textarea",
				'type'  => 'textarea',
			);

			// Checkbox
			$settings_fields[] = array(
				'label' => 'Checkbox',
				'desc'  => 'Checkbox description.',
				'id'    => "{$prefix}_checkbox",
				'type'  => 'checkbox',
			);

			// Radio
			$settings_fields[] = array(
				'label'   => 'Radio',
				'desc'    => 'Radio description.',
				'id'      => "{$prefix}_radio",
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
			$settings_fields[] = array(
				'label'   => 'Select',
				'desc'    => 'Select description.',
				'id'      => "{$prefix}_select",
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
			$settings_fields[] = array(
				'label'   => 'Chosen Select',
				'desc'    => 'Chosen select description.',
				'id'      => "{$prefix}_chosen_select",
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
			// $settings_fields[] = array(
			// 	'label'   => 'Chosen Select Multi',
			// 	'desc'    => 'Chosen select multi description.',
			// 	'id'      => "{$prefix}_chosen_select_multi",
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
			$settings_fields[] = array(
				'label' => 'Date',
				'desc'  => 'Date description.',
				'id'    => "{$prefix}_date",
				'type'  => 'date',
			);

			// Title
			$settings_fields[] = array(
				'label' => 'Title',
				'type'  => 'title',
			);

			// Color picker
			$settings_fields[] = array(
				'label' => 'Color Picker',
				'desc'  => 'Color Picker description.',
				'id'    => "{$prefix}_color_picker",
				'type'  => 'color_picker',
			);

			// WYSIWG Editor
			// You have to use html_entity_decode() when outputting the setting.
			// $settings_fields[] = array(
			// 	'label' => 'WYSIWG Editor',
			// 	'desc'  => 'WYSIWG Editor description.',
			// 	'id'    => "{$prefix}_wysiwg_editor",
			// 	'type'  => 'wysiwg_editor',
			// );

			return $settings_fields;
		} // _get_general_settings_fields()


		/**
		 * Handles adding all of the MDG_Base setting actions and filters.
		 *
		 * <code>$this->_add_mdg_settings_actions_filters();</code>
		 *
		 * @internal
		 *
		 * @since   0.2.3
		 *
		 * @return  void
		 */
		private function _add_mdg_settings_actions_filters() {
			add_action( 'admin_menu', array( &$this, 'admin_add_page' ) );
		} // _add_mdg_settings_actions_filters()



		/**
		 * Adds the administrator settings page to the menu.
		 *
		 * <code>add_action( 'admin_menu', array( &$this, 'admin_add_page' ) );</code>
		 *
		 * @since   0.2.3
		 *
		 * @return  void
		 */
		function admin_add_page() {
			$theme = wp_get_theme();
			add_theme_page( "{$theme->Name} Options", "{$theme->Name} Settings", 'manage_options', $this->page_slug, array( &$this, 'options_page' ) );
			add_action( 'admin_init', array( &$this, 'admin_init' ) );
		} // admin_add_page()



		/**
		 * Adds the option page content.
		 *
		 * <code>add_options_page( 'MDG_Base Settings', 'MDG_Base Settings', 'manage_options', $this->page_slug, array( &$this, 'options_page' ) );</code>
		 *
		 * @since   0.2.3
		 *
		 * @return  void
		 */
		function options_page() {
			get_template_part( 'templates/admin/theme-settings-page' );
		} // options_page()



		/**
		 * Adds the administrator settings.
		 *
		 * <code>add_action( 'admin_init', array( &$this, 'admin_init' ) );</code>
		 *
		 * @since   0.2.3
		 *
		 * @return  void
		 */
		function admin_init() {
			$general_settings_group = "{$this->page_slug}_general";
			register_setting( $this->option_group, $this->option_group, array( &$this, 'validate_options' ) );

			// General Settings Group
			add_settings_section( $general_settings_group, 'General Settings', array( &$this, 'general_section_text' ), $this->page_slug );
			$this->add_settings_fields( $general_settings_group );
		} // admin_init()



		/**
		 * General settings section text.
		 *
		 * @since 0.2.3
		 *
		 * <code>add_settings_section( $general_settings_group, 'General Settings', array( &$this, 'general_section_text' ), $this->page_slug );</code>
		 *
		 * @return  void
		 */
		function general_section_text() {
		} // general_section_text()



		/**
		 * Handles adding the settings fields for a specific group.
		 *
		 * <code>$this->add_settings_fields( $general_settings_group );</code>
		 *
		 * @since  0.2.3
		 *
		 * @param   string  $settings_group  The settings group the fields should be associated with.
		 *
		 * @return  void
		 */
		public function add_settings_fields( $settings_group ) {
			$settings_fields = $this->get_settings_fields( $settings_group );

			foreach ( $settings_fields as $field ) {
				$args = array(
					'field' => $field,
				);

				$id    = ( isset( $field['id'] ) ) ? $field['id'] : '';
				$label = ( isset( $field['label'] ) ) ? $field['label'] : '';
				add_settings_field( $id, $label, array( &$this, 'output_setting_field' ), $this->page_slug, $settings_group, $args );
			} // foreach()
		} // add_settings_fields()



		/**
		 * Text string setting.
		 *
		 * <code>add_settings_field( $id, $label, array( &$this, 'output_setting_field' ), $this->page_slug, $settings_group, $args );</code>
		 *
		 * @since   0.2.3
		 *
		 * @return  void
		 */
		function output_setting_field( $args ) {
			$field = ( isset( $args['field'] ) ) ? $args['field'] : false;

			if ( ! $field ) {
				return;
			} // if()

			// We do not need a label
			$field['label'] = '';

			$this->build_inputs( array( $field ), true );
		} // output_setting_field()



		/**
		 * Handles merging the new input options with the current options.
		 *
		 * @param   array  $inputs  The new submitted options.
		 *
		 * @return  array           The merged options.
		 */
		public function merge_options( $inputs ) {
			$options = get_option( $this->option_group, array() );
			$options = ( gettype( $options ) == 'array' ) ? $options : array();
			$options = array_merge( $options, $inputs );

			// Remove empty options
			foreach ( $options as $key => $option ) {
				if ( ! isset( $inputs[$key] ) ) {
					unset( $options[$key] );
				} // if()
			} // foreach()

			return $options;
		} // merge_options()



		/**
		 * Handles whitelisting options.
		 *
		 * @return  [type]  [description]
		 */
		public function faux_whitelist_options() {
			if ( ! isset( $_POST ) or empty( $_POST ) ) {
				return array();
			} // if()
			$whitelist = array();

			$inputs = $_POST;
			foreach ( $inputs as $key => $value ) {
				$faux_prefix = "faux_{$this->option_group}_";
				if ( strpos( $key, $faux_prefix ) === 0 and $value != '' ) {
					$faux_key = str_replace( $faux_prefix, '', $key );
					$whitelist[$faux_key] = $value;
				} // if()
			} // foreach()

			return $whitelist;
		} // faux_whitelist_options()



		/**
		 * Handles validating options.
		 *
		 * <code>register_setting( $this->option_group, $this->option_group, array( &$this, 'validate_options' ) );</code>
		 *
		 * @since   0.2.3
		 *
		 * @todo   Figure out why whitelisting is not working...???
		 *
		 * @param   array  $input  Submitted settings fields.
		 *
		 * @return  array          The validate settings fields.
		 */
		function validate_options( $input ) {
			$input   = $this->faux_whitelist_options();
			$options = $this->merge_options( $input );

			return $options;
		} // validate_options()



		/**
		 * Builds all of the inputs.
		 *
		 * <code>
		 * $attachment_fields = '';
		 * $input_fields      = array();
		 *
		 * // Attachment title
		 * $input_fields['post_title'] = array(
		 * 	'id'    => 'post_title',
		 *  'label' => 'Title',
		 *  'value' => $attachment->post_title,
		 *  'type'  => 'text',
		 *  'attrs' => array(),
		 * );
		 * $attachment_fields .= $wpba_form_fields->build_inputs( $input_fields );
		 *
		 * @since   0.2.3
		 *
		 * @todo    Document input types.
		 *
		 * @param   array    $inputs  The input(s) information (id,label,value,type,attrs).
		 * @param   boolean  $echo    Optional, if the inputs should be echoed out once built.
		 *
		 * @return  string           The input(s) HTML.
		 */
		public function build_inputs( $inputs = array(), $echo = false ) {
			$input_html   = '';
			$allowed_tags = $this->get_form_kses_allowed_html();
			$options      = get_option( $this->option_group, array() );


			foreach ( $inputs as $input ) {
				$id    = ( isset( $input['id'] ) ) ? $input['id'] : '';
				$value = ( isset( $options[$id] ) ) ? $options[$id] : '';

				// Allows for faux whitelisting to work
				if ( isset( $input['id'] ) ) {
					$input['id'] = "faux_{$this->option_group}_{$input['id']}";
				} // if()

				$input['name'] = ( isset( $input['name'] ) ) ? $input['name'] : "{$this->option_group}[{$id}]";
				$input_html    = $this->select_form_field( $input, $value, ! $echo );
			} // foreach()

			if ( $echo ) {
				echo wp_kses( $input_html, $allowed_tags );
			} // if()

			return $input_html;
		} // build_inputs()
	} // MDG_Settings()

	// Instantiate Class
	global $mdg_settings;
	$mdg_settings = new MDG_Settings();
} // if()