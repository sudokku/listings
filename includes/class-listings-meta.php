<?php

/**
 * Handles the custom meta boxes and fields for the Listing post type
 */
class Listings_Meta
{

    /**
     * Initialize the class and set its properties.
     */
    public function __construct()
    {
        add_action('add_meta_boxes', array($this, 'add_listing_meta_boxes'));
        add_action('save_post_listing', array($this, 'save_listing_meta'));
    }

    /**
     * Add meta boxes for the listing post type
     */
    public function add_listing_meta_boxes()
    {
        add_meta_box(
            'listing_details',
            __('Property Details', 'listings'),
            array($this, 'render_details_meta_box'),
            'listing',
            'normal',
            'high'
        );

        add_meta_box(
            'listing_location',
            __('Location Details', 'listings'),
            array($this, 'render_location_meta_box'),
            'listing',
            'normal',
            'high'
        );

        add_meta_box(
            'listing_features',
            __('Interior Features', 'listings'),
            array($this, 'render_features_meta_box'),
            'listing',
            'normal',
            'high'
        );

        add_meta_box(
            'listing_pricing',
            __('Pricing Information', 'listings'),
            array($this, 'render_pricing_meta_box'),
            'listing',
            'side',
            'high'
        );
    }

    /**
     * Render the property details meta box
     */
    public function render_details_meta_box($post)
    {
        wp_nonce_field('listing_meta_box', 'listing_meta_box_nonce');

        $rooms = get_post_meta($post->ID, '_listing_rooms', true);
        $bedrooms = get_post_meta($post->ID, '_listing_bedrooms', true);
        $bathrooms = get_post_meta($post->ID, '_listing_bathrooms', true);
        $has_garage = get_post_meta($post->ID, '_listing_has_garage', true);
        $garage_capacity = get_post_meta($post->ID, '_listing_garage_capacity', true);
        $area = get_post_meta($post->ID, '_listing_area', true);
        $area_unit = get_post_meta($post->ID, '_listing_area_unit', true);
        $year_built = get_post_meta($post->ID, '_listing_year_built', true);

        ?>
        <div class="listing-meta-box">
            <p>
                <label for="listing_rooms"><?php _e('Total Rooms:', 'listings'); ?></label>
                <input type="number" id="listing_rooms" name="listing_rooms" value="<?php echo esc_attr($rooms); ?>" min="0">
            </p>
            <p>
                <label for="listing_bedrooms"><?php _e('Bedrooms:', 'listings'); ?></label>
                <input type="number" id="listing_bedrooms" name="listing_bedrooms" value="<?php echo esc_attr($bedrooms); ?>"
                    min="0">
            </p>
            <p>
                <label for="listing_bathrooms"><?php _e('Bathrooms:', 'listings'); ?></label>
                <input type="number" id="listing_bathrooms" name="listing_bathrooms" value="<?php echo esc_attr($bathrooms); ?>"
                    min="0" step="0.5">
            </p>
            <p>
                <label for="listing_has_garage"><?php _e('Has Garage:', 'listings'); ?></label>
                <input type="checkbox" id="listing_has_garage" name="listing_has_garage" value="1" <?php checked($has_garage, '1'); ?>>
            </p>
            <p class="garage-capacity" style="<?php echo $has_garage ? '' : 'display: none;'; ?>">
                <label for="listing_garage_capacity"><?php _e('Garage Capacity (cars):', 'listings'); ?></label>
                <input type="number" id="listing_garage_capacity" name="listing_garage_capacity"
                    value="<?php echo esc_attr($garage_capacity); ?>" min="1">
            </p>
            <p>
                <label for="listing_area"><?php _e('Total Area:', 'listings'); ?></label>
                <input type="number" id="listing_area" name="listing_area" value="<?php echo esc_attr($area); ?>" min="0"
                    step="0.01">
                <select name="listing_area_unit" id="listing_area_unit">
                    <option value="sqft" <?php selected($area_unit, 'sqft'); ?>>Square Feet</option>
                    <option value="sqm" <?php selected($area_unit, 'sqm'); ?>>Square Meters</option>
                </select>
            </p>
            <p>
                <label for="listing_year_built"><?php _e('Year Built:', 'listings'); ?></label>
                <input type="number" id="listing_year_built" name="listing_year_built"
                    value="<?php echo esc_attr($year_built); ?>" min="1800" max="<?php echo date('Y'); ?>">
            </p>
        </div>
        <?php
    }

