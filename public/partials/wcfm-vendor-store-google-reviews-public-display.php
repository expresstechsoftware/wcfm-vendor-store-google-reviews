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

$place_id = $newReviewDetail = $api_key = '';
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
	$newUrl = 'https://maps.googleapis.com/maps/api/place/details/json?key='.$api_key.'&placeid='.$place_id.'&language='.$lang;	 

	$newReview = file_get_contents($newUrl);
	$newReviewDetail = json_decode($newReview);

	// Get Store name
	$storeName = isset($newReviewDetail->result->name) ? $newReviewDetail->result->name : 'Google Reviews';

	// Get Store address
	$address = '';
	$adr_address = isset($newReviewDetail->result->adr_address) ? $newReviewDetail->result->adr_address : '';

	if(!$adr_address) {
		$adr_address = isset($newReviewDetail->result->formatted_address) ? $newReviewDetail->result->formatted_address : '';
	} 
	$address = $adr_address;

}

?>
<div class="wcfm-store-gr-wraper">
	<h2><?php echo $storeName; ?></h2>
	<span class="wcfm-store-gr-adr"><?php echo $address; ?></span>
	<?php 
	if(isset($newReviewDetail->result->reviews) && $newReviewDetail->result->reviews) {
		$reviews = $newReviewDetail->result->reviews;
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
							<?php
							foreach (range(1, 5) as $key => $value) {
								if($value <= $rating ){
									echo '<span class="fa fa-star wcfm-star-checked"></span>';
								} else {
									echo '<span class="fa fa-star"></span>';
								}
							}
							?>
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
		echo "<br>No Record Found...";
	}

	?>
</div>