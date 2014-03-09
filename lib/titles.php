<?php
/**
 * Page titles
 *
 * @package      WordPress
 * @subpackage   MDG_Base
 */

/**
 * Handles selecting the correct page title to display.
 *
 * @return  string  The page title.
 */
function mdg_title() {
	if ( is_home() ) {
		if ( get_option( 'page_for_posts', true ) ) {
			echo get_the_title( get_option( 'page_for_posts', true ) );
		} else {
			_e( 'Latest Posts', 'roots' );
		}
	} elseif ( is_archive() ) {
		$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		if ( $term ) {
			echo esc_html( $term->name );
		} elseif ( is_post_type_archive() ) {
			echo esc_html( get_queried_object()->labels->name );
		} elseif ( is_day() ) {
			printf( __( 'Daily Archives: %s', 'roots' ), get_the_date() );
		} elseif ( is_month() ) {
			printf( __( 'Monthly Archives: %s', 'roots' ), get_the_date( 'F Y' ) );
		} elseif ( is_year() ) {
			printf( __( 'Yearly Archives: %s', 'roots' ), get_the_date( 'Y' ) );
		} elseif ( is_author() ) {
			$author = get_queried_object();
			printf( __( 'Author Archives: %s', 'roots' ), $author->display_name );
		} else {
			single_cat_title();
		}
	} elseif ( is_search() ) {
		printf( __( 'Search Results for %s', 'roots' ), get_search_query() );
	} elseif ( is_404() ) {
		_e( 'Not Found', 'roots' );
	} else {
		the_title();
	}
}
