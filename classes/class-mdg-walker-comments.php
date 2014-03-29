<?php
/**
 * Comments
 */

/**
 * Use Bootstrap's media object for listing comments
 *
 * @link http://twitter.github.com/bootstrap/components.html#media
 *
 * @package      WordPress
 * @subpackage   MDG_Base
 */
class MDG_Walker_Comment extends Walker_Comment {
	/**
	 * Start the list before the elements are added.
	 *
	 * @see Walker_Comment::start_lvl()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of comment.
	 * @param array $args Uses 'style' argument for type of HTML list.
	 */
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$GLOBALS['comment_depth'] = $depth + 1; ?>
		<ul <?php comment_class( 'media unstyled comment-' . get_comment_ID() ); ?>>
		<?php
	} // start_lvl()



	/**
	 * End the list of items after the elements are added.
	 *
	 * @see Walker_Comment::end_lvl()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of comment.
	 * @param array  $args   Will only append content if style argument value is 'ol' or 'ul'.
	 */
	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$GLOBALS['comment_depth'] = $depth + 1;
		echo '</ul>';
	} // end_lvl()



	/**
	 * Start the element output.
	 *
	 * @see MDG_Walker_Comment::start_el()
	 *
	 * @param string   $output  Passed by reference. Used to append additional content.
	 * @param object   $comment Comment data object.
	 * @param int      $depth   Depth of comment in reference to parents.
	 * @param array    $args    An array of arguments. @see wp_list_comments()
	 * @param integer  $id      Comment ID.
	 */
	function start_el( &$output, $comment, $depth = 0, $args = array(), $id = 0 ) {
		$depth++;
		$GLOBALS['comment_depth'] = $depth;
		$GLOBALS['comment'] = $comment;

		if ( !empty( $args['callback'] ) ) {
			call_user_func( $args['callback'], $comment, $args, $depth );
			return;
		} // if()

		extract( $args, EXTR_SKIP ); ?>

		<li id="comment-<?php comment_ID(); ?>" <?php comment_class( 'media comment-' . get_comment_ID() ); ?>>
		<?php include locate_template( 'templates/comment.php' ); ?>
		<?php
	} // start_el()



	/**
	 * Ends the element output, if needed.
	 *
	 * @see Walker_Comment::end_el()
	 *
	 * @param string $output  Passed by reference. Used to append additional content.
	 * @param object $comment The comment object. Default current comment.
	 * @param int    $depth   Depth of comment.
	 * @param array  $args    An array of arguments. @see wp_list_comments()
	 */
	function end_el( &$output, $comment, $depth = 0, $args = array() ) {
		if ( !empty( $args['end-callback'] ) ) {
			call_user_func( $args['end-callback'], $comment, $args, $depth );
			return;
		}
		echo "</div></li>\n";
	} // end_el()
} // MDG_Walker_Comment()



/**
 * Adds Bootstrap classes to a users avatar.
 *
 * @see https://codex.wordpress.org/Function_Reference/get_avatar
 *
 * @param   string  $avatar  User avatar using get_avatar().
 *
 * @return  string           Avatar with Bootstrap classes.
 */
function mdg_get_avatar( $avatar ) {
	$avatar = str_replace( "class='avatar", "class='avatar pull-left media-object", $avatar );
	return $avatar;
} // mdg_get_avatar()
add_filter( 'get_avatar', 'mdg_get_avatar' );
