<?php
/**
 * Navigation
 */

/**
 * Cleaner walker for wp_nav_menu()
 *
 * Walker_Nav_Menu (WordPress default) example output:
 *   <li id="menu-item-8" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-8"><a href="/">Home</a></li>
 *   <li id="menu-item-9" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-9"><a href="/sample-page/">Sample Page</a></l
 *
 * MDG_Nav_Walker example output:
 *   <li class="menu-home"><a href="/">Home</a></li>
 *   <li class="menu-sample-page"><a href="/sample-page/">Sample Page</a></li>
 *
 * @package      WordPress
 * @subpackage   MDG_Base
 */
class MDG_Nav_Walker extends Walker_Nav_Menu {
	/**
	 * Checks current navigation classes.
	 *
	 * @param   string  $classes  Current classes.
	 *
	 * @return  string            If the current classes container active or dropdown.
	 */
	function check_current( $classes ) {
		return preg_match( '/(current[-_])|active|dropdown/', $classes );
	} // check_current()



	/**
	 * Starts the list before the elements are added.
	 *
	 * @see Walker_Nav_Menu::start_lvl()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 *
	 * @return               Void
	 */
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= "\n<ul class=\"dropdown-menu\">\n";
	} // start_lvl()



	/**
	 * Start the element output.
	 *
	 * @see Walker_Nav_Menu::start_el()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 * @param int    $id     Current item ID.
	 *
	 * @return               Void
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$item_html = '';
		parent::start_el( $item_html, $item, $depth, $args );

		if ( $item->is_dropdown && ( $depth === 0 ) ) {
			// $item_html = str_replace('<a', '<a class="dropdown-toggle" data-toggle="dropdown" data-target="#"', $item_html);
			// $item_html = str_replace('</a>', ' <b class="caret"></b></a>', $item_html);
		} elseif ( stristr( $item_html, 'li class="divider' ) ) {
			$item_html = preg_replace( '/<a[^>]*>.*?<\/a>/iU', '', $item_html );
		} elseif ( stristr( $item_html, 'li class="dropdown-header' ) ) {
			$item_html = preg_replace( '/<a[^>]*>(.*)<\/a>/iU', '$1', $item_html );
		} // if/elseif/elseif()

		$item_html = apply_filters( 'mdg_wp_nav_menu_item', $item_html );
		$output .= $item_html;
	} // start_el()



	/**
	 * Traverse elements to create list from elements.
	 *
	 * Display one element if the element doesn't have any children otherwise,
	 * display the element and its children. Will only traverse up to the max
	 * depth and no ignore elements under that depth. It is possible to set the
	 * max depth to include all depths, see walk() method.
	 *
	 * This method should not be called directly, use the walk() method instead.
	 *
	 * @see Walker::start_lvl()
	 *
	 * @param object  $element           Data object.
	 * @param array   $children_elements List of elements to continue traversing.
	 * @param int     $max_depth         Max depth to traverse.
	 * @param int     $depth             Depth of current element.
	 * @param array   $args              An array of arguments.
	 * @param string  $output            Passed by reference. Used to append additional content.
	 * @return null                     Null on failure with no changes to parameters.
	 */
	function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
		$element->is_dropdown = ( ( !empty( $children_elements[$element->ID] ) && ( ( $depth + 1 ) < $max_depth || ( $max_depth === 0 ) ) ) );

		if ( $element->is_dropdown ) {
			$element->classes[] = 'dropdown';
		} // if()

		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	} // display_element()
} // MDG_Nav_Walker()



/**
 * Remove the id="" on nav menu items
 * Return 'menu-slug' for nav menu classes
 */

/**
 * Removes the id="" on navigation menu items.
 *
 * @param   array   $classes  Current menu navigation classes.
 * @param   object  $item     Menu item.
 *
 * @return  array            The menu navigation classes.
 */
function mdg_nav_menu_css_class( $classes, $item ) {
	$slug = sanitize_title( $item->title );
	$classes = preg_replace( '/(current(-menu-|[-_]page[-_])(item|parent|ancestor))/', 'active', $classes );
	$classes = preg_replace( '/^((menu|page)[-_\w+]+)+/', '', $classes );

	$classes[] = 'menu-' . $slug;

	$classes = array_unique( $classes );

	return array_filter( $classes, 'is_element_empty' );
} // mdg_nav_menu_css_class()
add_filter( 'nav_menu_css_class', 'mdg_nav_menu_css_class', 10, 2 );
add_filter( 'nav_menu_item_id', '__return_null' );



/**
 * Clean up wp_nav_menu_args.
 *
 * Remove the container.
 * Use MDG_Nav_Walker() by default.
 *
 * @param   array   $args  wp_nav_menu arguments.
 *
 * @return  array          wp_nav_menu arguments merged with defaults.
 */
function mdg_nav_menu_args( $args = array() ) {
	$mdg_nav_menu_args['container'] = false;

	if ( !$args['items_wrap'] ) {
		$mdg_nav_menu_args['items_wrap'] = '<ul class="%2$s">%3$s</ul>';
	} // if()

	if ( current_theme_supports( 'bootstrap-top-navbar' ) && !$args['depth'] ) {
		$mdg_nav_menu_args['depth'] = 2;
	} // if()

	if ( !$args['walker'] ) {
		$mdg_nav_menu_args['walker'] = new MDG_Nav_Walker();
	} // if()

	return array_merge( $args, $mdg_nav_menu_args );
}
add_filter( 'wp_nav_menu_args', 'mdg_nav_menu_args' );
