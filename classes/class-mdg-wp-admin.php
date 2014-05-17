<?php
/**
 * MDG WP Admin Class
 */

/**
 * Handles all of the customizations wp-admin.
 *
 * @package      WordPress
 * @subpackage   MDG_Base
 *
 * @author       Matchbox Design Group <info@matchboxdesigngroup.com>
 */
class MDG_WP_Admin extends MDG_Generic
{
	/**
	 * Class constructor
	 *
	 * @param array   $config Class configuration
	 */
	public function __construct( $config = array() ) {
		parent::__construct();
		$this->_init();
	} // __construct()



	/**
	 * Initialization.
	 * Place all initialization code/logic here.
	 *
	 * @return Void
	 */
	private function _init() {
		$this->_add_actions();
		$this->_add_filters();
	} // _init()



	/**
	 * Add actions.
	 *
	 * @return Void
	 */
	private function _add_actions() {
		// Login logo.
		add_action( 'login_enqueue_scripts', array( &$this, 'login_logo' ) );

		// Removes default widgets.
		add_action( 'wp_dashboard_setup', array( &$this, 'remove_dashboard_widgets' ) );

		// Remove un-needed items from admin bar NEW+.
		add_action( 'wp_before_admin_bar_render', array( &$this, 'admin_bar_new_btn' ) );

		// Removes admin menu pages.
		add_action( 'admin_menu', array( &$this, 'remove_admin_menu_pages' ) );

		// Removes default widgets.
		add_action( 'widgets_init', array( &$this, 'remove_widgets' ), 1 );

		// Set default admin theme
		add_filter( 'get_user_option_admin_color', array( &$this, 'change_admin_color' ) );

		// Install plugins
		add_action( 'tgmpa_register', array( &$this, 'register_required_plugins' ) );

		// Meta upload thumbnail
		add_action( 'wp_ajax_mdg_meta_upload_thumb', array( &$this, 'mdg_meta_upload_thumb_callback' ) );

		// Add MDG dashboard widget
		// add_action( 'wp_dashboard_setup', array( &$this, 'add_mdg_dashboard_widget' ) );
	} // _add_actions()



	/**
	 * Add filters.
	 *@return Void
	 */
	private function _add_filters() {
		// Login logo URL title.
		add_filter( 'login_headertitle', array( &$this, 'login_logo_url_title' ) );

		// Login logo URL.
		add_filter( 'login_headerurl', array( &$this, 'login_logo_url' ) );

		// Makes Tiny MCE awesome.
		add_filter( 'tiny_mce_before_init', array( &$this, 'make_mce_awesome' ) );

		// Tiny MCE buttons 2.
		add_filter( 'mce_buttons_2', array( &$this, 'mce_buttons_2' ) );

		// Adds a custom style drop down to Tiny MCE.
		add_filter( 'tiny_mce_before_init', array( &$this, 'mce_before_init' ) );

		// Adds custom admin footer text.
		add_filter( 'admin_footer_text', array( &$this, 'custom_admin_footer' ) );
	} // _add_filters()


	/**
	 * Login logo title attribute.
	 *
	 * @return string Blog name.
	 */
	public function login_logo_url_title() {
		return get_bloginfo( 'name' );
	} // login_logo_url_title()



	/**
	 * Login logo.
	 *
	 * @return Void
	 */
	public function login_logo() {
		$theme_img_base = '/assets/img/w-logo-blue.png';
		$theme_img_uri  = get_template_directory().$theme_img_base;
		$theme_img_url  = get_template_directory_uri().$theme_img_base;

		$svg_theme_img_base = '/assets/img/wordpress-logo.svg';
		$svg_theme_img_uri  = get_template_directory().$theme_img_base;
		$svg_theme_img_url  = get_template_directory_uri().$theme_img_base;

		if ( ! file_exists( $theme_img_uri ) or ! file_exists( $svg_theme_img_uri )  ) {
			return;
		} // if()

		$style = '<style type="text/css">';
			$style .= '.login h1 a {';
				$style .= 'background-image: url("'.$theme_img_url.'");';
				$style .= 'background-image: none,url("'.$svg_theme_img_url.'");';
			$style .= '}';
		$style .= '</style>';

		echo $style;
	} // login_logo()



	/**
	 * Login logo link.
	 *
	 * @return string Home URL.
	 */
	public function login_logo_url() {
		return home_url();
	} // login_logo_url()



