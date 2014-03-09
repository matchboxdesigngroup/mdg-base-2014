<?php
/**
 * Handles URL rewrites.
 *
 * @see          http://codex.wordpress.org/Class_Reference/WP_Rewrite
 *
 * @package      WordPress
 * @subpackage   MDG_Base
 */




/**
 * URL rewriting
 *
 * Rewrites do not happen for multisite installations or child themes
 *
 * Rewrite:
 *   /wp-content/themes/themename/assets/css/ to /assets/css/
 *   /wp-content/themes/themename/assets/js/  to /assets/js/
 *   /wp-content/themes/themename/assets/img/ to /assets/img/
 *   /wp-content/plugins/                     to /plugins/
 *
 * If you aren't using Apache, alternate configuration settings can be found in the docs.
 *
 * @link https://github.com/retlehs/roots/blob/master/doc/rewrites.md
 *
 * @see https://codex.wordpress.org/Plugin_API/Action_Reference/generate_rewrite_rules
 *
 * @param  object  $content  WordPress rewrite object.
 *
 * @return object            WordPress rewrite object with added rewrites.
 */
function mdg_add_rewrites( $content ) {
	global $wp_rewrite;
	$mdg_new_non_wp_rules = array(
		'assets/(.*)'  => THEME_PATH . '/assets/$1',
		'plugins/(.*)' => RELATIVE_PLUGIN_PATH . '/$1',
	);
	$wp_rewrite->non_wp_rules = array_merge( $wp_rewrite->non_wp_rules, $mdg_new_non_wp_rules );
	return $content;
} // mdg_add_rewrites



/**
 * Cleans URLs.
 *
 * @param   string  $content  URL content.
 *
 * @return  string            Cleaned URL content.
 */
function mdg_clean_urls( $content ) {
	if ( strpos( $content, RELATIVE_PLUGIN_PATH ) > 0 ) {
		return str_replace( '/' . RELATIVE_PLUGIN_PATH,  '/plugins', $content );
	} else {
		return str_replace( '/' . THEME_PATH, '', $content );
	} // if/else()
} // mdg_clean_urls()

if ( ! is_multisite() && ! is_child_theme() ) {
	if ( current_theme_supports( 'rewrites' ) ) {
		add_action( 'generate_rewrite_rules', 'mdg_add_rewrites' );
	} // if()

	if ( ! is_admin() && current_theme_supports( 'rewrites' ) ) {
		$tags = array(
			'plugins_url',
			'bloginfo',
			'stylesheet_directory_uri',
			'template_directory_uri',
			'script_loader_src',
			'style_loader_src',
		);

		add_filters( $tags, 'mdg_clean_urls' );
	} // if()
} // if()
