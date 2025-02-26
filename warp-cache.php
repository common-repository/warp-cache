<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://antonionovak.com
 * @since             1.0.0
 * @package           Warp_Cache
 *
 * @wordpress-plugin
 * Plugin Name:       Warp Cache
 * Plugin URI:        http://antonionovak.com/plugins/warp-cache/
 * Description:       Simple, light and powerful cache plugin. Plug and play. No customisation required.
 * Version:           1.0.1
 * Author:            Antonio Novak
 * Author URI:        http://antonionovak.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       warp-cache
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-warp-cache-activator.php
 */
function activate_warp_cache() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-warp-cache-activator.php';
	Warp_Cache_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-warp-cache-deactivator.php
 */
function deactivate_warp_cache() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-warp-cache-deactivator.php';
	Warp_Cache_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_warp_cache' );
register_deactivation_hook( __FILE__, 'deactivate_warp_cache' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-warp-cache.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_warp_cache() {

	$plugin = new Warp_Cache();
	$plugin->run();

}

run_warp_cache();
