<?php
/**
 * Search Form
 *
 * @package     WordPress
 * @subpackage  MDGBase
 * @since       1.0.0
 */


$context = Timber::get_context();
Timber::render( 'searchform.twig' , $context );