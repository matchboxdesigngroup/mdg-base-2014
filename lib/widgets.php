<?php
/**
 * Register sidebars and widgets
 *
 * @link https://codex.wordpress.org/WordPress_Widgets
 *
 * @package      WordPress
 * @subpackage   MDG_Base
 */

/**
 * Initializes all widgets and sidebars.
 *
 * @see http://codex.wordpress.org/Function_Reference/register_sidebar
 * @see https://codex.wordpress.org/Function_Reference/register_widget
 *
 * @return  Void
 */
function mdg_widgets_init() {
	// Sidebars
	register_sidebar(
		array(
			'name'          => __( 'Primary', 'roots' ),
			'id'            => 'sidebar-primary',
			'before_widget' => '<section class="widget %1$s %2$s"><div class="widget-inner">',
			'after_widget'  => '</div></section>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
		)
	);

	// Widgets
	// register_widget( 'MDG_Vcard_Widget' );
} // mdg_widgets_init()
add_action( 'widgets_init', 'mdg_widgets_init' );



/**
 * Example vCard widget
 *
 * @see https://codex.wordpress.org/Widgets_API
 */
class MDG_Vcard_Widget extends WP_Widget {
	/**
	 * The widgets administrator form fields.
	 *
	 * @var  array
	 */
	private $fields = array(
		'title'          => 'Title (optional)',
		'street_address' => 'Street Address',
		'locality'       => 'City/Locality',
		'region'         => 'State/Region',
		'postal_code'    => 'Zipcode/Postal Code',
		'tel'            => 'Telephone',
		'email'          => 'Email',
	);



	/**
	 * Class constructor.
	 */
	function __construct() {
		$widget_ops = array(
			'classname'   => 'widget_mdg_vcard',
			'description' => __( 'Use this widget to add a vCard', 'roots' )
		);

		$this->WP_Widget( 'widget_mdg_vcard', __( 'Roots: vCard', 'roots' ), $widget_ops );
		$this->alt_option_name = 'widget_mdg_vcard';

		add_action( 'save_post', array( &$this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( &$this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array( &$this, 'flush_widget_cache' ) );
	} // __construct()



	/**
	 * Handles outputting the widget on the front end.
	 *
	 * @param   array  $args      The widgets configuration arguments.
	 * @param   array  $instance  The widgets content.
	 *
	 * @return  Void
	 */
	function widget( $args, $instance ) {
		$cache = wp_cache_get( 'widget_mdg_vcard', 'widget' );

		if ( ! is_array( $cache ) ) {
			$cache = array();
		} // if()

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = null;
		} // if()

		if ( isset( $cache[$args['widget_id']] ) ) {
			echo esc_attr( $cache[$args['widget_id']] );
			return;
		} // if()

		ob_start();
		extract( $args, EXTR_SKIP );

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'vCard', 'roots' ) : $instance['title'], $instance, $this->id_base );

		foreach ( $this->fields as $name => $label ) {
			if ( ! isset( $instance[$name] ) ) {
				$instance[$name] = '';
			} // if()
		} // foreach()

		echo wp_kses( $before_widget, 'post' );

		if ( $title ) {
			echo wp_kses( "{$before_title}{$title}{$after_title}", 'post' );
		} // if() ?>
		<p class="vcard">
			<a class="fn org url" href="<?php echo home_url( '/' ); ?>"><?php bloginfo( 'name' ); ?></a><br>
			<span class="adr">
				<span class="street-address"><?php echo esc_html( $instance['street_address'] ); ?></span><br>
				<span class="locality"><?php echo esc_html( $instance['locality'] ); ?></span>,
				<span class="region"><?php echo esc_html( $instance['region'] ); ?></span>
				<span class="postal-code"><?php echo esc_html( $instance['postal_code'] ); ?></span><br>
			</span>
			<span class="tel"><span class="value"><?php echo esc_html( $instance['tel'] ); ?></span></span><br>
			<a class="email" href="mailto:<?php echo esc_html( antispambot( $instance['email'] ) ); ?>"><?php echo esc_html( antispambot( $instance['email'] ) ); ?></a>
		</p>
		<?php
		echo wp_kses( $after_widget, 'post' );

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set( 'widget_mdg_vcard', $cache, 'widget' );
	} // widget()



	/**
	 * Handles setting/updating the widget options.
	 *
	 * @param   array $new_instance The new widget options.
	 * @param   array $old_instance The previous widget options.
	 *
	 * @return  array             The widget options.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = array_map( 'strip_tags', $new_instance );

		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );

		if ( isset( $alloptions['widget_mdg_vcard'] ) ) {
			delete_option( 'widget_mdg_vcard' );
		} // if()

		return $instance;
	} // update()



	/**
	 * Flushes the widgets cache.
	 *
	 * @return  Void
	 */
	function flush_widget_cache() {
		wp_cache_delete( 'widget_mdg_vcard', 'widget' );
	} // flush_widget_cache()



	/**
	 * Ouputs the options form on admin.
	 *
	 * @param array $instance The widget options
	 *
	 * @return Void
	 */
	function form( $instance ) {
		foreach ( $this->fields as $name => $label ) {
			${$name} = isset( $instance[$name] ) ? esc_attr( $instance[$name] ) : ''; ?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( $name ) ); ?>"><?php _e( "{$label}:", 'roots' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( $name ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $name ) ); ?>" type="text" value="<?php echo esc_attr( ${$name} ); ?>">
			</p>
		<?php
		} // foreach()
	} // form()
} // MDG_Vcard_Widget()
