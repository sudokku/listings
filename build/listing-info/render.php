<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

/**
 * Server-side rendering of the listing info block
 */

$listing_id = $attributes['listingId'] ?? '';
if (empty($listing_id)): ?>
	<p <?php echo get_block_wrapper_attributes(); ?>>
		<?php esc_html_e('Please select a listing from the block settings.', 'listing-info'); ?>
	</p>
	<?php return;
endif;

$listing = get_post($listing_id);
if (!$listing || $listing->post_type !== 'listing'): ?>
	<p <?php echo get_block_wrapper_attributes(); ?>>
		<?php esc_html_e('Selected listing not found.', 'listing-info'); ?>
	</p>
	<?php return;
endif;

$wrapper_attributes = get_block_wrapper_attributes(['class' => 'listing-info-grid']); ?>

<div <?php echo $wrapper_attributes; ?>>
	<?php if (!empty($attributes['showRooms'])):
		$rooms = get_post_meta($listing_id, '_listing_rooms', true); ?>
		<div class="listing-info-column">
			<div class="listing-info-icon">
				<i class="fas fa-building"></i>
			</div>
			<div class="listing-info-content">
				<h4><?php echo esc_html($rooms ?: '-'); ?></h4>
				<p><?php esc_html_e('Total Rooms', 'listing-info'); ?></p>
			</div>
		</div>

		<?php if (!empty($attributes['showBedrooms'])):
			$bedrooms = get_post_meta($listing_id, '_listing_bedrooms', true); ?>
			<div class="listing-info-column">
				<div class="listing-info-icon">
					<i class="fas fa-bed"></i>
				</div>
				<div class="listing-info-content">
					<h4><?php echo esc_html($bedrooms ?: '-'); ?></h4>
					<p><?php esc_html_e('Bedrooms', 'listing-info'); ?></p>
				</div>
			</div>
		<?php endif;

		if (!empty($attributes['showBathrooms'])):
			$bathrooms = get_post_meta($listing_id, '_listing_bathrooms', true); ?>
			<div class="listing-info-column">
				<div class="listing-info-icon">
					<i class="fas fa-bath"></i>
				</div>
				<div class="listing-info-content">
					<h4><?php echo esc_html($bathrooms ?: '-'); ?></h4>
					<p><?php esc_html_e('Bathrooms', 'listing-info'); ?></p>
				</div>
			</div>
		<?php endif;
	endif;

	if (!empty($attributes['showGarageCapacity'])):
		$has_garage = get_post_meta($listing_id, '_listing_has_garage', true);
		if ($has_garage === '1'):
			$garage_capacity = get_post_meta($listing_id, '_listing_garage_capacity', true); ?>
			<div class="listing-info-column">
				<div class="listing-info-icon">
					<i class="fas fa-car"></i>
				</div>
				<div class="listing-info-content">
					<h4><?php printf(esc_html__('%s cars', 'listing-info'), esc_html($garage_capacity ?: '-')); ?></h4>
					<p><?php esc_html_e('Garage', 'listing-info'); ?></p>
				</div>
			</div>
		<?php endif;
	endif;

	if (!empty($attributes['showArea'])):
		$area = get_post_meta($listing_id, '_listing_area', true);
		$area_unit = get_post_meta($listing_id, '_listing_area_unit', true) ?: 'sqft'; ?>
		<div class="listing-info-column">
			<div class="listing-info-icon">
				<i class="fas fa-ruler-combined"></i>
			</div>
			<div class="listing-info-content">
				<h4><?php echo esc_html($area ?: '-') . ' ' . esc_html($area_unit); ?></h4>
				<p><?php esc_html_e('Area', 'listing-info'); ?></p>
			</div>
		</div>
	<?php endif;

	if (!empty($attributes['showYearBuilt'])):
		$year_built = get_post_meta($listing_id, '_listing_year_built', true); ?>
		<div class="listing-info-column">
			<div class="listing-info-icon">
				<i class="fas fa-calendar-alt"></i>
			</div>
			<div class="listing-info-content">
				<h4><?php echo esc_html($year_built ?: '-'); ?></h4>
				<p><?php esc_html_e('Year Built', 'listing-info'); ?></p>
			</div>
		</div>
	<?php endif; ?>
</div>