<?php
/**
 * Debugging/Development specific functionality.
 *
 * @package      WordPress
 * @subpackage   MDG_Base
 *
 * @author       Matchbox Design Group <info@matchboxdesigngroup.com>
 */

if ( ! function_exists( 'pp' ) ) {
	/**
	 * Pretty Print Debug Function
	 *
	 * <code>
	 * pp( $something_to_pretty_print );
	 * </code>
	 *
	 * @param mixed   $value Any value.
	 *
	 * @return Void
	 */
	function pp( $value ) {
		global $mdg_generic;

		if ( ! $mdg_generic->is_localhost() ) return;
		echo '<pre>';
		if ( $value ) {
			print_r( $value );
		} else {
			var_dump( $value );
		}
		echo '</pre>';
	} // pp()
} // if()



/**
 * Allows for testing on virtual machines like Virtual Box.
 *
 * Since you have to use a different URL to test sometimes this automates the
 * process of changing the URL just add your URL to the $hosts array with
 * out the http:// or https://. If you are not using a vHost setup and browser-sync
 * you can uncomment add_action()
 *
 * @deprecated No longer used by internal code and not recommended.
 *
 * @return Void
 */
function development_url_change() {
	$site_url = site_url();
	$host     = $_SERVER['HTTP_HOST'];
	$hosts    = array(
		'localhost',
		'10.0.2.2',
	);

	if ( in_array( $host, $hosts ) and $site_url != "http://{$host}" ) {
		update_option( 'siteurl', "http://{$host}" );
		update_option( 'home', "http://{$host}" );
	} // if()
} // development_url_change()
// add_action( 'init', 'development_url_change' );


/**
 * Adds MDG toolbar body class on staging and localhost.
 *
 * @param   array  $classes  Current body classes.
 *
 * @return  array            Classes with MDG developer toolbar classes added.
 */
function mdg_toolbar_body_class( $classes ) {
	global $mdg_generic;
	if ( $mdg_generic->is_localhost() or $mdg_generic->is_staging() ) {
		$classes[] = 'mdg-dev-toolbar-active';
	}
	return $classes;
}
add_filter( 'body_class', 'mdg_toolbar_body_class' );



/**
 * Adds a localhost/staging bar for development purposes
 *
 * @return  void
 */
function mdgdev_tool_bar_html()
{
	global $mdg_generic;
	if ( $mdg_generic->is_localhost() ) {
		echo '<div class="mdg-dev-tool-bar mdg-dev-localhost">&nbsp;</div>';
	} elseif ( $mdg_generic->is_staging() ) {
		echo '<div class="mdg-dev-tool-bar mdg-dev-staging">&nbsp;</div>';
	} // if/elseif()
} // mdgdev_tool_bar_html()
add_action( 'wp_footer', 'mdgdev_tool_bar_html' );
add_action( 'admin_footer', 'mdgdev_tool_bar_html' );