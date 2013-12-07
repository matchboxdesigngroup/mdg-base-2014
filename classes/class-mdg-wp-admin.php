<?php
/**
 * MDG WP Admin
 * Handles all wp-admin customizations
 *
 * @author Matchbox Design Group <info@matchboxdesigngroup.com>
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
	 * @internal Adds internal actions.
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

		// Add MDG dashboard widget
		add_action( 'wp_dashboard_setup', array( &$this, 'add_mdg_dashboard_widget' ) );
	} // _add_actions()



	/**
	 * Add filters.
	 *
	 * @internal Adds internal filters.
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
		$theme_img_base = '/assets/img/login-logo.png';
		$theme_img_uri  = get_template_directory().$theme_img_base;
		$theme_img_url  = get_template_directory_uri().$theme_img_base;

		if ( ! file_exists( $theme_img_uri ) ) {
			return;
		} // if()

		$style = '<style type="text/css">';
		$style .= '.login h1 a {';
		$style .= 'background-image: url("'.$theme_img_url.'");';
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

	function mdg_dashboard_widget_control_callback() {
	} // mdg_dashboard_widget_control_callback
} // End class MDG_WP_Admin()

// Set global instance
global $mdg_wp_admin;
$mdg_wp_admin = new MDG_WP_Admin();
