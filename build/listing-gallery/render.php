<?php
/**
 * Server-side rendering of the `listings/listing-gallery` block.
 *
 * @package Listings
 */

$listing_id = $attributes['listingId'] ?? 0;

if (!$listing_id) {
	return '<p>' . esc_html__('Please select a listing to display the gallery.', 'listings') . '</p>';
}

// Get the listing
$listing = get_post($listing_id);
if (!$listing || $listing->post_type !== 'listing') {
	return '<p>' . esc_html__('Selected listing not found.', 'listings') . '</p>';
}

// Get gallery images
$gallery_images_raw = get_post_meta($listing_id, '_listing_gallery_images', true);
$gallery_images = array();

if (!empty($gallery_images_raw)) {
	if (is_array($gallery_images_raw)) {
		// Handle old array format
		$gallery_images = $gallery_images_raw;
	} else {
		// Handle new string format
		$gallery_images = array_filter(explode(',', $gallery_images_raw));
	}
}

if (empty($gallery_images)) {
	return '<p>' . esc_html__('No gallery images found for this listing.', 'listings') . '</p>';
}

// Filter out invalid image IDs
$valid_images = array();
foreach ($gallery_images as $image_id) {
	if (wp_attachment_is_image($image_id)) {
		$valid_images[] = $image_id;
	}
}

if (empty($valid_images)) {
	return '<p>' . esc_html__('No valid gallery images found for this listing.', 'listings') . '</p>';
}

$wrapper_attributes = get_block_wrapper_attributes(array(
	'class' => 'listing-gallery'
));

ob_start();
?>

<div <?php echo $wrapper_attributes; ?>>
	<div class="listing-gallery-container">
		<?php if (!empty($valid_images)): ?>
			<div class="listing-gallery-hero">
				<?php
				$hero_image_id = $valid_images[0];
				$hero_image_url = wp_get_attachment_image_url($hero_image_id, 'large');
				$hero_image_alt = get_post_meta($hero_image_id, '_wp_attachment_image_alt', true);
				?>
				<img src="<?php echo esc_url($hero_image_url); ?>" alt="<?php echo esc_attr($hero_image_alt); ?>"
					class="listing-gallery-hero-image" />
			</div>

			<?php if (count($valid_images) > 1): ?>
				<div class="listing-gallery-grid">
					<?php foreach (array_slice($valid_images, 1) as $image_id): ?>
						<?php
						$image_url = wp_get_attachment_image_url($image_id, 'thumbnail');
						$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
						?>
						<div class="listing-gallery-item">
							<img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>"
								class="listing-gallery-thumbnail" />
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		<?php endif; ?>
	</div>
</div>

<?php
return ob_get_clean();
?>