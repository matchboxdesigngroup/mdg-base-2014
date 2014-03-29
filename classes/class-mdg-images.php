<?php
/**
 * MDG Images Class.
 */

/**
 * Handles adding custom image sizes and other global image related functionality.
 *
 * @package      WordPress
 * @subpackage   MDG_Base
 *
 * @author       Matchbox Design Group <info@matchboxdesigngroup.com>
 */
class MDG_Images {
	/**
	 * The available image sizes.
	 * @var  array
	 */
	public $image_sizes = array();



	/**
	 * Class constructor
	 *
	 * @param array   $config  Class configuration
	 */
	public function __construct( $config = array() ) {
		// Custom Image Sizes
		$this->set_image_sizes();
		$this->register_sizes();

		// ajax response to return the reference grid
		add_action( 'wp_ajax_mdg-image-reference-grid', array( $this, 'output_reference_grid' ) );
	} // __construct()




	/**
	 * Sets all of the custom image sizes
	 *
	 * <code>
	 * $this->image_sizes['example_size'] = array(
	 *  'width'  => 220,
	 *  'height' => 130,
	 *  'title'  => '220x130', // The default will be widthxheight but any string can be used
	 *  'used_in' => array(
	 *   'title' => 'Example Size', // Title to be used in Media notification
	 *   'link'  => '' // Link to an image of the created size to be used in Media notification
	 *  )
	 * );
	 * </code>
	 *
	 * @return Void
	 */
	public function set_image_sizes() {
		// Example size - Duplicate this and get image resizing (for normal sizes)
		// $this->image_sizes[] = array(
		// 	'width'   => 220,
		// 	'height'  => 130,
		// 	'title'   => '220x130', // The default will be widthxheight but any string can be used
		// 	'used_in' => array(
		// 			'title' => 'Example Size', // Title to be used in Media notification
		// 			'link'  => '', // Link to an image of the created size to be used in Media notification
		// 		)
		// );

		// For responsive images
		// $responsive_image_sizes = array(
		// 	'med'      => 400,
		// 	'small'    => 300,
		// 	'xs_small' => 300,
		// );
		// $this->set_responsive_image_sizes( 500, 200, 'some_image', $responsive_image_sizes, 'Used in some image spot' );

		// Featured image administrator column image size
		$this->image_sizes[] = array(
			'title'   => 'admin-list-thumb', // The default will be widthxheight but any string can be used
			'width'   => 100,
			'height'  => 100,
			'cropped' => true,
			'used_in' => array(
				'title'  => 'Example Size',    // Title to be used in Media notification
				'link'   => '',                // Link to an image of the created size to be used in Media notification
			)
		);
	} // function set_image_sizes()



	/**
	 * Sets the image sizes for the responsive images plugin.
	 *
	 * set_responsive_image_sizes( 500, 200, 'some_image', array( 'med' => 200 ), 'Used in some image spot' )
	 *
	 * @param integer $orig_width  Image largest/original width, this will be the 'full' size title.
	 * @param integer $orig_height Image largest/original height.
	 * @param string  $base_title  The title that will be prepended to the image size title.
	 * @param string[] $img_sizes   {
	 * @type string  $title Size title. => @type integer $width Image width.
	 * }
	 * @param string  $used_in     Title to be used in Media notification
	 *
	 * @return Void
	 */
	private function set_responsive_image_sizes( $orig_width, $orig_height, $base_title, $img_sizes, $used_in = '' ) {
		$img_sizes['full'] = ( isset( $img_sizes['full'] ) ) ? $img_sizes['full'] : $orig_width;

		foreach ( $img_sizes as $title => $newWidth ) {
			$height  = round( $orig_height / $orig_width * $newWidth );
			$used_in = ( $used_in == '' ) ? '' : "{$used_in} ";

			$this->image_sizes[] = array(
				'width'   => $newWidth,
				'height'  => $height,
				'title'   => "{$base_title}_{$title}", // The default will be widthxheight but any string can be used
				'used_in' => array(
					'title'  => "{$used_in}", // Title to be used in Media notification
					'link'   => '',                                          // Link to an image of the created size to be used in Media notification
				)
			);
		} // foreach()
	} // set_responsive_image_sizes()




