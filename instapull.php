<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              lucasgerroir.com
 * @since             1.0.0
 * @package           Instapull
 *
 * @wordpress-plugin
 * Plugin Name:       Insta Pull
 * Plugin URI:        lucasgerroir.com
 * Description:       Using a shortcode this plugin pulls a designated instagram feed as a list.
 * Version:           1.0.0
 * Author:            Lucas Gerroir
 * Author URI:        lucasgerroir.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       instapull
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'INSTAPULL_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-instapull-activator.php
 */
function activate_instapull() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-instapull-activator.php';
	Instapull_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-instapull-deactivator.php
 */
function deactivate_instapull() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-instapull-deactivator.php';
	Instapull_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_instapull' );
register_deactivation_hook( __FILE__, 'deactivate_instapull' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-instapull.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_instapull() {

	$plugin = new Instapull();
	$plugin->run();

}
run_instapull();
