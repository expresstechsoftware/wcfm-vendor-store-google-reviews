<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.expresstechsoftwares.com
 * @since             1.0.0
 * @package           Wcfm_Vendor_Store_Google_Reviews
 *
 * @wordpress-plugin
 * Plugin Name:       WCFM Vendor Store Google Reviews
 * Plugin URI:        https://www.expresstechsoftwares.com/wcfm-vendor-store-google-reviews/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            ExpressTech Softwares Solutions Pvt Ltd
 * Author URI:        https://www.expresstechsoftwares.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wcfm-vendor-store-google-reviews
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
define( 'WCFM_VENDOR_STORE_GOOGLE_REVIEWS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wcfm-vendor-store-google-reviews-activator.php
 */
function activate_wcfm_vendor_store_google_reviews() {

	if (!is_dir(get_template_directory().'/wcfm')) {
	    mkdir(get_template_directory().'/wcfm', 0777, true);
	}
	if (!is_dir(get_template_directory().'/wcfm/store')) {
	    mkdir(get_template_directory().'/wcfm/store', 0777, true);
	}
	if (!is_dir(get_template_directory().'/wcfm/store/wcfmmp-view-store-google_reviews.php')) {
		$content = "<?php 
		echo do_shortcode('[google-reviews]'); ?>";
		$fp = fopen(get_template_directory().'/wcfm/store/wcfmmp-view-store-google_reviews.php',"wb");
		fwrite($fp,$content);
		fclose($fp);
	}

	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wcfm-vendor-store-google-reviews-activator.php';
	Wcfm_Vendor_Store_Google_Reviews_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wcfm-vendor-store-google-reviews-deactivator.php
 */
function deactivate_wcfm_vendor_store_google_reviews() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wcfm-vendor-store-google-reviews-deactivator.php';
	Wcfm_Vendor_Store_Google_Reviews_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wcfm_vendor_store_google_reviews' );
register_deactivation_hook( __FILE__, 'deactivate_wcfm_vendor_store_google_reviews' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wcfm-vendor-store-google-reviews.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wcfm_vendor_store_google_reviews() {

	$plugin = new Wcfm_Vendor_Store_Google_Reviews();
	$plugin->run();

}
run_wcfm_vendor_store_google_reviews();