	/**
	 * Registers all of the new image sizes for use in our theme
	 *
	 * @return Void
	 */
	public function register_sizes() {
		// first set the thumb size and make sure that this theme supports thumbs
		if ( function_exists( 'add_theme_support' ) ) {
			add_theme_support( 'post-thumbnails' );
			set_post_thumbnail_size( 140, 140 ); // default Post Thumbnail dimensions
		} // if()

		// now add the sizes
		if ( function_exists( 'add_image_size' ) ) {
			foreach ( $this->image_sizes as $image_size ) {
				extract( $image_size );
				$width   = isset( $width ) ? $width : '';
				$height  = isset( $height ) ? $height : '';
				$title   = isset( $title ) ? $title : "{$width}x{$height}";
				$cropped = isset( $cropped ) ? $cropped : true;

				add_image_size(
					$title,  //title
					$width,  // width
					$height, // height
					$cropped // crop
				);
			}
			//add_image_size( 'homepage-thumb', 220, 180, true ); //(cropped)
		} // if()
	} // function register_sizes()



	/**
	 * Outputs the reference grid in the Media Library
	 *
	 * @return Void
	 */
	public function output_reference_grid() {
		echo $this->reference_grid_html();
		exit;
	} // output_reference_grid()



	/**
	 * Creates the HTML for the image size reference grid in the Media Library
	 *
	 * @return String The HTML with all of the different custom image sizes
	 */
	public function reference_grid_html() {
		$html = '<ul class="image-reference-grid">';
		foreach ( $this->image_sizes as $image_size ) {
			extract( $image_size );
			extract( $used_in );

			$width  = isset( $width ) ? $width : '';
			$height = isset( $height ) ? $height : '';
			$title  = isset( $title ) ? $title : "{$width}x{$height}";
			$title  = "{$title} - {$width}px x {$height}px";

			$html .= '<li style="float: left;max-width: 100%; margin-right: 15px;">';
			$html .= "<p>{$title}</p>";
			if ( isset( $link ) and $link != '' ) {
				$html .= "Used in: <a href='{$link}' target='_blank'>{$title}</a>";
			} // if()
			$html .= "<img src='http://placehold.it/{$width}x{$height}' style='max-width: 100%;height:auto;' alt='{$title}' width='{$width}' height='{$height}'>";
			$html .= '</li>';
		} // foreach()
		$html .= '</ul>';

		return $html;
	} // function reference_grid_html()



	/**
	 * Retrieves the responsive image.
	 * Requires responsive images plugin to be activated in Grunt uglify config.
	 *
	 * <code>
	 * <?php $resp_image = $mdg_stub->get_responsive_image( get_the_id(), 'some_image', null, true, array( 'title' => 'My title image' ) ); ?>
	 * </code>
	 *
	 * @see https://github.com/kvendrik/responsive-images.js
	 *
	 * @param   integer  $src_id       The attachment ID or the post ID to get the featured image from.
	 * @param   string   $base_title   The base title of your responsive image size set in MDG_Images->set_image_sizes().
	 * @param   string   $default_img  Optional, default image URL, defaults to the 'full' size image, used if Javascript is not supported.
	 * @param   boolean  $echo         Optional, to output the responsive image, default true.
	 * @param   array    $attrs        Optional, HTML attributes to add to the img tag.
	 *
	 * @return string                  The responsive image HTML with no script fall back.
	 */
	public function get_responsive_image( $src_id, $base_title, $default_img = null, $echo = true, $attrs = array() ) {
		global $is_IE;

		$attachment_id  = $this->get_responsive_attachment_id( $src_id );
		$attachment_src = wp_get_attachment_image_src( $attachment_id, 'full' );
		$full_image     = $attachment_src[0];
		$img_attrs      = $this->merge_responsive_image_attrs( $attrs, $attachment_id );

		// Make sure this image has not been cropped by the VIP cropper.
		if ( strpos( $full_image, 'wp.com' ) !== false or $is_IE ) {
			return "<img src='{$full_image}' {$img_attrs}>";
		} // if()

		$data_src    = $this->get_responsive_image_data_src(  $attachment_id, $base_title );
		$image       = '';
		$pathinfo    = pathinfo( $full_image );
		$dirname     = $pathinfo['dirname'];
		$default_img = ( is_null( $default_img ) ) ? $full_image : $default_img;
		$default_img = esc_url( $default_img );

		if ( $data_src == '' ) {
			$image = "<img src='{$full_image}' {$img_attrs}>";
		} else {
			$image .= "<img data-src-base='' data-src='{$data_src}' {$img_attrs}>";
			$image .= "<noscript><img src='{$default_img}' {$img_attrs}></noscript>";
		} // if/else()

		if ( $echo ) {
			echo $image;
		} // if()

		return $image;
	} // get_responsive_image()



