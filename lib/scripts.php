<?php
/**
 * Handles adding JavaScript and CSS.
 *
 * @package      WordPress
 * @subpackage   MDG_Base
 */


/**
 * Enqueue front-end scripts and style-sheets
 *
 * @return Void
 */
function mdg_enqueue_site_scripts() {
	global $is_IE;

	$theme_uri = get_template_directory_uri();
	$ltie9     = preg_match( '/(?i)msie [6-8]/', $_SERVER['HTTP_USER_AGENT'] );

	// CSS
	if ( $ltie9 and $is_IE ) {
		// CSS for IE.
		wp_enqueue_style( 'main_css', "{$theme_uri}/assets/css/dist/main-ltie9.4ea5.min.css", array(), null, 'all' );
	} else {
		// CSS for good browsers.
		wp_enqueue_style( 'main_css', "{$theme_uri}/assets/css/dist/main.d93b.min.css", array(), null, 'all' );
	} // if/else()

	// jQuery is loaded using the same method from HTML5 Boilerplate:
	// Grab Google CDN's latest jQuery with a protocol relative URL; fallback to local if offline
	// It's kept in the header instead of footer to avoid conflicts with plugins.
	if ( ! is_admin() && current_theme_supports( 'jquery-cdn' ) ) {
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js', array(), null, false );
		add_filter( 'script_loader_src', 'mdg_jquery_local_fallback', 10, 2 );
	} // if()

	// Required for comments
	// if ( is_single() && comments_open() && get_option( 'thread_comments' ) ) {
	// 	wp_enqueue_script( 'comment-reply' );
	// } // if()

	// Reigster/Enqueue scripts for IE
	if ( $ltie9 and $is_IE ) {
		wp_register_script( 'css3pie_js', "{$theme_uri}/assets/js/vendor/css3pie-1.0.0.js", array( 'mdg_env_tests_js' ), null, false );
		wp_enqueue_script( 'css3pie_js' );
	} // if()


	// Reigster/Enqueue scripts for all browsers
	wp_register_script( 'mdg_env_tests_js', "{$theme_uri}/assets/js/dist/env-tests.1b49.min.js", array(), null, false );
	wp_enqueue_script( 'mdg_env_tests_js' );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-effects-core' );
	wp_register_script( 'main_js', "{$theme_uri}/assets/js/dist/scripts.0adb.min.js", array(), null, true );
	wp_enqueue_script( 'main_js' );
} // mdg_enqueue_site_scripts()
add_action( 'wp_enqueue_scripts', 'mdg_enqueue_site_scripts', 100 );



/**
 * Adds a global JS object.
 *
 * @return Void
 */
function mdg_add_global_js() {
	$ltie9 = preg_match( '/(?i)msie [6-8]/', $_SERVER['HTTP_USER_AGENT'] );
	// Add Global PHP -> JS
	$mdg_globals = array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'isIE'    => ( $ltie9 and $is_IE ),
	);
	$mdg_globals = json_encode( $mdg_globals ); ?>
	<script>var MDG_GLOBALS = <?php echo wp_kses( $mdg_globals, 'data' ); ?>;</script>
<?php } // mdg_add_global_js()
add_action( 'wp_head', 'mdg_add_global_js' );



/**
 * Enqueue administrator scripts/styles.
 *
 * @return Void
 */
function mdg_enqueue_admin_scripts() {
	global $is_IE;
	$theme_uri = get_template_directory_uri();
	$ltie9     = preg_match( '/(?i)msie [6-8]/', $_SERVER['HTTP_USER_AGENT'] );

	wp_enqueue_style( 'mdg-admin-css', "{$theme_uri}/assets/css/dist/admin.c833.min.css", array( 'wp-color-picker' ), null, 'all' );

	wp_register_script( 'admin_scripts', "{$theme_uri}/assets/js/dist/admin.b29c.min.js", array( 'jquery', 'jquery-ui-datepicker', 'wp-color-picker' ), null, true );

	// Add Global PHP -> JS
	$mdg_globals = array(
		'isIE' => ( $ltie9 and $is_IE ),
	);
	wp_localize_script( 'admin_scripts', 'MDG_GLOBALS', $mdg_globals );
	wp_enqueue_script( 'admin_scripts' );
} // mdg_enqueue_admin_scripts()
add_action( 'admin_enqueue_scripts', 'mdg_enqueue_admin_scripts', 100 );



/**
 * Adds a global JS object for wp-admin.
 *
 * @return Void
 */
function mdg_add_admin_global_js() {
	$ltie9 = preg_match( '/(?i)msie [6-8]/', $_SERVER['HTTP_USER_AGENT'] );
	// Add Global PHP -> JS
	$mdg_globals = array(
		'isIE' => ( $ltie9 and $is_IE ),
	);
	$mdg_globals = json_encode( $mdg_globals ); ?>
	<script>var MDG_GLOBALS = <?php echo wp_kses( $mdg_globals, 'data' ); ?>;</script>
<?php } // mdg_add_admin_global_js()
add_action( 'admin_head', 'mdg_add_admin_global_js' );



/**
 * jQuery local fallback
 *
 * @see http://wordpress.stackexchange.com/a/12450
 *
 * @param  string  $src    Script src.
 * @param  string  $handle Script handle.
 *
 * @return string          Script src.
 */
function mdg_jquery_local_fallback( $src, $handle ) {
	static $add_jquery_fallback = false;

	if ( $add_jquery_fallback ) {
		echo '<script>window.jQuery || document.write(\'<script src="' . get_template_directory_uri() . '/assets/js/vendor/jquery-1.11.0.min.js"><\/script>\')</script>' . "\n";
		$add_jquery_fallback = false;
	} // if()

	if ( $handle === 'jquery' ) {
		$add_jquery_fallback = true;
	} // if()

	return $src;
} // mdg_jquery_local_fallback()



/**
 * Adds the favicon for the site, login, and administrator section.
 * Add favicon.png to /assets/img/.
 *
 * @return Void
 */
function mdg_add_favicon() {
	echo '<link rel="icon" href="'.get_template_directory_uri().'/assets/img/favicon.png" type="image/png">';
} // mdg_add_favicon()
add_action( 'wp_head', 'mdg_add_favicon' );
add_action( 'admin_head', 'mdg_add_favicon' );


/**
 * Handles adding Google Analytics.
 *
 * <code>
 * add_action( 'wp_head', 'mdg_google_analytics', 20 );
 * </code>
 *
 * @return Void
 */
function mdg_google_analytics() { ?>
	<script>
		(function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
		function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
		e=o.createElement(i);r=o.getElementsByTagName(i)[0];
		e.src='//www.google-analytics.com/analytics.js';
		r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
		ga( 'create', '<?php echo esc_attr( GOOGLE_ANALYTICS_ID ); ?>');ga('send','pageview' );
	</script>
	<?php
} // mdg_google_analytics()

if ( GOOGLE_ANALYTICS_ID && ! current_user_can( 'manage_options' ) ) {
	add_action( 'wp_head', 'mdg_google_analytics', 20 );
} // if()
