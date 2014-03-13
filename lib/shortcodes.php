<?php
/**
 * All WordPress ShortCodes should be added here.
 *
 * @see http://codex.wordpress.org/Shortcode_API
 *
 * @package      WordPress
 * @subpackage   MDG_Base
 *
 * @author       Matchbox Design Group <info@matchboxdesigngroup.com>
 */


/**
 * Adds a simple divider.
 * <code>[divider]</code>
 *
 * @return  string  The divider HTML.
 */
function mdg_divider_shortcode() {
	return '<div class="divider"></div>';
} // mdg_divider_shortcode()
add_shortcode( 'divider', 'mdg_divider_shortcode' );



/**
 * Creates a 50% column
 *
 * <code>
 * [col-half]
 * Curabitur faucibus non justo eu sollicitudin. Sed risus purus, volutpat.
 * [/col-half]
 *
 * [col-half]
 * Curabitur faucibus non justo eu sollicitudin. Sed risus purus, volutpat.
 * [/col-half]
 * [/clear]
 *
 *
 * @param   array   $atts     ShortCode attributes.
 * @param   string  $content  ShortCode inner content.
 *
 * @return  string            HTML for 50% column with content.
 */
function mdg_col_half( $atts, $content ) {
	$html  = '<div class="col-half fitvid">';
	$html .= apply_filters( 'the_content', $content );
	$html .= '</div>';
	return $html;
} // mdg_col_half
add_shortcode( 'col-half','mdg_col_half' );



/**
 * Creates a 33.3333% column
 *
 * <code>
 * [col-third]
 * Curabitur faucibus non justo eu sollicitudin. Sed risus purus, volutpat.
 * [/col-third]
 *
 * [col-third]
 * Curabitur faucibus non justo eu sollicitudin. Sed risus purus, volutpat.
 * [/col-third]
 *
 * [col-third]
 * Curabitur faucibus non justo eu sollicitudin. Sed risus purus, volutpat.
 * [/col-third]
 * [/clear]
 * </code>
 *
 * @param   array   $atts     ShortCode attributes.
 * @param   string  $content  ShortCode inner content.
 *
 * @return  string            HTML for 33.3333% column with content.
 */
function mdg_col_third( $atts, $content ) {
	$html  = '<div class="col-third fitvid">';
	$html .= apply_filters( 'the_content', $content );
	$html .= '</div>';
	return $html;
} // mdg_col_third
add_shortcode( 'col-third','mdg_col_third' );



/**
 * Creates a 25% column
 *
 * <code>
 * [col-quarter]
 * Curabitur faucibus non justo eu sollicitudin. Sed risus purus, volutpat.
 * [/col-quarter]
 *
 * [col-quarter]
 * Curabitur faucibus non justo eu sollicitudin. Sed risus purus, volutpat.
 * [/col-quarter]
 *
 * [col-quarter]
 * Curabitur faucibus non justo eu sollicitudin. Sed risus purus, volutpat.
 * [/col-quarter]
 *
 * [col-quarter]
 * Curabitur faucibus non justo eu sollicitudin. Sed risus purus, volutpat.
 * [/col-quarter]
 * [/clear]
 * </code>
 *
 * @param   array   $atts     ShortCode attributes.
 * @param   string  $content  ShortCode inner content.
 *
 * @return  string            HTML for 25% column with content.
 */
function mdg_col_quarter( $atts, $content ) {
	$html  = '<div class="col-quarter fitvid">';
	$html .= apply_filters( 'the_content', $content );
	$html .= '</div>';
	return $html;
} // mdg_col_quarter
add_shortcode( 'col-quarter','mdg_col_quarter' );



/**
 * Adds a clearing div.
 *
 * <code>[clear]</code>
 *
 * @param   array   $atts     ShortCode attributes.
 *
 * @return  string            The div with .clear.
 */
function mdg_clear_shortcode( $atts ) {
	$atts = extract( shortcode_atts( array(),$atts ) );

	return '<div class="clear"></div>';
} // mdg_clear_shortcode()
add_shortcode( 'clear','mdg_clear_shortcode' );



/**
 * Adds a missing content notice.
 *
 * <code>[missing-content]</code>
 *
 * @param   array   $atts     ShortCode attributes.
 *
 * @return  string            The missing content HTML.
 */
function mdg_missing_content_shortcode( $atts ) {
	$atts = extract( shortcode_atts( array(),$atts ) );

	$html  = '<div class="missing-content clearfix">';
	$html .= '<p>Vestibulum rhoncus, nibh nec faucibus porta, nulla diam ornare lacus, nec ullamcorper orci lorem lobortis eros. Nunc ac tellus dolor. Mauris ac interdum augue, in aliquet quam. Sed volutpat euismod dui. Integer gravida purus a ante consequat tempor. Ut ut metus erat. Vestibulum ullamcorper vehicula est vel vulputate. Vestibulum dapibus lectus sed eros malesuada aliquam.</p>';
	$html .= '<p>Suspendisse non tristique urna, eu tristique turpis. Pellentesque lobortis elit a ante vestibulum, eget interdum felis posuere. Nam tristique tellus et placerat dapibus. Suspendisse cursus interdum elit sed dictum. Vivamus sed sem vitae massa sollicitudin mollis vitae nec massa. Pellentesque sodales sodales nulla vel tempus. Fusce iaculis ultrices dui et porttitor. Nam enim purus, sagittis et tellus sit amet, cursus ullamcorper quam. Sed bibendum erat convallis, malesuada diam a, lacinia lectus. Duis sit amet arcu orci. Phasellus eu neque vitae mauris tincidunt commodo. Quisque in sagittis erat. Curabitur tristique dui dui, id elementum quam laoreet sed. Curabitur in tincidunt tortor. Nunc et lacinia risus. Integer suscipit venenatis ligula, et egestas arcu pellentesque at.</p>';
	$html .= '</div>';
	return $html;
} // mdg_missing_content_shortcode()
add_shortcode( 'missing-content','mdg_missing_content_shortcode' );