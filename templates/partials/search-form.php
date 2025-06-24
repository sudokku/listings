<?php
/**
 * Search form template part for listings
 *
 * @package Listings
 */

// Get current search query
$current_search = get_search_query();
$current_location = isset($_GET['location']) ? sanitize_text_field($_GET['location']) : '';
$current_type = isset($_GET['listing_type']) ? sanitize_text_field($_GET['listing_type']) : '';
$current_price_min = isset($_GET['price_min']) ? sanitize_text_field($_GET['price_min']) : '';
$current_price_max = isset($_GET['price_max']) ? sanitize_text_field($_GET['price_max']) : '';

// Get listing types for dropdown
$listing_types = get_terms(array(
    'taxonomy' => 'listing_type',
    'hide_empty' => false,
));
?>

<div class="listings-search-form">
    <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
        <input type="hidden" name="post_type" value="listing" />

        <div class="search-form-row">
            <div class="search-form-field">
                <label for="s"><?php esc_html_e('Search Listings', 'listings'); ?></label>
                <input type="search" id="s" name="s" value="<?php echo esc_attr($current_search); ?>"
                    placeholder="<?php esc_attr_e('Enter keywords...', 'listings'); ?>" />
            </div>

            <div class="search-form-field">
                <label for="location"><?php esc_html_e('Location', 'listings'); ?></label>
                <input type="text" id="location" name="location" value="<?php echo esc_attr($current_location); ?>"
                    placeholder="<?php esc_attr_e('City, State, or Address', 'listings'); ?>" />
            </div>
        </div>

        <div class="search-form-row">
            <div class="search-form-field">
                <label for="listing_type"><?php esc_html_e('Property Type', 'listings'); ?></label>
                <select id="listing_type" name="listing_type">
                    <option value=""><?php esc_html_e('All Types', 'listings'); ?></option>
                    <?php if ($listing_types && !is_wp_error($listing_types)): ?>
                        <?php foreach ($listing_types as $type): ?>
                            <option value="<?php echo esc_attr($type->slug); ?>" <?php selected($current_type, $type->slug); ?>>
                                <?php echo esc_html($type->name); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="search-form-field">
                <label for="price_min"><?php esc_html_e('Price Range', 'listings'); ?></label>
                <div class="price-range">
                    <input type="number" id="price_min" name="price_min"
                        value="<?php echo esc_attr($current_price_min); ?>"
                        placeholder="<?php esc_attr_e('Min', 'listings'); ?>" />
                    <span class="price-separator">-</span>
                    <input type="number" id="price_max" name="price_max"
                        value="<?php echo esc_attr($current_price_max); ?>"
                        placeholder="<?php esc_attr_e('Max', 'listings'); ?>" />
                </div>
            </div>
        </div>

        <div class="search-form-submit">
            <button type="submit" class="search-submit">
                <?php esc_html_e('Search Listings', 'listings'); ?>
            </button>
        </div>
    </form>
</div>