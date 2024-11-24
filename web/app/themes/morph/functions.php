<?php
/**
 * MORPH functions and definitions
 *
 * @package MORPH
 */

const MORPH_THEME_VERSION = '0.0.1';

// Define a global paths and urls
define( 'MORPH_THEME_DIR', get_template_directory() );
const MORPH_FONTS_DIR = MORPH_THEME_DIR . '/assets/fonts';
const MORPH_IMG_DIR   = MORPH_THEME_DIR . '/assets/images';
const MORPH_CSS_DIR   = MORPH_THEME_DIR . '/assets/styles';
const MORPH_JS_DIR    = MORPH_THEME_DIR . '/assets/scripts';

define( 'MORPH_THEME_URL', get_template_directory_uri() );
const MORPH_FONTS_URL = MORPH_THEME_URL . '/assets/fonts';
const MORPH_IMG_URL   = MORPH_THEME_URL . '/assets/images';
const MORPH_CSS_URL   = MORPH_THEME_URL . '/assets/styles';
const MORPH_JS_URL    = MORPH_THEME_URL . '/assets/scripts';

/**
 * Include Theme Files
 *
 * Includes theme-related files from specified directories. It traverses each directory and includes
 * either individual PHP files or all .php files in the directory.
 *
 * @since 0.0.1
 */
function morph_inc_files(): void {
	$directories = [
		'/inc/',
		'/inc/functions/',
		'/inc/hooks/',
		'/inc/shortcodes/',
		'/inc/template-tags/',
	];

	foreach ( $directories as $directory ) {
		$directory_path = trailingslashit( MORPH_THEME_DIR . $directory );

		// Include individual files or all .php files in a directory.
		if ( is_dir( $directory_path ) ) {
			$php_files = glob( $directory_path . '*.php' );

			if ( $php_files ) {
				foreach ( $php_files as $file ) {
					require_once $file;
				}
			}
		} else {
			require_once $directory_path;
		}
	}
}

// Include theme files.
morph_inc_files();