	/**
	 * Removes Links from New+.
	 *
	 * @return Void
	 */
	public function admin_bar_new_btn() {
		global $wp_admin_bar;

		// This removes the complete menu "Add New".
		// $wp_admin_bar->remove_menu( 'new-content' );

		// Hides the menu item "Post".
		// $wp_admin_bar->remove_menu( 'new-post' );

		// Hides the menu item "Page".
		// $wp_admin_bar->remove_menu( 'new-page' );

		// Hides the menu item "Media".
		// $wp_admin_bar->remove_menu( 'new-media' );

		// Hides the menu item "Link".
		// $wp_admin_bar->remove_menu( 'new-link' );

		// Hides the menu item "User".
		// $wp_admin_bar->remove_menu( 'new-user' );

		// Hides the menu item "Theme".
		// $wp_admin_bar->remove_menu( 'new-theme' );

		// Hides the menu item "Plugin".
		// $wp_admin_bar->remove_menu( 'new-plugin' );

		// Hides the menu item "POST_TYPE_NAME".
		// $wp_admin_bar->remove_menu( 'new-POST_TYPE_NAME' );
	} // admin_bar_new_btn()



	/**
	 * Remove Default Dashboard Widgets
	 *
	 * @return Void
	 */
	public function remove_dashboard_widgets() {
		// Removes Welcome Panel
		// remove_action( 'welcome_panel', 'wp_welcome_panel' );

		// Removes the incoming links dashboard widget
		// remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );

		// Removes the right now dashboard widget
		// remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );

		// Removes the recent comments dashboard widget
		// remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );

		// Removes the plugins dashboard widget
		// remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
		// Removes the not a current browser dashboard widget.
		// remove_meta_box( 'dashboard_browser_nag', 'dashboard', 'normal' );

		// Removes the quick press dashboard widget
		// remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );

		// Removes the recent drafts links dashboard widget
		// remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );

		// Removes the WordPress blog dashboard widget
		// remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );

		// Removes the other WordPress news dashboard widget
		// remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
	} // remove_dashboard_widgets()



	/**
	 * Custom admin footer text
	 *
	 * @return Void
	 */
	public function custom_admin_footer() {
		$client_name    = get_bloginfo( 'name' );
		$wp_version     = get_bloginfo( 'version' );
		$footer_content = "Built by <a href='http://matchboxdesigngroup.com' target='_blank'>Matchbox Design Group</a> powered by <a href='http://www.wordpress.org' target='_blank'>WordPress {$wp_version}</a>";
		$allowed_html = array(
			'a' => array(
				'href'   => array(),
				'target' => array(),
			),
		);

		echo wp_kses( $footer_content, $allowed_html );
	} // custom_admin_footer()



	/**
	 * Remove Administrator Menu Items.
	 *
	 * @return Void
	 */
	public function remove_admin_menu_pages() {
		// Use this to get the values to remove top menu pages
		// global $menu;
		// pp($menu);

		// Use this to get the values to remove sub menu pages
		// global $submenu;
		// pp($submenu);

		// Removes Posts menu page
		// remove_menu_page( 'edit.php' );

		// Remove Media menu page
		// remove_menu_page( 'upload.php' );

		// Remove Link menu page
		// remove_menu_page( 'link-manager.php' );

		// Removes Comments menu page
		// remove_menu_page( 'edit-comments.php' );

		// Removes Plugins menu page
		// remove_menu_page( 'plugins.php' );

		// Removes the Appearance > Theme sub-menu page
		// remove_submenu_page( 'themes.php', 'themes.php' );

		// Removes the Tools > Available Tools sub-menu page
		// remove_submenu_page( 'tools.php', 'tools.php' );

		// Removes the Tools > Import sub-menu page
		// remove_submenu_page( 'tools.php', 'import.php' );

		// Removes the Settings > Permalinks sub-menu page
		// remove_submenu_page( 'options-general.php', 'options-permalink.php' );
	} // remove_admin_menu_pages()



