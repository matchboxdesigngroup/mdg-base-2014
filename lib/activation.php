<?php
/**
 * Handles theme activation.
 *
 * @package      WordPress
 * @subpackage   MDG_Base
 */
if ( is_admin() && isset( $_GET['activated'] ) && 'themes.php' == $GLOBALS['pagenow'] ) {
	wp_redirect( admin_url( 'themes.php?page=theme_activation_options' ) );
	exit;
} // if()



/**
 * Initializes theme options.
 *
 * @return  Void
 */
function mdg_theme_activation_options_init() {
	register_setting(
		'mdg_activation_options',
		'mdg_theme_activation_options'
	);
} // mdg_theme_activation_options_init()
add_action( 'admin_init', 'mdg_theme_activation_options_init' );



/**
 * Sets the capability as user must have to access the theme options page
 *
 * @param   String  $capability  The current capability value.
 *
 * @return  String               The new capability value.
 */
function mdg_activation_options_page_capability( $capability ) {
	return 'edit_theme_options';
} // mdg_activation_options_page_capability()
add_filter( 'option_page_capability_mdg_activation_options', 'mdg_activation_options_page_capability' );



/**
 * Adds the theme options page.
 *
 * @return  Void
 */
function mdg_theme_activation_options_add_page() {
	$mdg_activation_options = mdg_get_theme_activation_options();

	if ( ! $mdg_activation_options ) {
		$theme_page = add_theme_page(
			__( 'Theme Activation', 'roots' ),
			__( 'Theme Activation', 'roots' ),
			'edit_theme_options',
			'theme_activation_options',
			'mdg_theme_activation_options_render_page'
		);
	} else {
		if ( is_admin() && isset( $_GET['page'] ) && $_GET['page'] === 'theme_activation_options' ) {
			flush_rewrite_rules();
			wp_redirect( admin_url( 'themes.php' ) );
			exit;
		} // if()
	} // if/else()
} // mdg_theme_activation_options_add_page()
add_action( 'admin_menu', 'mdg_theme_activation_options_add_page', 50 );



/**
 * Retrieves the theme activation options
 *
 * @example $mdg_theme_activation_options = mdg_get_theme_activation_options();
 *
 * @return  array  The current theme options.
 */
function mdg_get_theme_activation_options() {
	return get_option( 'mdg_theme_activation_options' );
}



/**
 * Renders the theme activation page.
 *
 * @return  Void
 */
function mdg_theme_activation_options_render_page() { ?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2><?php printf( __( '%s Theme Activation', 'roots' ), wp_get_theme() ); ?></h2>
		<?php settings_errors(); ?>

		<form method="post" action="options.php">

			<?php
	settings_fields( 'mdg_activation_options' ); ?>

			<table class="form-table">

				<tr valign="top"><th scope="row"><?php _e( 'Create static front page?', 'roots' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Create static front page?', 'roots' ); ?></span></legend>
							<select name="mdg_theme_activation_options[create_front_page]" id="create_front_page">
								<option selected="selected" value="true"><?php echo esc_html( _e( 'Yes', 'roots' ) ); ?></option>
								<option value="false"><?php echo esc_html( _e( 'No', 'roots' ) ); ?></option>
							</select>
							<br>
							<small class="description"><?php printf( __( 'Create a page called Home and set it to be the static front page', 'roots' ) ); ?></small>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Change permalink structure?', 'roots' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Update permalink structure?', 'roots' ); ?></span></legend>
							<select name="mdg_theme_activation_options[change_permalink_structure]" id="change_permalink_structure">
								<option selected="selected" value="true"><?php echo esc_html( _e( 'Yes', 'roots' ) ); ?></option>
								<option value="false"><?php echo esc_html( _e( 'No', 'roots' ) ); ?></option>
							</select>
							<br>
							<small class="description"><?php printf( __( 'Change permalink structure to /&#37;postname&#37;/', 'roots' ) ); ?></small>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Create navigation menu?', 'roots' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Create navigation menu?', 'roots' ); ?></span></legend>
							<select name="mdg_theme_activation_options[create_navigation_menus]" id="create_navigation_menus">
								<option selected="selected" value="true"><?php echo esc_html( _e( 'Yes', 'roots' ) ); ?></option>
								<option value="false"><?php echo esc_html( _e( 'No', 'roots' ) ); ?></option>
							</select>
							<br>
							<small class="description"><?php printf( __( 'Create the Primary Navigation menu and set the location', 'roots' ) ); ?></small>
						</fieldset>
					</td>
				</tr>

				<!-- <tr valign="top"><th scope="row"><?php _e( 'Add pages to menu?', 'roots' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Add pages to menu?', 'roots' ); ?></span></legend>
							<select name="mdg_theme_activation_options[add_pages_to_primary_navigation]" id="add_pages_to_primary_navigation">
								<option selected="selected" value="true"><?php echo esc_html( _e( 'Yes', 'roots' ) ); ?></option>
								<option value="false"><?php echo esc_html( _e( 'No', 'roots' ) ); ?></option>
							</select>
							<br>
							<small class="description"><?php printf( __( 'Add all current published pages to the Primary Navigation', 'roots' ) ); ?></small>
						</fieldset>
					</td>
				</tr> -->

			</table>

			<?php submit_button(); ?>
		</form>
	</div>
	<?php
} // mdg_theme_activation_options_render_page()



