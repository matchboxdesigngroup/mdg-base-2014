<?php
/**
 * Page titles
 */
function mdg_title() {
	$title = '';

	if ( is_home() ) {
		if ( get_option( 'page_for_posts', true ) ) {
			$title = get_the_title( get_option( 'page_for_posts', true ) );
		} else {
			$title = __( 'Latest Posts', 'roots' );
		}
	} elseif ( is_archive() ) {
		$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		if ( $term ) {
			$title = $term->name;
		} elseif ( is_post_type_archive() ) {
			$title = get_queried_object()->labels->name;
		} elseif ( is_day() ) {
			$title = __( 'Daily Archives: ' . get_the_date(), 'roots' );
		} elseif ( is_month() ) {
			$title = __( 'Monthly Archives: ' . get_the_date( 'F Y' ), 'roots' );
		} elseif ( is_year() ) {
			$title = __( 'Yearly Archives: ' . get_the_date( 'Y' ), 'roots' );
		} elseif ( is_author() ) {
			$author = get_queried_object();
			$title  = __( "Author Archives: {$author->display_name}", 'roots' );
		} else {
			$title = single_cat_title( '', false );
		} // if/elseif/else()
	} elseif ( is_search() ) {
		$title = __( 'Search Results for ' . get_search_query(), 'roots' );
	} elseif ( is_404() ) {
		$title = __( 'Not Found', 'roots' );
	} else {
		$title = get_the_title();
	} // if/elseif/else()

	return $title;
} // mdg_title()