	/**
	 * Remove widgets.
	 *
	 * @return Void
	 */
	public function remove_widgets() {
		// Removes the default WordPress pages widget
		// unregister_widget('WP_Widget_Pages');

		// Removes the default WordPress calendar widget
		// unregister_widget( 'WP_Widget_Calendar' );

		// Removes the default WordPress archives widget
		// unregister_widget( 'WP_Widget_Archives' );

		// Removes the default WordPress links widget
		// unregister_widget( 'WP_Widget_Links' );

		// Removes the default WordPress meta widget
		// unregister_widget( 'WP_Widget_Meta' );

		// Removes the default WordPress search widget
		// unregister_widget('WP_Widget_Search');

		// Removes the default WordPress text widget
		// unregister_widget('WP_Widget_Text');

		// Removes the default WordPress categories widget
		// unregister_widget( 'WP_Widget_Categories' );

		// Removes the default WordPress recent widget
		// unregister_widget( 'WP_Widget_Recent_Posts' );

		// Removes the default WordPress recent comments widget
		// unregister_widget( 'WP_Widget_Recent_Comments' );

		// Removes the default WordPress RSS widget
		// unregister_widget( 'WP_Widget_RSS' );

		// Removes the default WordPress tag cloud widget
		// unregister_widget( 'WP_Widget_Tag_Cloud' );

		// Removes the default WordPress custom menu widget
		// unregister_widget('WP_Nav_Menu_Widget');
	} // remove_widgets()



	/**
	 * Make TinyMCE Editor Awesome.
	 *
	 * @param array   $init Tiny MCE initialization properties.
	 *
	 * @return array       Tiny MCE initialization properties.
	 */
	public function make_mce_awesome( $init ) {
		// Removes H1 tags (default 'p, address, pre, h1, h2, h3, h4, h5, h6')
		$init['theme_advanced_blockformats'] = 'p, h2, h3, h4, h5, h6, address, pre';

		// Adds some custom buttons
		$init['theme_advanced_buttons1_add'] = 'copy, cut, paste, redo, undo';

		// Adds some more custom buttons
		$init['theme_advanced_buttons2_add'] = 'anchor, hr, sub, sup';

		// Disables the WP help button
		$init['theme_advanced_disable'] = 'wp_help';

		return $init;
	} // make_mce_awesome($init)



	/**
	 * Tiny MCE Buttons 2, adds the style drop down.
	 *
	 * @param array   $buttons Tiny MCE level 2 buttons.
	 *
	 * @return array          Tiny MCE level 2 buttons.
	 */
	public function mce_buttons_2( $buttons ) {
		array_unshift( $buttons, 'styleselect' );
		return $buttons;
	} // mce_buttons_2($buttons)



	/**
	 * Adds a custom style drop down to Tiny MCE.
	 *
	 * @param array   $settings Tiny MCE settings.
	 *
	 * @return array           Tiny MCE settings.
	 */
	public function mce_before_init( $settings ) {
		$style_formats = array();

		// Styles
		$style_formats = array(
			array(
				'title'    => 'Button',
				'selector' => 'a',
				'classes'  => 'btn',
			),
		);

		$settings['style_formats'] = json_encode( $style_formats );

		return $settings;
	} // mce_before_init($settings)



	/**
	 * Forces the admin theme to use Midnight.
	 * It has a red that works well for Matchbox.
	 *
	 * @param String  $result  User administrator color scheme.
	 *
	 * @param String           Our default administrator color scheme.
	 */
	function change_admin_color( $result ) {
		return 'midnight';
	} // change_admin_color()



	/**
	 * Adds the MDG dashboard widget to the dashboard.
	 *
	 * @return Void
	 */
	function add_mdg_dashboard_widget() {
		wp_add_dashboard_widget(
			'mdg_dashboard_widget',
			'Matchbox Design Group',
			array( $this, 'mdg_dashboard_widget_callback' ),
			array( $this, 'mdg_dashboard_widget_control_callback' )
		);
	}



	/**
	 * Outputs/includes th MDG dashboard widgets content.
	 *
	 * @return Void
	 */
	function mdg_dashboard_widget_callback() {
		get_template_part( 'templates/widget', 'mdg-dashboard' );
	} // mdg_dashboard_widget_callback()



	/**
	 * Handles saving form fields for MDG dashboard widget.
	 *
	 * @todo Build widget.
	 *
	 * @return  Void
	 */
	function mdg_dashboard_widget_control_callback() {
	} // mdg_dashboard_widget_control_callback



