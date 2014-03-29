<?php
/**
 * Allows for forcing a file to be downloaded instead of opened by the browser.
 * Uses wp_nonce_url() to verify the request is legitimate.
 *
 * @see http://codex.wordpress.org/Function_Reference/wp_nonce_url
 *
 * @todo Add a version that forces the user to login.
 *
 * <code>
 * <a href="<?php echo esc_url( wp_nonce_url( 'http://site.com/wp-content/uploads/my-file.php' ) ); ?>">My File(PDF)</a>
 * </code>
 */
require( '../../../../wp-blog-header.php' );

// Make sure it is a legitimate request.
if ( ! wp_verify_nonce( $_GET['_wpnonce'] ) ) {
	$redirect = ( isset( $_SERVER['HTTP_REFERER'] ) ) ? $_SERVER['HTTP_REFERER'] : home_url();
	wp_redirect( $redirect );
	die();
} // if()

// Download the file
$file = $_GET['file'];
if ( isset( $file ) ) {
	$type      = get_headers( $file, 1 )['Content-Type'];
	$pathinfo  = pathinfo( $file );
	$file_name = ( isset( $pathinfo['basename'] ) ) ? $pathinfo['basename'] : '';

	if ( ! is_null( $type ) and $file_name != '' ) {
		header( "Content-disposition: attachment; filename={$file_name}" );
		header( "Content-type: {$type}" );
		readfile( $file );
	} // if()
} // if()

// Redirect/close the window
if ( isset( $_SERVER['HTTP_REFERER'] ) ) {
	wp_redirect( $_SERVER['HTTP_REFERER'] );
	die();
} else {
	echo '<script>window.close();</script>';
} // if/else()

?>