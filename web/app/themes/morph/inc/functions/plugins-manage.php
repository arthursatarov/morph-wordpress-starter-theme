<?php
/**
 * Function for managing plugin activation based on the domain.
 * This function checks the domain and activates/deactivates plugins depending on the environment.
 */

// Hook to `admin_init` to run our plugin manager function
add_action('admin_init', 'morph_plugins_manager');

/**
 * Manage plugin activation based on the domain (local vs production).
 *
 * @return void
 */
function morph_plugins_manager() {
    // Get the current domain from the server
    $current_domain = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';

    // If the domain is empty, exit to avoid further execution
    if (empty($current_domain)) {
        return;
    }

    // List of plugins to manage (plugin path relative to wp-content/plugins)
    $plugins_to_manage = [
        'better-wp-security/better-wp-security.php',
        'litespeed-cache/litespeed-cache.php',
    ];

    // Check if the current domain is not localhost (production environment)
    $is_local = strpos($current_domain, 'localhost') === false;

    // Loop through the plugins and activate or deactivate them based on the environment
    foreach ($plugins_to_manage as $plugin) {
        // Check if the plugin is active or not and take the appropriate action
        if ($is_local && !is_plugin_active($plugin)) {
            activate_plugin($plugin); // Activate the plugin on production
        } elseif (!$is_local && is_plugin_active($plugin)) {
            deactivate_plugins($plugin); // Deactivate the plugin on local environments
        }
    }
}