	/**
	 * Register the required plugins for this theme.
	 *
	 * This function is hooked into tgmpa_init, which is fired within the
	 * TGM_Plugin_Activation class constructor.
	 *
	 * @example http://thomasgriffinmedia.com/blog/2011/09/automatically-install-plugins-with-themes-for-wordpress/
	 *
	 * @return Void
	 */
	function register_required_plugins() {
		if ( is_admin() and isset( $_GET['page'] ) and $_GET['page'] == 'theme_activation_options' ) {
			return ;
		}

		/**
		 * Array of plugin arrays. Required keys are name and slug.
		 * If the source is NOT from the .org repo, then source is also required.
		 */
		$plugins = array(

			// Packaged Plugins
			array(
				'name'               => 'Gravity Forms',
				'slug'               => 'gravityforms',
				'source'             => get_template_directory_uri() . '/dev-assets/packaged-plugins/gravityforms.zip', // The plugin source
				'required'           => false,
				'version'            => '',
				'force_activation'   => false,
				'force_deactivation' => false,
				'external_url'       => '',
			),
			array(
				'name'               => 'WordPress.com Thumbnail Editor',
				'slug'               => 'wpcom-thumbnail-editor',
				'source'             => get_template_directory_uri() . '/dev-assets/packaged-plugins/wpcom-thumbnail-editor.zip', // The plugin source
				'required'           => false,
				'version'            => '',
				'force_activation'   => false,
				'force_deactivation' => false,
				'external_url'       => '',
			),
			// WordPress.org Plugins
			array(
				'name'     => 'WordPress Importer',
				'slug'     => 'wordpress-importer',
				'required' => false,
			),
			array(
				'name'     => 'Regenerate Thumbnails',
				'slug'     => 'regenerate-thumbnails',
				'required' => false,
			),
			array(
				'name'     => 'BackWPup Free',
				'slug'     => 'backwpup',
				'required' => false,
			),
			array(
				'name'     => 'Jetpack',
				'slug'     => 'jetpack',
				'required' => false,
			),
			array(
				'name'     => 'Duplicate Post',
				'slug'     => 'duplicate-post',
				'required' => false,
			),
			array(
				'name'     => 'Launch Check',
				'slug'     => 'launch-check',
				'required' => false,
			),
			array(
				'name'     => 'Missing Content',
				'slug'     => 'missing-content',
				'required' => false,
			),
			array(
				'name'     => 'Yoast - WordPress SEO',
				'slug'     => 'wordpress-seo',
				'required' => false,
			),
			array(
				'name'     => 'Duplicate Post',
				'slug'     => 'duplicate-post',
				'required' => false,
			),
		);

		// Change this to your theme text domain, used for internationalising strings
		$theme_text_domain = 'roots';

		/**
		 * Array of configuration settings. Amend each line as needed.
		 * If you want the default strings to be available under your own theme domain,
		 * leave the strings uncommented.
		 * Some of the strings are added into a sprintf, so see the comments at the
		 * end of each line for what each argument will be.
		 */
		$config = array(
			'domain'           => $theme_text_domain,
			'default_path'     => get_template_directory_uri() . '/lib/plugins/',
			'parent_menu_slug' => 'themes.php',
			'parent_url_slug'  => 'themes.php',
			'menu'             => 'install-required-plugins',
			'has_notices'      => true,
			'is_automatic'     => true,
			'message'          => '',
			'strings'          => array(
				'page_title'                      => __( 'Install Required Plugins', $theme_text_domain ),
				'menu_title'                      => __( 'Install Plugins', $theme_text_domain ),
				'installing'                      => __( 'Installing Plugin: %s', $theme_text_domain ),
				'oops'                            => __( 'Something went wrong with the plugin API.', $theme_text_domain ),
				'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ),
				'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ),
				'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ),
				'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ),
				'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ),
				'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ),
				'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ),
				'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ),
				'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
				'activate_link'                   => _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
				'return'                          => __( 'Return to Required Plugins Installer', $theme_text_domain ),
				'plugin_activated'                => __( 'Plugin activated successfully.', $theme_text_domain ),
				'complete'                        => __( 'All plugins installed and activated successfully. %s', $theme_text_domain ),
				'nag_type'                        => 'error',
			),
		);

		tgmpa( $plugins, $config );
	} // register_required_plugins



	/**
	 * File upload thumbnail HTML AJAX request callback.
	 *
	 * @return  Void
	 */
	public function mdg_meta_upload_thumb_callback() {
		if ( ! isset( $_GET['fileSrc'] ) ) {
			echo json_encode( '' );
			exit;
		} // if()

		global $mdg_meta_form_fields;
		$thumbnail = $mdg_meta_form_fields->file_upload_field_thumbnail( $_GET['fileSrc'] );
		echo json_encode( $thumbnail );
		exit;
	} // mdg_meta_upload_thumb_callback
} // End class MDG_WP_Admin()

// Set global instance
global $mdg_wp_admin;
$mdg_wp_admin = new MDG_WP_Admin();
