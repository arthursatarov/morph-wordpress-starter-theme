<?php
/**
 * Functions for disabling editors based on templates and page IDs.
 *
 * @package MORPH
 * @since 0.0.1
 */

/**
 * Check if editors should be disabled for the given post ID.
 */
function morph_disable_editors( $id = false ) {
	$excluded_templates = array();

	$excluded_ids = array(
		get_option( 'page_on_front' ),
		get_option( 'page_for_posts' ),
	);

	if ( empty( $id ) ) {
		return false;
	}

	$id       = intval( $id );
	$template = get_page_template_slug( $id );

	return in_array( $id, $excluded_ids ) || in_array( $template, $excluded_templates );
}

/**
 * Disable Gutenberg editor based on template.
 */
function morph_disable_gutenberg( $can_edit, $post_type ) {
	if ( ! ( is_admin() && ! empty( $_GET['post'] ) ) ) {
		return $can_edit;
	}

	if ( morph_disable_editors( $_GET['post'] ) ) {
		$can_edit = false;
	}

	return $can_edit;
}
add_filter( 'gutenberg_can_edit_post_type', 'morph_disable_gutenberg', 10, 2 );
add_filter( 'use_block_editor_for_post_type', 'morph_disable_gutenberg', 10, 2 );

/**
 * Disable Classic Editor based on template.
 */
function morph_disable_classic_editor(): void {
	$screen = get_current_screen();
	if ( 'page' !== $screen->id || ! isset( $_GET['post'] ) ) {
		return;
	}

	if ( morph_disable_editors( $_GET['post'] ) ) {
		remove_post_type_support( 'page', 'editor' );
	}
}
add_action( 'admin_head', 'morph_disable_classic_editor' );
