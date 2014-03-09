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