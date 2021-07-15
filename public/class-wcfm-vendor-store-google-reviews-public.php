<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.expresstechsoftwares.com
 * @since      1.0.0
 *
 * @package    Wcfm_Vendor_Store_Google_Reviews
 * @subpackage Wcfm_Vendor_Store_Google_Reviews/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wcfm_Vendor_Store_Google_Reviews
 * @subpackage Wcfm_Vendor_Store_Google_Reviews/public
 * @author     ExpressTech Softwares Solutions Pvt Ltd <contact@expresstechsoftwares.com>
 */
class Wcfm_Vendor_Store_Google_Reviews_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wcfm_Vendor_Store_Google_Reviews_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wcfm_Vendor_Store_Google_Reviews_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wcfm-vendor-store-google-reviews-public.css', array(), $this->version, 'all' );

		wp_enqueue_style( $this->plugin_name."font-awesome", "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css", array(), $this->version, 'all' );

		

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wcfm_Vendor_Store_Google_Reviews_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wcfm_Vendor_Store_Google_Reviews_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wcfm-vendor-store-google-reviews-public.js', array( 'jquery' ), $this->version, false );

	}

	public function public_init()
	{	
		global $WCFM, $WCFMmp,$WCFMu;
		$wcfm_store_url = get_option( 'wcfm_store_url', 'store' ); 
		add_rewrite_endpoint( 'google_reviews', EP_ROOT | EP_PAGES ); 
		 
	}

	public function add_store_google_review_tab($tabs)
	{ 
		$tabs['google_reviews'] = "Google Reviews";
		return $tabs;
	}

	public function store_google_review_tab_url($store_tab_url, $tab)
	{ 
		global $WCFMmp;

		//wcfmmp_get_store_url
		if ($tab == "google_reviews") {
			$store_tab_url = $store_tab_url.'google_reviews';		
		}

		return $store_tab_url;
	}
 
	public function wcfm_store_events_default_query_var2( $query_var ) {
	 	global $WCFM, $WCFMmp;
	  
	  	if ( get_query_var( 'google_reviews' ) ) {
	    	$query_var = 'google_reviews';
	  	}
	  	return $query_var;
	}


	
	public function new_register_rule2($wcfm_store_url) {
		global $WCFM, $WCFMmp;
		
		add_rewrite_rule( $wcfm_store_url.'/([^/]+)/'.$WCFMmp->wcfmmp_rewrite->store_endpoint('google_reviews').'?$', 'index.php?post_type=post&'.$wcfm_store_url.'=$matches[1]&'.$WCFMmp->wcfmmp_rewrite->store_endpoint('google_reviews').'=true', 'top' );
		add_rewrite_rule( $wcfm_store_url.'/([^/]+)/'.$WCFMmp->wcfmmp_rewrite->store_endpoint('google_reviews').'/page/?([0-9]{1,})/?$', 'index.php?post_type=post&'.$wcfm_store_url.'=$matches[1]&paged=$matches[2]&'.$WCFMmp->wcfmmp_rewrite->store_endpoint('google_reviews').'=true', 'top' );
	}


	public function wcfmmp_store_google_review_template($url, $store_tab)
	{ 
		if($store_tab == "google_reviews"){
			
			$url = 'store/wcfmmp-view-store-google_reviews.php';	
		}
		return $url;
	}


	public function gmb_eviews_setting($vendor_id)
	{
		global $WCFM, $WCFMmp,$WCFMu;

		?>
		<div class="page_collapsible" id="wcfm_settings_location_head">
			<label class="wcfmfa fa-globe"></label>
			<?php _e('GMB Reviews', 'wc-frontend-manager'); ?><span></span>
		</div>
		<div class="wcfm-container wcfm_marketplace_store_location_settings">
			<div id="wcfm_settings_form_store_location_expander" class="wcfm-content">
			
				<div class="wcfm_clearfix"></div>
				<div class="wcfm_vendor_settings_heading"><h2><?php _e( 'GMB Listings', 'wc-frontend-manager' ); ?></h2></div>
				<div class="wcfm_clearfix"></div>
				<div class="store_address store_address_wrap">
					<?php
					$place_id = get_user_meta($vendor_id, 'wcfm_google_review_place_id',true);
					$lang = get_user_meta($vendor_id, 'wcfm_google_review_lang',true);

					$WCFM->wcfm_fields->wcfm_generate_form_field(
						array( 
							"wcfm_google_review_place_id" => array( 
								'label' => __( 'Place ID ', 'wcfm-vendor-store-google-reviews' ) ,
								'type'  => 'text',
								'class' => 'wcfm-text wcfm_ele place_id_field',
								'label_class' => 'wcfm_title place_id_field',
								'value' => $place_id 
							)
						)
					);
					$WCFM->wcfm_fields->wcfm_generate_form_field(
						array( 
							"wcfm_google_review_lang" => array( 
								'label' => __( 'Retrieval Language', 'wcfm-vendor-store-google-reviews' ) ,
								'type'  => 'text',
								'class' => 'wcfm-text wcfm_ele lang_field',
								'label_class' => 'wcfm_title lang_field',
								'value' => $lang 
							)
						)
					);
					?>

				</div>
			</div>
		</div>

		<?php
	}

	public function admin_gmb_eviews_setting($vendor_id)
	{
		global $WCFM, $WCFMmp,$WCFMu;

		?>
		<div class="wcfm_clearfix"></div><br />
			<div class="wcfm_vendor_settings_heading"><h2><?php _e('GMB Reviews', 'wc-frontend-manager'); ?></h2></div>
			<div class="wcfm_clearfix"></div>
			
			<div class="ets store_address store_address_wrap">
					<?php
					$place_id = get_user_meta($vendor_id, 'wcfm_google_review_place_id',true);
					$lang = get_user_meta($vendor_id, 'wcfm_google_review_lang',true);

					$WCFM->wcfm_fields->wcfm_generate_form_field(
						array( 
							"wcfm_google_review_place_id" => array( 
								'label' => __( 'Place ID ', 'wcfm-vendor-store-google-reviews' ) ,
								'type'  => 'text',
								'class' => 'wcfm-text wcfm_ele place_id_field',
								'label_class' => 'wcfm_title place_id_field',
								'value' => $place_id 
							)
						)
					);
					$WCFM->wcfm_fields->wcfm_generate_form_field(
						array( 
							"wcfm_google_review_lang" => array( 
								'label' => __( 'Retrieval Language', 'wcfm-vendor-store-google-reviews' ) ,
								'type'  => 'text',
								'class' => 'wcfm-text wcfm_ele lang_field',
								'label_class' => 'wcfm_title lang_field',
								'value' => $lang 
							)
						)
					);
					?>

			</div>
		</div>
		<?php
	}


	public function place_id_save($form_field_data)
	{
		if (wcfm_is_vendor()) {
			$user_id = get_current_user_id();
		} else {
			$user_id = absint($form_field_data['vendor_id']);
		}
		$place_id = isset($form_field_data['wcfm_google_review_place_id']) ? $form_field_data['wcfm_google_review_place_id'] : '';

		$lang = isset($form_field_data['wcfm_google_review_lang']) ? $form_field_data['wcfm_google_review_lang'] : '';

		$place_id = sanitize_text_field(trim($place_id));
		$lang = sanitize_text_field(trim($lang));
		 
		update_user_meta($user_id, 'wcfm_google_review_place_id', $place_id);
		update_user_meta($user_id, 'wcfm_google_review_lang', $lang);
	}

}
