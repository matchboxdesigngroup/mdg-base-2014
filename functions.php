<?php
/**
 * Composer
 */
require_once locate_template( 'vendor/autoload.php' );

/**
 * Libs
 */
$libs = array(
	'utils',
	'init',
	'wrapper',
	'config',
	'activation',
	'titles',
	'cleanup',
	'gallery',
	'rewrites',
	'relative-urls',
	'widgets',
	'scripts',
	'custom',
	'debug',
	'shortcodes',
);

foreach ( $libs as $lib ) {
	$has_php = ( strpos( $lib, '.php' ) !== false );
	$lib     = ( $has_php ) ? $lib : "{$lib}.php";
	require_once locate_template( "/lib/{$lib}" );
} // foreach()



/**
 * Classes
 */
$classes = array(
	'class-mdg-generic',
	'class-mdg-form-fields',
	'class-mdg-meta-helper',
	'class-mdg-images',
	'class-mdg-type-base',
	'class-mdg-type-stub',
	'class-mdg-type-post',
	'class-mdg-type-page',
	'class-mdg-wp-admin',
	'class-mdg-walker-comments',
	'class-mdg-nav-walker',
	'class-mdg-sidebar',
	'class-mdg-settings',
);

foreach ( $classes as $class ) {
	$has_php = ( strpos( $class, '.php' ) !== false );
	$class   = ( $has_php ) ? $class : "{$class}.php";
	require_once locate_template( "/classes/{$class}" );
} // foreach()
