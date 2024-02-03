<?php
/**
 * Theme Setup
 *
 * This file contains various theme-related functions and hooks them to specific actions during the theme lifecycle.
 * It handles tasks such as registering navigation areas, enqueueing scripts and styles, preloading fonts,
 * setting up theme defaults, and cleaning up unnecessary items from wp_head().
 *
 * @package MORPH
 */

/**
 * Table of Contents:
 *
 * 1. Hooks various theme-related functions.
 * 2. Register navigation areas
 * 3. Enqueue scripts and styles.
 * 4. Preloads fonts that are hosted locally into the page head
 * 5. Sets up theme defaults and registers support for various WordPress features.
 * 6. Remove unused stuff from wp_head()
 */

/**
 * 1. Hooks various theme-related functions.
 *
 * @since 0.0.1
 */
add_action( 'after_setup_theme', 'morph_register_nav_areas' );
add_action( 'wp_enqueue_scripts', 'morph_enqueue_assets' );
add_action( 'wp_head', 'morph_preload_fonts' );
add_action( 'after_setup_theme', 'morph_theme_support' );
add_action( 'after_setup_theme', 'morph_wphead_clean' );

/**
 * 1. Register navigation areas
 *
 * @since 0.0.1
 */
function morph_register_nav_areas(): void {
	register_nav_menus(
		array(
			'primary' => __( 'Primary', 'morph' ),
		),
	);
}

/**
 * 2. Enqueue scripts and styles.
 *
 * @since 0.0.1
 */
function morph_enqueue_assets(): void {
	// Scripts
	wp_register_script( 'morph', MORPH_JS_URL . '/index.js', array(), MORPH_THEME_VERSION, true );
	wp_enqueue_script( 'morph' );

	// Styles
	wp_register_style( 'morph', MORPH_CSS_URL . '/index.css', array(), MORPH_THEME_VERSION, 'screen' );
	wp_enqueue_style( 'morph' );
}

/**
 * 3. Preloads fonts that are hosted locally into the page head
 *
 * @since 0.0.1
 */
function morph_preload_fonts(): void {
	// Path to fonts folder
	$fonts_path = MORPH_FONTS_URL;

	// Arrays of fonts and font formats
	$fonts   = []; // Add actual font values here
	$formats = [ 'woff2' ];

	foreach ( $fonts as $font ) {
		foreach ( $formats as $format ) {
			// Generate font URL and format
			$font_url    = esc_url( $fonts_path . '/' . $font . '.' . $format );
			$font_format = 'font/' . esc_attr( $format );

			// Output the link tag for font preload
			printf(
				'<link rel="preload" href="%s" crossorigin="anonymous" as="font" type="%s">',
				$font_url,
				$font_format
			);
		}
	}
}

/**
 * 4. Sets up theme defaults and registers support for various WordPress features.
 *
 * @since 0.0.1
 */
function morph_theme_support(): void {
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );

	// Switch default core markup for search form, comment form, and comments to output valid HTML5.
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		),
	);
}

/**
 * 5. Remove unused stuff from wp_head()
 *
 * @since 0.0.1
 */
function morph_wphead_clean(): void {
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );
	add_filter( 'the_generator', '__return_false' );
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );

	// Disable automatic feeds
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_action( 'wp_head', 'feed_links', 2 );

	// Remove rest API link
	remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
	remove_action( 'wp_head', 'wp_oembed_add_host_js' );
}
