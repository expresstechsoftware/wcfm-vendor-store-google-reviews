<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://www.expresstechsoftwares.com
 * @since      1.0.0
 *
 * @package    Wcfm_Vendor_Store_Google_Reviews
 * @subpackage Wcfm_Vendor_Store_Google_Reviews/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php
global $WCFM, $WCFMmp,$WCFMu;

$place_id = $new_review_detail = $api_key = $total_review = $total_rate = $total_rate_star = '';
$wcfm_store_url    = wcfm_get_option( 'wcfm_store_url', 'store' );
$wcfm_store_name   = apply_filters( 'wcfmmp_store_query_var', get_query_var( $wcfm_store_url ) );

if ( empty( $wcfm_store_name ) ) return;

$seller_info       = get_user_by( 'slug', $wcfm_store_name );

if( !$seller_info ) return;

$store_user        = wcfmmp_get_store( $seller_info->ID );

$store_id = isset($store_user->id) ? $store_user->id : '';
$lang = 'en';

if($store_id) {
	$place_id = get_user_meta($store_id, 'wcfm_google_review_place_id', true);
	$lang = get_user_meta($store_id, 'wcfm_google_review_lang', true);
	
	// Get Google Api Key
	$api_key = get_user_meta($store_id, 'ets_wcfm_gmb_reviews_api_key', true);

}

if($place_id) {
	// Google MAp  Api call.
	$url = 'https://maps.googleapis.com/maps/api/place/details/json?key='.$api_key.'&placeid='.$place_id.'&language='.$lang;	 

	$new_review = file_get_contents($url);
	$new_review_detail = json_decode($new_review);

	$total_review = isset($new_review_detail->result->user_ratings_total) ? $new_review_detail->result->user_ratings_total : '';

	$total_rate =  isset($new_review_detail->result->rating) ? $new_review_detail->result->rating : 0;
	$total_rate_star =  $total_rate;

	// Get Store name
	$store_name = isset($new_review_detail->result->name) ? $new_review_detail->result->name : __('Google Reviews', "wcfm-vendor-store-google-reviews");

	// Get Store address
	$address = isset($new_review_detail->result->adr_address) ? $new_review_detail->result->adr_address : '';

	if(!$address) {
		$address = isset($new_review_detail->result->formatted_address) ? $new_review_detail->result->formatted_address : '';
	}
}
?>
<div class="wcfm-store-gr-wraper">
	<h2><?php echo $store_name; ?></h2>
	<span class="wcfm-store-gr-adr"><?php echo $address; ?></span>
	<div class="wcfm-gr-total-rating">
		<span class="wcfm-gr-total-rate"><?php echo $total_rate; ?></span>
		
		<ul>
			<li><div class="wcfm-store-gr-stars">
					<div class="wcfm-store-gr-percent" style="width: <?php echo $total_rate_star * 20; ?>%; "></div>
				</div>
			</li>
		</ul>
		<span><?php if($total_review) echo " ".$total_review. ' reviews' ; ?></span>
	</div>

	<?php 
	if(isset($new_review_detail->result->reviews) && $new_review_detail->result->reviews) {
		$reviews = $new_review_detail->result->reviews;
		?>
		<div class="wcfm-google-review-list"> <?php
		foreach ($reviews as $key => $review) {

			$author_name = isset($review->author_name) ? $review->author_name : '';

			$author_url = isset($review->author_url) ? $review->author_url : '';
			
			$author_photo = isset($review->profile_photo_url) ? $review->profile_photo_url : '';

			$relative_time_des = isset($review->relative_time_description) ? $review->relative_time_description : '';
			
			$rating = isset($review->rating) ? $review->rating : '';
			
			$text = isset($review->text) ? $review->text : '';
			
			$time = isset($review->time) ? $review->time : '';
			?> 
			<div class="wcfm-g-review-card">
				<img src="<?php echo $author_photo; ?>" class="wcfm-photo-usr" width="100" height="100" />
				<div class="wcfm-g-review-des">
					<a href="<?php echo $author_url; ?>">
						<h4><?php echo $author_name; ?></h4>
					</a>

					<div class="wcfm-g-review-star-rate-wrap">
						<div class="wcfm-g-review-star-rate">
							<ul>
								<li><div class="wcfm-store-gr-stars">
										<div class="wcfm-store-gr-percent" style="width: <?php echo $rating * 20; ?>%; "></div>
									</div>
								</li>
							</ul>
						</div>
						<div class="wcfm-g-r-rtv-time-des">
							<span><?php echo $relative_time_des; ?></span>
						</div>
					</div> 
					<p><?php echo $text; ?></p>
				</div>
			</div> 
			<?php
			
		} ?>
		</div>
		<?php
	} else {
		echo "<br>";
		echo __("No Record Found","wcfm-vendor-store-google-reviews");
	}

	?>
</div>