	/**
	 * Handles merging together the different sizes for the data-src attribute.
	 *
	 * @see https://github.com/kvendrik/responsive-images.js
	 *
	 * @param   integer  $attachment_id  The attachment ID to use when retrieving the image(s).
	 * @param   [type]  $base_title     [description]
	 *
	 * @return  [type]                  [description]
	 */
	public function get_responsive_image_data_src( $attachment_id, $base_title ) {
		$img_sizes = $this->get_responsive_image_sizes( $base_title );
		$data_src  = array();

		foreach ( $img_sizes as $img_size => $data_size ) {
			$attachment_src = wp_get_attachment_image_src( $attachment_id, $img_size );
			$src_url        = esc_url( $attachment_src[0] );
			$data_src[]     = "{$data_size}:{$src_url}";
		} // foreach

		$data_src = trim( implode( ',', $data_src ) );

		return $data_src;
	} // get_responsive_image_data_src()



	/**
	 * Merges the supplied attributes so they can be added to the image.
	 *
	 * @param   array   $attrs          The attributes to be merged.
	 * @param   integer $attachment_id  The attachment ID of the responsive image.
	 *
	 * @return  string                   The merged attributes.
	 */
	public function merge_responsive_image_attrs( $attrs, $attachment_id ) {
		$default_attrs = array(
			'alt'   => get_the_title( $attachment_id ),
			'class' => 'img-responsive',
		);

		// Merge the class attributes together
		if ( isset( $attrs['class'] ) ) {
			$attrs['class'] = "{$default_attrs['class']} {$attrs['class']}";
		} // if()

		// Merge all attributes together
		$attrs = array_merge( $default_attrs, $attrs );

		if ( is_null( $attrs['alt'] ) ) {
			unset( $attrs['alt'] );
		} // if()

		// Merge attributes together
		$img_attrs = '';
		foreach ( $attrs as $key => $value ) {
			$key        = esc_attr( $key );
			$value      = esc_attr( $value );
			$img_attrs .= "{$key}='{$value}' ";
		} // if()

		return trim( $img_attrs );
	} // merge_responsive_image_attrs()



	/**
	 * Handles retrieving the thumbnail ID if the src_id is not an attachment.
	 *
	 * @param   integer  $src_id  Either an attachment ID or the post ID to retrieve the thumbnail ID.
	 *
	 * @return  integer           The attachment ID.
	 */
	public function get_responsive_attachment_id( $src_id ) {
		$post_id   = intval( $src_id );
		$post_type = get_post_type( $post_id );

		// Handles an attachment id
		if ( $post_type == 'attachment' ) {
			return $post_id;
		} // if()

		// Handles featured image thumbnail
		return get_post_thumbnail_id( $post_id );
	} // get_responsive_attachment_id()



	/**
	 * Retrieves the responsive image sizes.
	 *
	 * @param  string  $base_title The base image size used when adding responsive image sizes.
	 *
	 * @return array               The responsive image sizes.
	 */
	public function get_responsive_image_sizes( $base_title ) {
		global $_wp_additional_image_sizes;
		$image_sizes = get_intermediate_image_sizes();
		$resp_sizes  = array();
		$sizes       = array();

		// Get the sizes that match the base title
		foreach ( $image_sizes as $image_size ) {
			if ( strpos( $image_size, $base_title ) !== false ) {
				$resp_sizes[] = $image_size;
			} // if()
		} // foreach()

		// Get the responsive image sizes
		foreach ( $resp_sizes as $size ) {
			if ( in_array( $size, array( 'thumbnail', 'medium', 'large' ) ) ) {
				$sizes[$size] = get_option( $size . '_size_w' );
			} elseif ( isset( $_wp_additional_image_sizes ) && isset( $_wp_additional_image_sizes[ $size ] ) ) {
				$sizes[$size] = $_wp_additional_image_sizes[ $size ]['width'];
			} //if/else
		} // foreach()

		// Sort the sizes from largest to smallest
		asort( $sizes, SORT_NUMERIC );

		// Add the greater/less than so it will load them correctly.
		$i = 0;
		foreach ( $sizes as $key => $size ) {
			$sizes[$key] = ( $i == count( $sizes ) - 1 ) ? ">{$size}" : "<{$size}";
			$i = $i + 1;
		} // foreach()

		return $sizes;
	} // get_responsive_image_sizes()
} // END Class MDG_Images()

global $mdg_images;
$mdg_images = new MDG_Images();
