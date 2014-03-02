<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package     WordPress
 * @subpackage  MDGBase
 * @since       MDGBase 1.0.0
 */

	$context = Timber::get_context();
	Timber::render( '404.twig', $context );