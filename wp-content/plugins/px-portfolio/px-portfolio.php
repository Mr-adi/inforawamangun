<?php

/**
 *
 * @link              http://themeforest.net/user/PixFlow/portfolio
 * @since             1.0.0
 * @package           Pixflow Portfolio
 *
 * @wordpress-plugin
 * Plugin Name:       Pixflow Portfolio
 * Plugin URI:        http://themeforest.net/user/PixFlow/portfolio
 * Description:       Add Portfolio custom post type.
 * Version:           1.0.0
 * Author:            Pixflow
 * Author URI:        http://themeforest.net/user/PixFlow/portfolio
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       px-portfolio
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-px-portfolio-activator.php
 */
function activate_px_portfolio() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-px-portfolio-activator.php';
	PX_Portfolio_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-px-portfolio-deactivator.php
 */
function deactivate_px_portfolio() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-px-portfolio-deactivator.php';
	PX_Portfolio_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_px_portfolio' );
register_deactivation_hook( __FILE__, 'deactivate_px_portfolio' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-px-portfolio.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_px_portfolio() {

	$plugin = new PX_Portfolio();
	$plugin->run();

}
run_px_portfolio();
