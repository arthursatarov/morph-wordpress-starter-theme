<?php
/**
 * Registers all options pages in this file.
 *
 * The function is registered using the 'acf/init' hook and adds multiple
 * options pages for various settings that are displayed in the WordPress admin panel.
 *
 * @package MORPH
 * @since 0.0.1
 */
function morph_acf_add_options_pages(): void {
	acf_add_options_page(array(
		'page_title'      => 'MORPH – Настройки темы',
		'menu_title'      => 'MORPH',
		'menu_slug'       => 'morph-settings',
		'capability'      => 'manage_options',
		'position'        => '',
		'icon_url'        => '',
		'redirect'        => false,
		'post_id'         => 'options',
		'autoload'        => true,
		'update_button'   => 'Обновить',
		'updated_message' => 'Настройки обновлены'
	));
}

/**
 * Registers the `morph_acf_add_options_pages` function with the 'acf/init' hook
 * to be executed during ACF initialization.
 */
add_action('acf/init', 'morph_acf_add_options_pages');
