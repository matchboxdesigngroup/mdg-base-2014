<?php
/**
 * The template for displaying the Front page
 *
 * @package     WordPress
 * @subpackage  MDGBase
 * @since       MDGBase 1.0.0
 */

	$context = Timber::get_context();
	Timber::render( 'front-page.twig', $context );