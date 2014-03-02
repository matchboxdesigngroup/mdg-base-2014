<?php
/**
 * The Template for displaying all sidebar
 *
 *
 * @package  WordPress
 * @subpackage  MDGBase
 */
$context = array();
Timber::render( 'sidebar.twig', $context );
