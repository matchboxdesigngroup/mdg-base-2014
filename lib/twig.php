<?php
add_filter( 'get_twig', 'add_to_twig' );
add_filter( 'timber_context', 'add_to_context' );


/**
 * Add data to Twig context.
 *
 * @param   array  $data  Twig context data.
 *
 * @return  array         Modified Twig context data.
 */
function add_to_context( $data ) {
	$data = base_twig_context( $data );
	$data = header_twig_context( $data );
	$data = footer_twig_context( $data );

	return $data;
} // add_to_context()
define( 'THEME_URL', get_template_directory_uri() );


/**
 * Sets up base twig context.
 *
 * @param   array  $data  Twig context data.
 *
 * @return  array         Modified Twig context data.
 */
function base_twig_context( $data ) {
	$data['home_url']              = esc_url( home_url() );
	$data['blog_name']             = esc_attr( get_bloginfo( 'name' ) );
	$date['wp_title']              = esc_attr( wp_title( '|', false, 'right' ) );
	$data['main_class']            = esc_attr( roots_main_class() );
	$data['roots_display_sidebar'] = roots_display_sidebar();

	return $data;
} // base_twig_context()



/**
 * Sets up header twig context.
 *
 * @param   array  $data  Twig context data.
 *
 * @return  array         Modified Twig context data.
 */
function header_twig_context( $data ) {
	$bootstrap_nav_bar            = current_theme_supports( 'bootstrap-top-navbar' );
	$data['bootstrap_top_navbar'] = $bootstrap_nav_bar;
	$data['has_primary_menu']     = has_nav_menu( 'primary_navigation' );

	$primary_navigation_attrs = array(
		'theme_location' => 'primary_navigation',
		'menu_class'     => ( $bootstrap_nav_bar ) ? 'nav navbar-nav primary-nav-menu-wrap' : 'nav nav-pills primary-nav-menu-wrap',
		'echo'           => false,
	);
	$data['primary_navigation'] = wp_nav_menu( $primary_navigation_attrs );

	$data['display_page_header'] = ( ! is_front_page() );
	$data['page_title']          = roots_title();


	return $data;
} // header_twig_context()



/**
 * Sets up footer twig context.
 *
 * @param   array  $data  Twig context data.
 *
 * @return  array         Modified Twig context data.
 */
function footer_twig_context( $data ) {

	return $data;
} // footer_twig_context()



/**
 * Adds functions to be used twig templates.
 *
 * @param  object  $twig  Twig object.
 *
 * @return object         Twig object.
 */
function add_to_twig( $twig ) {
	$home_url = new Twig_Filter_Function( 'home_url' );
	$twig->addFilter( 'home_url', $home_url );
	return $twig;
} // add_to_twig()