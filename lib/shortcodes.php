<?php

// ===============================================
// Create a shortcode for wrapping content in a column
// ===============================================

// Open Div
add_shortcode( 'column', 'mdg_column_shortcode' );
function mdg_column_shortcode() {
	extract( shortcode_atts( array( 'class' => 'columns', 'id' => '' ) ) );
	$return = '<div';
	if ( !empty( $class ) ) $return .= ' class="'.$class.'"';
	if ( !empty( $id ) ) $return .= ' id="'.$id.'"';
	$return .= '>';
	return $return;
}

// Close Column
add_shortcode( 'end-column', 'mdg_end_column_shortcode' );
function mdg_end_column_shortcode( $atts ) {
	return '</div>';
}

// ===============================================
// Create a shortcode for wrapping content in a div
// ===============================================

// Open Div
add_shortcode( 'div', 'mdg_div_shortcode' );
function mdg_div_shortcode() {
	extract( shortcode_atts( array( 'class' => '', 'id' => '' ) ) );
	$return = '<div';
	if ( !empty( $class ) ) $return .= ' class="'.$class.'"';
	if ( !empty( $id ) ) $return .= ' id="'.$id.'"';
	$return .= '>';
	return $return;
}

// Close Div
add_shortcode( 'end-div', 'mdg_end_div_shortcode' );
function mdg_end_div_shortcode( $atts ) {
	return '</div>';
}

// ===============================================
// Create a shortcode that clears both
// ===============================================

add_shortcode( 'clear', 'mdg_clear_shortcode' );
function mdg_clear_shortcode() {
	return '<div class="cl"></div>';
}

// ===============================================
// Create a shortcode for the divider
// ===============================================

add_shortcode( 'divider', 'mdg_divider_shortcode' );
function mdg_divider_shortcode() {
	return '<div class="divider"></div>';
}
