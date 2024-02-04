<?php
/**
 * Functions for disabling editors based on templates and page IDs.
 *
 * @package MORPH
 * @since 0.0.1
 */

/**
 * Table of Contents:
 *
 * 1. Init hooks
 * 2. Templates and pages on which editors should be disabled
 * 2. Disable Gutenberg
 * 2. Disable Classic Editor
 */

/**
 * 1. Init hooks
 */
add_filter( 'gutenberg_can_edit_post_type', 'morph_disable_gutenberg', 10, 2 );
add_filter( 'use_block_editor_for_post_type', 'morph_disable_gutenberg', 10, 2 );
add_action( 'admin_head', 'morph_disable_classic_editor' );

/**
 * 2. Check if editors should be disabled for the given post ID or page template.
 */
function morph_disable_editors( $id = false ): bool {
	$excluded_templates = array();

	$excluded_ids = array(
		get_option( 'page_on_front' ),
	);

	if ( empty( $id ) ) {
		return false;
	}

	$id       = intval( $id );
	$template = get_page_template_slug( $id );

	return in_array( $id, $excluded_ids ) || in_array( $template, $excluded_templates );
}

/**
 * 3. Disable Gutenberg editor
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

/**
 * 4. Disable Classic Editor
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
