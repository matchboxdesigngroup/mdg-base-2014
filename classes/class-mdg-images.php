<?php
/**
 * MDG Images handles adding custom image sizes and other global image related functionality
 *
 * @author Matchbox Design Group <info@matchboxdesigngroup.com>
 */
class MDG_Images {

	public $image_sizes = array();

	public function __construct() {
		// Custom Image Sizes
		$this->set_image_sizes();
		$this->register_sizes();

		// ajax response to return the reference grid
		add_action( 'wp_ajax_mdg-image-reference-grid', array( $this, 'output_reference_grid' ) );
	} // __construct()


	/**
	 * Sets all of the custom image sizes
	 *
	 * Example:
	 * $this->image_sizes['example_size'] = array(
	 * 	'width'  => 220,
	 * 	'height' => 130,
	 * 	'title'  => '220x130', // The default will be widthxheight but any string can be used
	 * 	'used_in' => array(
	 * 		'title' => 'Example Size', // Title to be used in Media notification
	 * 		'link'  => '' // Link to an image of the created size to be used in Media notification
	 * 	)
	 * );
	 * @return [type] [description]
	 */
	public function set_image_sizes()
	{
		// Example size - Duplicate this and get image resizing
		// $this->image_sizes[] = array(
		// 	'width'  => 220,
		// 	'height' => 130,
		// 	'title'  => '220x130', // The default will be widthxheight but any string can be used
		// 	'used_in' => array(
		// 		'title' => 'Example Size', // Title to be used in Media notification
		// 		'link'  => '' // Link to an image of the created size to be used in Media notification
		// 	)
		// );
	} // function set_image_sizes()



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
				extract($image_size);
				$width = isset( $width ) ? $width : '';
				$height = isset( $height ) ? $height : '';
				$title = isset( $title ) ? $title : "{$width}x{$height}";
				$cropped      = isset( $cropped ) ? $cropped : true;

				add_image_size(
					$title,   //title
					$width,            // width
					$height,            // height
					$cropped            // crop
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

			$width = isset( $width ) ? $width : '';
			$height = isset( $height ) ? $height : '';
			$title = isset( $title ) ? $title : "{$width}x{$height}";

			$style = '';
			$style .= "width: {$width}px !important;";
			$style .= " height: {$height}px !important;";

			$html .= "<li style='{$style}'>";
			$html .= "<p>{$title} - {$width}x{$height}</p>";

			if ( isset( $used_in['title'] ) )
				$html .= 'Used in: <a href="'.$used_in['link'].'" target="_blank">'.$used_in['title']. '</a>';

			$html .= '</li>';
		} // foreach()

		$html .= '</ul>';

		return $html;
	} // function reference_grid_html()
} // END Class MDG_Images()

$mdg_images = new MDG_Images();