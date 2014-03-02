<?php
/**
 * Template Name: Example Page Template
 *
 * @package     WordPress
 * @subpackage  MDGBase
 * @since       1.0.0
 */

$context         = Timber::get_context();
$post            = new TimberPost();
$context['post'] = $post;
Timber::render(
	array(
		'page-example.twig',
		'page.twig',
	),
	$context
);