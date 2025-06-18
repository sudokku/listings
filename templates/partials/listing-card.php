<?php
/**
 * Template part for displaying a listing card
 *
 * @package Listings
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Get the post ID from the global post if not provided
$post_id = isset($args['post_id']) ? $args['post_id'] : get_the_ID();

// Prepare the data
$data = array(
    'title' => get_the_title($post_id),
    'permalink' => get_permalink($post_id),
    'price' => get_post_meta($post_id, '_listing_price', true),
    'area' => get_post_meta($post_id, '_listing_area', true),
    'bedrooms' => get_post_meta($post_id, '_listing_bedrooms', true),
    'bathrooms' => get_post_meta($post_id, '_listing_bathrooms', true),
    'location' => get_post_meta($post_id, '_listing_location', true),
    'property_type' => get_the_terms($post_id, 'property_type'),
    'listing_type' => get_the_terms($post_id, 'listing_type'),
    'thumbnail' => get_the_post_thumbnail($post_id, 'medium'),
    'excerpt' => get_the_excerpt($post_id),
);

// Apply filters to allow customization of the data
$data = apply_filters('listings_card_data', $data, $post_id);

// Set default arguments
$defaults = array(
    'show_excerpt' => true,
    'show_location' => true,
    'show_meta' => true,
);

// Parse arguments
$args = isset($args) ? wp_parse_args($args, $defaults) : $defaults;
?>

<article id="listing-<?= $post_id ?>" <?php post_class('listing-card'); ?>>
    <div class="listing-card__image">
        <?php if ($data['thumbnail']): ?>
            <a href="<?php echo esc_url($data['permalink']); ?>">
                <?php echo $data['thumbnail']; ?>
            </a>
        <?php endif; ?>

        <?php if ($data['property_type'] && !is_wp_error($data['property_type'])): ?>
            <span class="listing-card__type">
                <?php echo esc_html($data['property_type'][0]->name); ?>
            </span>
        <?php endif; ?>
    </div>

    <div class="listing-card__content">
        <h2 class="listing-card__title">
            <a href="<?php echo esc_url($data['permalink']); ?>">
                <?php echo esc_html($data['title']); ?>
            </a>
        </h2>

        <?php if ($data['price']): ?>
            <div class="listing-card__price">
                <?php echo esc_html($data['price']); ?>
            </div>
        <?php endif; ?>

        <?php if ($args['show_location'] && $data['location']): ?>
            <div class="listing-card__location">
                <i class="fas fa-map-marker-alt"></i>
                <?php echo esc_html($data['location']); ?>
            </div>
        <?php endif; ?>

        <?php if ($args['show_meta']): ?>
            <div class="listing-card__meta">
                <?php if ($data['area']): ?>
                    <span class="listing-card__area">
                        <i class="fas fa-vector-square"></i>
                        <?php echo esc_html($data['area']); ?>
                    </span>
                <?php endif; ?>

                <?php if ($data['bedrooms']): ?>
                    <span class="listing-card__bedrooms">
                        <i class="fas fa-bed"></i>
                        <?php echo esc_html($data['bedrooms']); ?>
                    </span>
                <?php endif; ?>

                <?php if ($data['bathrooms']): ?>
                    <span class="listing-card__bathrooms">
                        <i class="fas fa-bath"></i>
                        <?php echo esc_html($data['bathrooms']); ?>
                    </span>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($args['show_excerpt'] && $data['excerpt']): ?>
            <div class="listing-card__excerpt">
                <?php echo wp_trim_words($data['excerpt'], 20); ?>
            </div>
        <?php endif; ?>
    </div>
</article>