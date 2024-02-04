<?php
/**
 * Functions to modify the body classes.
 *
 * @package MORPH
 * @since 0.0.1
 */

/**
 * 1. Init hooks
 */
add_filter( 'body_class', 'morph_clean_body_classes' );
add_filter( 'body_class', 'morph_add_body_classes' );

/**
 * 2. Clean all default WP body classes.
 */
function morph_clean_body_classes( $classes ): array {
	$classes = array();

	return $classes;
}

/**
 * 3. Adds custom classes to the array of body classes.
 */
function morph_add_body_classes( $classes ): array {
	$classes = array();

	return $classes;
}
