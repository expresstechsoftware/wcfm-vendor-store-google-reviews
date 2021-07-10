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

$place_id = 'ChIJh28tb8z9YjkRBG_q9uO1RZY';

// Get Google Api Key
$wcfm_marketplace_options = wcfm_get_option( 'wcfm_marketplace_options', array() );
$apiKey = isset( $wcfm_marketplace_options['wcfm_google_map_api'] ) ? $wcfm_marketplace_options['wcfm_google_map_api'] : '';


// Google MAp  Api call.
$newUrl = 'https://maps.googleapis.com/maps/api/place/details/json?key='.$apiKey.'&placeid='.$place_id;	 

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
	}

	?>
</div>