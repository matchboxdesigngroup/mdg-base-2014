<?php
if ( !function_exists( 'pp' ) ) {
	/**
	 * Pretty Print Debug Function
	 *
	 * @param mixed   $value Any value.
	 *
	 * @return [type]        [description]
	 */
	function pp( $value ) {
		$hosts = array(
			'127.0.0.1',
			'localhost',
			'10.0.2.2',
		);
		if ( ! in_array( $_SERVER['HTTP_HOST'], $hosts ) ) return;
		echo '<pre>';
		if ( $value ) {
			print_r( $value );
		} else {
			var_dump( $value );
		}
		echo '</pre>';
	}
} // if()



/**
 * Allows for testing on virtual machines like Virtual Box.
 * Since you have to use a different URL to test sometimes
 * this automates the process of changing the URL just add
 * your URL to the $hosts array with out the http:// or https://.
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
add_action( 'init', 'development_url_change' );
