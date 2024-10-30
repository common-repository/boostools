<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://boostools.app/wp/
 * @since             1.0.0
 * @package           boostools
 *
 * @wordpress-plugin
 * Plugin Name:       Boostools
 * Plugin URI:        https://boostools.app/wp/
 * Description:       Welcome to boostools – this is very simple WordPress plugin that helps turn your website visitors into web push notification subscribers. 
 * Version:           1.0.2
 * Author:            Boostools Team
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       boostools
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.1 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'BOOSTOOLS_VERSION', '1.0.2' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-boostools-activator.php
 */
function activate_boostools() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-boostools-activator.php';
	boostools_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-boostools-deactivator.php
 */
function deactivate_boostools() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-boostools-deactivator.php';
	boostools_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_boostools' );
register_deactivation_hook( __FILE__, 'deactivate_boostools' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-boostools.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_boostools() {

	$plugin = new boostools();
	$plugin->run();

}
run_boostools();
