<?php
/**
 * Server-side rendering of the listing info block.
 *
 * @package Listings
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Renders the listing info block.
 *
 * @param array $attributes Block attributes.
 * @return string Rendered block content.
 */
function render_listing_info_block($attributes)
{
    $listing_id = isset($attributes['listingId']) ? intval($attributes['listingId']) : 0;

    if (!$listing_id) {
        return '';
    }

    $listing = get_post($listing_id);
    if (!$listing || $listing->post_type !== 'listing') {
        return '';
    }

    $price = get_post_meta($listing_id, '_listing_price', true);
    $sale_price = get_post_meta($listing_id, '_listing_sale_price', true);
    $rooms = get_post_meta($listing_id, '_listing_rooms', true);
    $area = get_post_meta($listing_id, '_listing_area', true);
    $area_unit = get_post_meta($listing_id, '_listing_area_unit', true);
    $featured_image = get_the_post_thumbnail_url($listing_id, 'large');

    ob_start();
    ?>
    <div class="listing-info-block">
        <?php if ($featured_image && $attributes['showImage']): ?>
            <div class="listing-image">
                <img src="<?php echo esc_url($featured_image); ?>" alt="<?php echo esc_attr($listing->post_title); ?>">
            </div>
        <?php endif; ?>

        <?php if ($attributes['showTitle']): ?>
            <h2 class="listing-title"><?php echo esc_html($listing->post_title); ?></h2>
        <?php endif; ?>

        <?php if ($attributes['showPrice']): ?>
            <div class="listing-price">
                <?php if ($sale_price): ?>
                    <span class="sale-price">
                        <?php esc_html_e('Sale Price:', 'listings'); ?> $<?php echo esc_html($sale_price); ?>
                    </span>
                    <span class="original-price">
                        <?php esc_html_e('Original Price:', 'listings'); ?> $<?php echo esc_html($price); ?>
                    </span>
                <?php else: ?>
                    <span class="regular-price">
                        <?php esc_html_e('Price:', 'listings'); ?> $<?php echo esc_html($price); ?>
                    </span>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($attributes['showExcerpt']): ?>
            <div class="listing-excerpt">
                <?php echo wp_kses_post($listing->post_excerpt); ?>
            </div>
        <?php endif; ?>

        <div class="listing-details">
            <?php if ($rooms && $attributes['showRooms']): ?>
                <div class="listing-rooms">
                    <strong><?php esc_html_e('Rooms:', 'listings'); ?></strong>
                    <?php echo esc_html($rooms); ?>
                </div>
            <?php endif; ?>

            <?php if ($area && $attributes['showArea']): ?>
                <div class="listing-area">
                    <strong><?php esc_html_e('Area:', 'listings'); ?></strong>
                    <?php echo esc_html($area); ?>         <?php echo esc_html($area_unit); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}