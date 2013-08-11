<?php

/**
 * MDG (Post) Type Base
 *
 * This is a base for custom post type classes so they can all take advantage of the same logic for meta, transients etc.
 *
 * You should do your best not to overwrite any method and to use the
 * custom_[some_property] properties for configuring the base class methods which have parameters.
 * Feel free to over write any of the parameters you see fit to make the sub-classes
 * more versatile.  As with every rule there is in exception do not overwrite $meta_helper
 * unless you know what you are doing...which if your over writing it you probably do not.
 * Make sure to include the parameters marked as REQUIRED or else the class will
 * not work at all everything has sensible defaults.
 *
 * @author Matchbox Design Group <info@matchboxdesigngroup.com>
 *
 * @example mdg-bases/classes/class-mdg-type-stub.php
 *
 * @todo  Possibly abstract some of the get_posts and transients outside of this class
 */
class MDG_Type_Base extends MDG_Meta_Helper {
	/** @var string  REQUIRED for caching (you should override this) */
	public $transient_title = null;
	/** @var string  REQUIRED slug */
	public $post_type = null;
	/** @var string  REQUIRED title of post type */
	public $post_type_title = null;
	/** @var string  REQUIRED singular title */
	public $post_type_single = null;
	/** @var array   Holds all of the custom transient titles */
	public $custom_transient_titles = array();
	/** @var integer Will set on construct */
	public $transient_expiry = null;
	/** @var array   Will hold array of post objects */
	public $posts = null;
	/** @var string  Post type ID name */
	public $post_type_id = null;
	/** @var array   Arguments to be used when registering the post type */
	public $post_type_args = null;
	/** @var array   Arguments to be used when registering the post type's taxonomy */
	public $taxonomy_args = null;
	/** @var integer -1 for all or a specific integer for posts returned default -1 */
	public $query_limit = null;
	/** @var array   What the post type supports */
	public $post_type_supports = null;
	/** @var array   Custom post type arguments used in register_post_type() */
	public $custom_post_type_args = null;
	/** @var array   Custom taxonomy arguments used in register_taxonomy() */
	public $custom_taxonomy_args  = null;
	/** @var array   Custom post type supports array used in register_post_type() */
	public $custom_post_type_supports = null;



	/**
	 * Class constructor, takes care of all the setup needed
	 */
	public function __construct() {
		parent::__construct();
		// first make sure the sub class has the required properties
		if ( ! $this->passed_config_test() )
			return false;

		$this->set_parameters();
		$this->type_base_add_actions();
		$this->init();
	} // __construct()



	/**
	 * Sets all of the classes parameters
	 *
	 * @return Void
	 */
	public function set_parameters() {
		$this->custom_transient_titles = $this->_get_custom_transient_title();
		$this->transient_expiry = ( ! is_null( $this->transient_expiry ) ) ? $this->transient_expiry : ( 3 * HOUR_IN_SECONDS );
		$this->posts = ( ! is_null( $this->posts ) ) ? $this->posts: array();
		$this->post_type_id = ( ! is_null( $this->post_type_id ) ) ? $this->post_type_id : str_replace( '-', '_', $this->post_type );
		$this->post_type_args = ( ! is_null( $this->post_type_args ) ) ? $this->post_type_args : array();
		$this->taxonomy_args = ( ! is_null( $this->taxonomy_args ) ) ? $this->taxonomy_args: array();
		$this->query_limit = ( ! is_null( $this->query_limit ) ) ? $this->query_limit: -1;
		$this->custom_post_type_args = ( ! is_null( $this->custom_post_type_args ) ) ? $this->custom_post_type_args : array();
		$this->custom_taxonomy_args = ( ! is_null( $this->custom_taxonomy_args ) ) ? $this->custom_taxonomy_args : array();
		$this->custom_post_type_supports = ( ! is_null( $this->custom_post_type_supports ) ) ? $this->custom_post_type_supports : array();
		$this->set_post_type_supports( $this->custom_post_type_supports );
		$this->set_post_type_args( $this->custom_post_type_args );
		$this->set_taxonomy_args( $this->custom_taxonomy_args );
	} // set_parameters()



	/**
	 * This method runs after __construct() just a way for sub classes to run custom
	 * initialization stuff while still inheriting the constructor from this class
	 *
	 * @return Void
	 */
	public function init() {
		// Overwrite/Extend in Sub-classes do not add anything here!
		// Use __constructor() or another method in __constructor().
	} // init()



