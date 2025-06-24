<?php
/**
 * Server-side rendering of the `listings/listing-gallery` block.
 *
 * @package Listings
 */

$listing_id = $attributes['listingId'] ?? 0;

if (!$listing_id): ?>
	<p <?php echo get_block_wrapper_attributes(); ?>>
		<?php esc_html_e('Please select a listing to display the gallery.', 'listings'); ?>
	</p>
	<?php return;
endif;

// Get the listing
$listing = get_post($listing_id);
if (!$listing || $listing->post_type !== 'listing'): ?>
	<p <?php echo get_block_wrapper_attributes(); ?>>
		<?php esc_html_e('Selected listing not found.', 'listings'); ?>
	</p>
	<?php return;
endif;

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

if (empty($gallery_images)): ?>
	<p <?php echo get_block_wrapper_attributes(); ?>>
		<?php esc_html_e('No gallery images found for this listing.', 'listings'); ?>
	</p>
	<?php return;
endif;

// Filter out invalid image IDs and get image data
$valid_images = array();
foreach ($gallery_images as $image_id) {
	$image_id = trim($image_id);
	if (wp_attachment_is_image($image_id)) {
		$image_data = wp_get_attachment_image_src($image_id, 'large');
		$thumbnail_data = wp_get_attachment_image_src($image_id, 'thumbnail');
		$alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true);

		if ($image_data) {
			$valid_images[] = array(
				'id' => $image_id,
				'url' => $image_data[0],
				'thumbnail' => $thumbnail_data ? $thumbnail_data[0] : $image_data[0],
				'alt' => $alt_text,
				'width' => $image_data[1],
				'height' => $image_data[2]
			);
		}
	}
}

if (empty($valid_images)): ?>
	<p <?php echo get_block_wrapper_attributes(); ?>>
		<?php esc_html_e('No valid gallery images found for this listing.', 'listings'); ?>
	</p>
	<?php return;
endif;

$wrapper_attributes = get_block_wrapper_attributes(array(
	'class' => 'listing-gallery-grid-style'
)); ?>

<div <?php echo $wrapper_attributes; ?>>
	<?php foreach (array_slice($valid_images, 0, 5) as $idx => $image): ?>
		<div class="gallery-item<?php echo $idx === 0 ? ' gallery-item--hero' : ''; ?>">
			<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"
				class="gallery-item__img" />
		</div>
	<?php endforeach; ?>
</div>