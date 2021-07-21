<?php
/**
 * Fired during plugin activation.
 *
 *
 * @since      1.0.0
 * @package    Wcfm_Vendor_Store_Google_Reviews
 * @subpackage Wcfm_Vendor_Store_Google_Reviews/includes
 * @author     ExpressTech Softwares Solutions Pvt Ltd <contact@expresstechsoftwares.com>
 */
class Wcfm_Vendor_Store_Google_Reviews_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		if ( ! is_dir( get_template_directory() . '/wcfm' ) ) {
			mkdir( get_template_directory() . '/wcfm', 0777, true );
		}
		if ( ! is_dir( get_template_directory() . '/wcfm/store' ) ) {
			mkdir( get_template_directory() . '/wcfm/store', 0777, true );
		}
		if ( ! is_dir( get_template_directory() . '/wcfm/store/wcfmmp-view-store-google_reviews.php' ) ) {
			$content = "<?php 
			echo do_shortcode('[google-reviews]'); ?>";
			$fp      = fopen( get_template_directory() . '/wcfm/store/wcfmmp-view-store-google_reviews.php', 'wb' );
			fwrite( $fp, $content );
			fclose( $fp );
		}
	}

}