	/**
	 * Actions that need to be set for this base class only using add_action()
	 * sub-classes will need to set there own actions without overriding this method
	 *
	 * @return Void
	 */
	private function type_base_add_actions() {
		// hook to create post_type
		add_action( 'init', array( &$this, 'make_post_type' ) );

		// hook into save post to reset cache
		add_action( 'save_post', array( &$this, 'reset_transient' ) );
	} // type_base_add_actions()



	/**
	 * Checks to make sure that the required properties are set or
	 * the class will halt and produce a warning instead of throwing an
	 * error.
	 *
	 * @return bool If all required properties are set TRUE is returned
	 */
	public function passed_config_test() {
		if ( ! is_subclass_of( $this, 'MDG_Type_Base' ) )
			return false;

		$errors = array();
		$required_properties = array(
			'post_type'        => $this->post_type,
			'post_type_title'  => $this->post_type_title,
			'post_type_single' => $this->post_type_single,
			'transient_title'  => $this->transient_title
		);

		foreach ( $required_properties as $property_name => $property ) {
			if ( is_null( $property ) )
				$errors[] = "Property {$property_name} has not been set in your sub-class.<br/>";
		} // foreach()

		if ( empty( $errors ) ) {
			return true;
		} else {
			foreach ( $errors as $error )
				echo $error;
		} // if/each()

		return false;
	} // passed_config_test()



	/**
	 * Sets the Post Type support array
	 *
	 * @return Void
	 */
	public function set_post_type_supports( $custom_post_type_supports = array() ) {
		$default_post_type_supports = array(
			'title',
			'editor',
			'post-thumbnails',
			'custom-fields',
			'page-attributes',
			'author',
			'thumbnail',
			'excerpt'
		);


		if ( $custom_post_type_supports[0] == false ) {
			$this->post_type_supports = array();
		} elseif ( ! empty( $custom_post_type_supports ) ) {
			$this->post_type_supports = $custom_post_type_supports;
		} else {
			$this->post_type_supports = $default_post_type_supports;
		}
	} // set_post_type_supports()



	/**
	 * Registers the post type and a custom taxonomy for the post type.
	 *
	 * @return Void
	 */
	public function make_post_type() {
		// make sure the post type info is set - none of this will work without it!
		if ( is_null( $this->post_type ) or is_null( $this->post_type_title ) or is_null( $this->post_type_single ) )
			return false;

		// Register post type
		register_post_type( $this->post_type, $this->post_type_args );

		// Register taxonomy for post type
		register_taxonomy(
			$this->post_type."-categories",
			array( $this->post_type ),
			$this->taxonomy_args
		);
	} // make_post_type()



	/**
	 * Sets the arguments used for registering the post type with register_post_type()
	 *
	 * @param  array $custom_post_type_args Optional. Anything acceptable in the $args parameter for register_post_type() http://codex.wordpress.org/Function_Reference/register_post_type
	 *
	 */
	public function set_post_type_args( $custom_post_type_args = array() ) {
		$default_post_type_args = array(
			'label'              => __( $this->post_type_title ),
			'singular_label'     => __( $this->post_type_single ),
			'public'             => true,
			'show_ui'            => true,
			'menu_position'      => 5,
			'capability_type'    => 'post',
			'hierarchical'       => false,
			'publicly_queryable' => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => $this->post_type, 'with_front' => false ),
			'can_export'         => true,
			'supports'           => $this->post_type_supports
		);

