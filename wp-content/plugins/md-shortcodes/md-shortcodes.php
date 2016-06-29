<?php

/**
 *
 * @link              http://themeforest.net/user/PixFlow/portfolio
 * @since             1.0.0
 * @package           Massive Dynamic Shortcodes
 *
 * @wordpress-plugin
 * Plugin Name:       Massive Dynamic Shortcodes
 * Plugin URI:        http://themeforest.net/user/PixFlow/portfolio
 * Description:       Add Shortcodes to Massive Dynamic Theme.
 * Version:           1.0.0
 * Author:            Pixflow
 * Author URI:        http://themeforest.net/user/PixFlow/portfolio
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       md-shortcodes
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-md-shortcodes-activator.php
 */
function activate_md_shortcodes() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-md-shortcodes-activator.php';
	MD_Shortcodes_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-md-shortcodes-deactivator.php
 */
function deactivate_md_shortcodes() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-md-shortcodes-deactivator.php';
	MD_Shortcodes_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_md_shortcodes' );
register_deactivation_hook( __FILE__, 'deactivate_md_shortcodes' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-md-shortcodes.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_md_shortcodes() {

	$plugin = new MD_Shortcodes();
	$plugin->run();

}
run_md_shortcodes();
