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

	/**
	 * Method run when reload the site.
	 *
	 * @since    1.0.0
	 */
	public function public_init()
	{	
		global $WCFM, $WCFMmp,$WCFMu;
		$wcfm_store_url = get_option( 'wcfm_store_url', 'store' ); 
		add_rewrite_endpoint( 'google_reviews', EP_ROOT | EP_PAGES ); 
		 
	}

	/**
	 * Initialized new tab on frontend store page .
	 *
	 * @since    1.0.0
	 * @param    array    $tabs       tab name array.
	 * @return 	 array    $tabs  	  Add google_reviews val and return.
	 */
	public function add_store_google_review_tab($tabs)
	{ 
		$tabs['google_reviews'] = "Google Reviews";
		return $tabs;
	}


	/**
	 * Set url in Google Reviews tab in frontend Stor page.
	 *
	 * @since    1.0.0
	 * @param      string    $store_tab_url     Store tab url.
	 * @param      string    $tab    			Tab name.
	 * @return     string 	 $store_tab_url 	New tab url 
	 */
	public function store_google_review_tab_url($store_tab_url, $tab)
	{ 
		global $WCFMmp;

		//wcfmmp_get_store_url
		if ($tab == "google_reviews") {
			$store_tab_url = $store_tab_url.'google_reviews';		
		}

		return $store_tab_url;
	}
 	
 	/**
	 * Set new query variable on store page.
	 *
	 * @since    1.0.0
	 * @param      string    $query_var    		query_var.
	 * @return     string 	 $query_var 		set new query variable
	 */
	public function wcfm_store_events_default_query_var2( $query_var ) {
	 	global $WCFM, $WCFMmp;
	  
	  	if ( get_query_var( 'google_reviews' ) ) {
	    	$query_var = 'google_reviews';
	  	}
	  	return $query_var;
	}

	/**
	 * Add new register rule2 on store page.
	 *
	 * @since    1.0.0
	 * @param      string    $wcfm_store_url    		store url.
	 */
	public function new_register_rule2($wcfm_store_url) {
		global $WCFM, $WCFMmp;
		
		add_rewrite_rule( $wcfm_store_url.'/([^/]+)/'.$WCFMmp->wcfmmp_rewrite->store_endpoint('google_reviews').'?$', 'index.php?post_type=post&'.$wcfm_store_url.'=$matches[1]&'.$WCFMmp->wcfmmp_rewrite->store_endpoint('google_reviews').'=true', 'top' );
		add_rewrite_rule( $wcfm_store_url.'/([^/]+)/'.$WCFMmp->wcfmmp_rewrite->store_endpoint('google_reviews').'/page/?([0-9]{1,})/?$', 'index.php?post_type=post&'.$wcfm_store_url.'=$matches[1]&paged=$matches[2]&'.$WCFMmp->wcfmmp_rewrite->store_endpoint('google_reviews').'=true', 'top' );
	}

	/**
	 * This method is set template Url.
	 *
	 * @since    1.0.0
	 * @param      string    $url    			template url.
	 * @param      string    $store_tab    		tab slug.
	 * @return     string 	 $url 				google reviews template url
	 */
	public function wcfmmp_store_google_review_template($url, $store_tab)
	{ 
		if($store_tab == "google_reviews"){
			
			$url = 'store/wcfmmp-view-store-google_reviews.php';	
		}
		return $url;
	}

	/**
	 * This method is set reviews setting.
	 *
	 * @since    1.0.0
	 * @param      string    $vendor_id    		store id.
	*/
	public function gmb_reviews_setting($vendor_id)
	{
		global $WCFM, $WCFMmp,$WCFMu;
		?>
		<div class="page_collapsible" id="wcfm_settings_location_head">
			<label class="wcfmfa fa-globe"></label>
			<?php _e('GMB Reviews', 'wcfm-vendor-store-google-reviews'); ?><span></span>
		</div>
		<div class="wcfm-container wcfm_marketplace_store_location_settings">
			<div id="wcfm_settings_form_store_location_expander" class="wcfm-content">
				<div class="wcfm_clearfix"></div>
				<div class="wcfm_vendor_settings_heading"><h2><?php _e( 'Google My Business Reviews Setting', 'wcfm-vendor-store-google-reviews' ); ?></h2></div>
				<div class="wcfm_clearfix"></div>
				<div class="store_address store_address_wrap">
					<?php
					$place_id = get_user_meta($vendor_id, 'wcfm_google_review_place_id',true);
					$lang = get_user_meta($vendor_id, 'wcfm_google_review_lang',true);

					$api_key = get_user_meta($vendor_id, 'ets_wcfm_gmb_reviews_api_key',true);

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

					?>

					<p class="description"><?php echo __("You can find your unique Place ID by searching by your business’ name in", "wcfm-vendor-store-google-reviews"); ?> <a href="https://developers.google.com/places/place-id" class="components-external-link" target="_blank">Google’s Place ID Finder</a>. <?php echo __("Single business locations are accepted; coverage areas are not accepted.","wcfm-vendor-store-google-reviews"); ?></p>
      
					<div class="wcfm-lang-gr">
						<p class="wcfm_google_review_lang wcfm_title lang_field"><strong><?php echo __('Retrieval Language', "wcfm-vendor-store-google-reviews"); ?></strong></p>
						<label class="screen-reader-text" for="wcfm_google_review_lang"><?php echo __('Retrieval Language', "wcfm-vendor-store-google-reviews"); ?></label>

						<select name="wcfm_google_review_lang" class="wcfm-select wcfm_ele lang_field">
							<?php
								$languages = Wcfm_Vendor_Store_Google_Reviews_Public::languages();
								if ($languages) {
									foreach ($languages as $code => $language) {
										if($lang == $code) {
											echo '<option value="'.$code.'" selected>'.$language.'</option>';
										} else {
											echo '<option value="'.$code.'">'.$language.'</option>';
										}
									}
								}
							?>
						</select>
					</div>
					<?php

					$WCFM->wcfm_fields->wcfm_generate_form_field(
						array( 
							"ets_wcfm_gmb_reviews_api_key" => array( 
								'label' => __( 'Google Api Key', 'wcfm-vendor-store-google-reviews' ) ,
								'type'  => 'text',
								'class' => 'wcfm-text wcfm_ele lang_field',
								'label_class' => 'wcfm_title lang_field',
								'value' => $api_key 
							)
						)
					);
					?>
				</div>
			</div>
		</div>

		<?php
	}

	
	/**
	 * This method is save Google My Business Reviews Setting fields infromation.
	 *
	 * @since    1.0.0
	 * @param      array    $form_field_data    	submitted form array.
	*/
	public function place_id_save($form_field_data)
	{
		if (wcfm_is_vendor()) {
			$user_id = get_current_user_id();
		} else {
			$user_id = absint($form_field_data['vendor_id']);
		}
		$place_id = isset($form_field_data['wcfm_google_review_place_id']) ? $form_field_data['wcfm_google_review_place_id'] : '';

		$lang = isset($form_field_data['wcfm_google_review_lang']) ? $form_field_data['wcfm_google_review_lang'] : '';

		$api_key = isset($form_field_data['ets_wcfm_gmb_reviews_api_key']) ? $form_field_data['ets_wcfm_gmb_reviews_api_key'] : '';

		$place_id = sanitize_text_field(trim($place_id));
		$lang = sanitize_text_field(trim($lang));
		 
		update_user_meta($user_id, 'wcfm_google_review_place_id', $place_id);
		update_user_meta($user_id, 'wcfm_google_review_lang', $lang);
		update_user_meta($user_id, 'ets_wcfm_gmb_reviews_api_key', $api_key);
	}

	/**
	 * This method is create languag array.
	 *
	 * @since    1.0.0
	 * @return      array   languag array with lang code.
	*/
	protected function languages()
	{
		return array(
			'en' => 'English',
			'af' => 'Afrikaans',
			'sq' => 'Albanian',
			'am' => 'Amharic',
			'ar' => 'Arabic',
			'hy' => 'Armenian',
			'az' => 'Azerbaijani',
			'eu' => 'Basque',
			'be' => 'Belarusian',
			'bn' => 'Bengali',
			'bs' => 'Bosnian',
			'bg' => 'Bulgarian',
			'my' => 'Burmese',
			'ca' => 'Catalan',
			'zh' => 'Chinese',
			'zh-CN' => 'Chinese (Simplified)',
			'zh-HK' => 'Chinese (Hong Kong)',
			'zh-TW' => 'Chinese (Traditional)',
			'hr' => 'Croatian',
			'cs' => 'Czech',
			'da' => 'Danish',
			'nl' => 'Dutch',
			'en-AU' => 'English (Australian)',
			'en-GB' => 'English (Great Britain)',
			'et' => 'Estonian',
			'fa' => 'Farsi',
			'fi' => 'Finnish',
			'fil' => 'Filipino',
			'fr' => 'French',
			'fr-CA' => 'French (Canada)',
			'gl' => 'Galician',
			'ka' => 'Georgian',
			'de' => 'German',
			'el' => 'Greek',
			'gu' => 'Gujarati',
			'iw' => 'Hebrew',
			'hi' => 'Hindi',
			'hu' => 'Hungarian',
			'is' => 'Icelandic',
			'id' => 'Indonesian',
			'it' => 'Italian',
			'ja' => 'Japanese',
			'kn' => 'Kannada',
			'kk' => 'Kazakh',
			'km' => 'Khmer',
			'ko' => 'Korean',
			'ky' => 'Kyrgyz',
			'lo' => 'Lao',
			'lv' => 'Latvian',
			'lt' => 'Lithuanian',
			'mk' => 'Macedonian',
			'ms' => 'Malay',
			'ml' => 'Malayalam',
			'mr' => 'Marathi',
			'mn' => 'Mongolian',
			'ne' => 'Nepali',
			'no' => 'Norwegian',
			'pl' => 'Polish',
			'pt' => 'Portuguese',
			'pt-BR' => 'Portuguese (Brazil)',
			'pt-PT' => 'Portuguese (Portugal)',
			'pa' => 'Punjabi',
			'ro' => 'Romanian',
			'ru' => 'Russian',
			'sr' => 'Serbian',
			'si' => 'Sinhalese',
			'sk' => 'Slovak',
			'sl' => 'Slovenian',
			'es' => 'Spanish',
			'es-419' => 'Spanish (Latin America)',
			'sw' => 'Swahili',
			'sv' => 'Swedish',
			'ta' => 'Tamil',
			'te' => 'Telugu',
			'th' => 'Thai',
			'tr' => 'Turkish',
			'uk' => 'Ukrainian',
			'ur' => 'Urdu',
			'uz' => 'Uzbek',
			'vi' => 'Vietnamese',
			'zu' => 'Zulu'
		);
	}

}