		$this->post_type_args = array_merge( $default_post_type_args, $custom_post_type_args );
	} // set_post_type_args()



	/**
	 * Sets the taxonomy args when registering a taxonomy using register_taxonomy()
	 *
	 * @param array   $custom_taxonomy_args Optional. Anything acceptable in the $args parameter for register_taxonomy() http://codex.wordpress.org/Function_Reference/register_taxonomy
	 *
	 */
	public function set_taxonomy_args( $custom_taxonomy_args = array() ) {
		// Register post type
		$default_taxonomy_args = array(
			"hierarchical"  => true,
			"label"   => "Categories",
			"singular_label"=> "Category",
			"rewrite"  => true
		);

		$this->taxonomy_args = array_merge( $default_taxonomy_args, $custom_taxonomy_args );
	} // set_taxonomy_args()



	/**
	 * Resets the transient data by deleting the transient data
	 *
	 * @return Void
	 */
	public function reset_transient() {
		// Remove the standard transient
		delete_transient( $this->transient_title );

		// Remove any custom transients
		foreach ( $this->custom_transient_titles as $transient_title )
			delete_transient( $transient_title );

		$this->_set_posts();
	} // reset_transient()



	/**
	 * Retrieves all of the custom transient titles for the current post type
	 *
	 * @return array All of the custom transient titles for the current post type
	 */
	protected function _get_custom_transient_title() {
		return get_option( 'custom_'.$this->transient_title.'_transient', array() );
	} // _get_custom_transient_title()



	/**
	 * Sets custom transient titles for the current post type
	 *
	 * @param  array  $custom_query_args      Optional. Any arguments accepted by the WP_Query class http://codex.wordpress.org/Class_Reference/WP_Query
	 * @param  string $custom_transient_title Optional. An unique string to be appended to the default transient title
	 */
	protected function _set_custom_transient_title( $custom_query_args = array(), $custom_transient_title = 'custom' ) {
		if ( empty( $custom_query_args ) )
			return false;

		// Add the custom transient titles for use when
		$this->custom_transient_titles[] = $this->transient_title.'_'.$custom_transient_title;
		$this->custom_transient_titles = array_unique( $this->custom_transient_titles );

		update_option( 'custom_'.$this->transient_title.'_transient', $this->custom_transient_titles );
		return true;
	} // _set_custom_transient_title(



	/**
	 * Handles retrieving of the posts for the given post type with a few basic defaults while setting a
	 * transient for cache purposes.  It also allows for custom queries, when using custom queries you
	 * need to specify a custom transient title.  Also you will not retrieve the posts like the basic one
	 * by using $this->posts;. You will instead need to use the return value to access the posts.
	 *
	 * @param  array $custom_query_args      Optional. Any arguments accepted by the WP_Query class http://codex.wordpress.org/Class_Reference/WP_Query
	 * @param  string $custom_transient_title Optional. An unique string to be appended to the default transient title
	 *
	 * @return array                           Retrieved post objects
	 */
	protected function _set_posts( $custom_query_args = array(), $custom_transient_title = 'custom' ) {
		$transient_title = ( empty( $custom_query_args ) ) ? $this->transient_title : $this->transient_title.'_'.$custom_transient_title;
		$transient = get_transient( $transient_title );
		$this->_set_custom_transient_title( $custom_query_args, $custom_transient_title );

		if ( $transient ) {
			$posts = $transient;
		} else {
			$default_query_args = array(
				'post_type'      => $this->post_type,
				'posts_per_page' => $this->query_limit
			);
			$query_args = array_merge( $default_query_args, $custom_query_args );
			$query = new WP_Query( $query_args );
			$posts = $query->get_posts();

			if ( empty( $custom_query_args ) ) {
				// set normal transient (cache)
				set_transient( $this->transient_title, $posts, $this->transient_expiry );
				$this->posts = $posts;
			} else {
				// Since this is a custom query it needs its own transient
				// so that it can be saved correctly without overwriting the
				// default query
				if ( $custom_transient_title == 'custom' ) {
					echo 'ERRROR: Please use something other than "custom" for $custom_transient_title!';
					die();
				} // if()

				// set custom transient (cache)
				set_transient(
					$this->transient_title.'_'.$custom_transient_title,
					$posts,
					$this->transient_expiry
				);
			} // if/else()
		} // if/esle()

		return $posts;
	} // _set_posts()



	/**
	 * Somewhat of an alias of set posts, this method should be used externally
	 *
	 * @param  array  $custom_query_args      Optional. Any arguments accepted by the WP_Query class http://codex.wordpress.org/Class_Reference/WP_Query
	 * @param  string $custom_transient_title Optional. An unique string to be appended to the default transient title
	 *
	 * @return array                          Retrieved post objects
	 */
	public function get_posts( $custom_query_args = array(), $custom_transient_title = 'custom' ) {
		if ( empty( $custom_query_args ) ) {
			// Setup posts if they haven't been yet
			if ( empty( $this->posts ) )
				$this->_set_posts();

			return $this->posts;
		} else {
			// Custom query
			return $this->_set_posts( $custom_query_args, $custom_transient_title );
		} // if/else()

		return array();
	} // get_posts()


	/**
	 * Retrieves posts that have featured images
	 *
	 *
	 * @return Retrieved post objects
	 */
	public function get_posts_with_featured_images() {
		$custom_query_args = array(
			'post_type'      => $this->post_type,
			'meta_key'       => '_thumbnail_id',
			'posts_per_page' => 20
		);
		return $this->_set_posts( $custom_query_args, 'posts_with_featured_images' );
	} // get_posts_with_featured_images()
} // END Class MDG_Type_Base()