/**
 * Handles theme activation.
 *
 * @return  Void
 */
function mdg_theme_activation_action() {
	if ( ! ( $mdg_theme_activation_options = mdg_get_theme_activation_options() ) ) {
		return;
	} // if()

	if ( strpos( wp_get_referer(), 'page=theme_activation_options' ) === false ) {
		return;
	} // if()

	if ( $mdg_theme_activation_options['create_front_page'] === 'true' ) {
		$mdg_theme_activation_options['create_front_page'] = false;

		$default_pages  = array( 'Home' );
		$existing_pages = get_pages();
		$temp = array();

		foreach ( $existing_pages as $page ) {
			$temp[] = $page->post_title;
		} // foreach()

		$pages_to_create = array_diff( $default_pages, $temp );

		foreach ( $pages_to_create as $new_page_title ) {
			$add_default_pages = array(
				'post_title'   => $new_page_title,
				'post_content' => '',
				'post_status'   => 'publish',
				'post_type'     => 'page',
			);

			$result = wp_insert_post( $add_default_pages );
		} // foreach()

		$home = get_page_by_title( 'Home' );
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home->ID );

		$home_menu_order = array(
			'ID'         => $home->ID,
			'menu_order' => -1,
		);
		wp_update_post( $home_menu_order );
	} // if()

	// Remove Sample Page and Hello world!
	$sample_page = get_page_by_title( 'Sample Page', OBJECT, 'page' );
	$hello_world = get_page_by_title( 'Hello world!', OBJECT, 'post' );

	if ( ! is_null( $sample_page ) ) {
		wp_delete_post( $sample_page->ID, true );
	} // if()

	if ( ! is_null( $hello_world ) ) {
		wp_delete_post( $hello_world->ID, true );
	} // if()

	if ( $mdg_theme_activation_options['change_permalink_structure'] === 'true' ) {
		$mdg_theme_activation_options['change_permalink_structure'] = false;

		if ( get_option( 'permalink_structure' ) !== '/%postname%/' ) {
			global $wp_rewrite;
			$wp_rewrite->set_permalink_structure( '/%postname%/' );
			flush_rewrite_rules();
		} // if()
	} // if()

	if ( $mdg_theme_activation_options['create_navigation_menus'] === 'true' ) {
		$mdg_theme_activation_options['create_navigation_menus'] = false;

		$mdg_nav_theme_mod = false;

		$primary_nav = wp_get_nav_menu_object( 'Primary Navigation' );

		if ( ! $primary_nav ) {
			$primary_nav_id = wp_create_nav_menu( 'Primary Navigation', array( 'slug' => 'primary_navigation' ) );
			$mdg_nav_theme_mod['primary_navigation'] = $primary_nav_id;
		} else {
			$mdg_nav_theme_mod['primary_navigation'] = $primary_nav->term_id;
		} // if/else()

		if ( $mdg_nav_theme_mod ) {
			set_theme_mod( 'nav_menu_locations', $mdg_nav_theme_mod );
		} // if()
	} // if()

	if ( $mdg_theme_activation_options['add_pages_to_primary_navigation'] === 'true' ) {
		$mdg_theme_activation_options['add_pages_to_primary_navigation'] = false;

		$primary_nav = wp_get_nav_menu_object( 'Primary Navigation' );
		$primary_nav_term_id = (int) $primary_nav->term_id;
		$menu_items = wp_get_nav_menu_items( $primary_nav_term_id );

		if ( ! $menu_items || empty( $menu_items ) ) {
			$pages = get_pages();
			foreach ( $pages as $page ) {
				$item = array(
					'menu-item-object-id' => $page->ID,
					'menu-item-object'    => 'page',
					'menu-item-type'      => 'post_type',
					'menu-item-status'    => 'publish',
				);
				wp_update_nav_menu_item( $primary_nav_term_id, 0, $item );
			} // if()
		} // if()
	} // if()

	update_option( 'mdg_theme_activation_options', $mdg_theme_activation_options );
} // mdg_theme_activation_action()
add_action( 'admin_init', 'mdg_theme_activation_action' );



/**
 * Handles theme deactivation.
 *
 * @return  Void
 */
function mdg_deactivation() {
	delete_option( 'mdg_theme_activation_options' );
} // mdg_deactivation()
add_action( 'switch_theme', 'mdg_deactivation' );