    /**
     * Render the location meta box
     */
    public function render_location_meta_box($post)
    {
        $address = get_post_meta($post->ID, '_listing_address', true);
        $city = get_post_meta($post->ID, '_listing_city', true);
        $state = get_post_meta($post->ID, '_listing_state', true);
        $country = get_post_meta($post->ID, '_listing_country', true);
        $zip = get_post_meta($post->ID, '_listing_zip', true);

        ?>
        <div class="listing-meta-box">
            <p>
                <label for="listing_address"><?php _e('Street Address:', 'listings'); ?></label>
                <input type="text" id="listing_address" name="listing_address" value="<?php echo esc_attr($address); ?>"
                    class="widefat">
            </p>
            <p>
                <label for="listing_city"><?php _e('City:', 'listings'); ?></label>
                <input type="text" id="listing_city" name="listing_city" value="<?php echo esc_attr($city); ?>" class="widefat">
            </p>
            <p>
                <label for="listing_state"><?php _e('State/County:', 'listings'); ?></label>
                <input type="text" id="listing_state" name="listing_state" value="<?php echo esc_attr($state); ?>"
                    class="widefat">
            </p>
            <p>
                <label for="listing_country"><?php _e('Country:', 'listings'); ?></label>
                <input type="text" id="listing_country" name="listing_country" value="<?php echo esc_attr($country); ?>"
                    class="widefat">
            </p>
            <p>
                <label for="listing_zip"><?php _e('ZIP/Postal Code:', 'listings'); ?></label>
                <input type="text" id="listing_zip" name="listing_zip" value="<?php echo esc_attr($zip); ?>" class="widefat">
            </p>
        </div>
        <?php
    }

    /**
     * Render the features meta box
     */
    public function render_features_meta_box($post)
    {
        $features = get_post_meta($post->ID, '_listing_features', true);
        if (!is_array($features)) {
            $features = array();
        }
        ?>
        <div class="listing-meta-box">
            <div id="listing-features-container">
                <?php foreach ($features as $index => $feature): ?>
                    <p class="feature-item">
                        <input type="text" name="listing_features[]" value="<?php echo esc_attr($feature); ?>" class="widefat">
                        <button type="button" class="button remove-feature"><?php _e('Remove', 'listings'); ?></button>
                    </p>
                <?php endforeach; ?>
            </div>
            <button type="button" class="button add-feature"><?php _e('Add Feature', 'listings'); ?></button>
        </div>
        <?php
    }

    /**
     * Render the pricing meta box
     */
    public function render_pricing_meta_box($post)
    {
        $price = get_post_meta($post->ID, '_listing_price', true);
        $sale_price = get_post_meta($post->ID, '_listing_sale_price', true);
        ?>
        <div class="listing-meta-box">
            <p>
                <label for="listing_price"><?php _e('Regular Price:', 'listings'); ?></label>
                <input type="number" id="listing_price" name="listing_price" value="<?php echo esc_attr($price); ?>" min="0"
                    step="0.01">
            </p>
            <p>
                <label for="listing_sale_price"><?php _e('Sale Price:', 'listings'); ?></label>
                <input type="number" id="listing_sale_price" name="listing_sale_price"
                    value="<?php echo esc_attr($sale_price); ?>" min="0" step="0.01">
            </p>
        </div>
        <?php
    }

    /**
     * Save the meta box data
     */
    public function save_listing_meta($post_id)
    {
        if (!isset($_POST['listing_meta_box_nonce'])) {
            return;
        }

        if (!wp_verify_nonce($_POST['listing_meta_box_nonce'], 'listing_meta_box')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // Save property details
        $fields = array(
            'listing_rooms',
            'listing_bedrooms',
            'listing_bathrooms',
            'listing_area',
            'listing_area_unit',
            'listing_year_built',
            'listing_address',
            'listing_city',
            'listing_state',
            'listing_country',
            'listing_zip',
            'listing_price',
            'listing_sale_price'
        );

        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
            }
        }

        // Save has_garage
        $has_garage = isset($_POST['listing_has_garage']) ? '1' : '0';
        update_post_meta($post_id, '_listing_has_garage', $has_garage);

        // Save garage capacity if has garage
        if ($has_garage && isset($_POST['listing_garage_capacity'])) {
            update_post_meta($post_id, '_listing_garage_capacity', sanitize_text_field($_POST['listing_garage_capacity']));
        }

        // Save features
        if (isset($_POST['listing_features']) && is_array($_POST['listing_features'])) {
            $features = array_map('sanitize_text_field', $_POST['listing_features']);
            $features = array_filter($features); // Remove empty values
            update_post_meta($post_id, '_listing_features', $features);
        }
    }
}