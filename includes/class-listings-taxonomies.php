<?php

/**
 * Handles the taxonomies for the Listing post type
 */
class Listings_Taxonomies
{

    /**
     * Initialize the class and set its properties.
     */
    public function __construct()
    {
        add_action('init', array($this, 'register_taxonomies'));
    }

    /**
     * Register the taxonomies
     */
    public function register_taxonomies()
    {
        // Property Type Taxonomy (hierarchical - like categories)
        $property_type_labels = array(
            'name' => _x('Property Types', 'taxonomy general name', 'listings'),
            'singular_name' => _x('Property Type', 'taxonomy singular name', 'listings'),
            'search_items' => __('Search Property Types', 'listings'),
            'all_items' => __('All Property Types', 'listings'),
            'parent_item' => __('Parent Property Type', 'listings'),
            'parent_item_colon' => __('Parent Property Type:', 'listings'),
            'edit_item' => __('Edit Property Type', 'listings'),
            'update_item' => __('Update Property Type', 'listings'),
            'add_new_item' => __('Add New Property Type', 'listings'),
            'new_item_name' => __('New Property Type Name', 'listings'),
            'menu_name' => __('Property Types', 'listings'),
        );

        $property_type_args = array(
            'hierarchical' => true,
            'labels' => $property_type_labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'property-type'),
            'show_in_rest' => true, // Enable Gutenberg editor support
        );

        register_taxonomy('property_type', array('listing'), $property_type_args);

        // Listing Type Taxonomy (non-hierarchical - like tags)
        $listing_type_labels = array(
            'name' => _x('Listing Types', 'taxonomy general name', 'listings'),
            'singular_name' => _x('Listing Type', 'taxonomy singular name', 'listings'),
            'search_items' => __('Search Listing Types', 'listings'),
            'all_items' => __('All Listing Types', 'listings'),
            'edit_item' => __('Edit Listing Type', 'listings'),
            'update_item' => __('Update Listing Type', 'listings'),
            'add_new_item' => __('Add New Listing Type', 'listings'),
            'new_item_name' => __('New Listing Type Name', 'listings'),
            'menu_name' => __('Listing Types', 'listings'),
        );

        $listing_type_args = array(
            'hierarchical' => false,
            'labels' => $listing_type_labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'listing-type'),
            'show_in_rest' => true, // Enable Gutenberg editor support
        );

        register_taxonomy('listing_type', array('listing'), $listing_type_args);

        // Add default terms for property types
        $this->add_default_property_types();

        // Add default terms for listing types
        $this->add_default_listing_types();
    }

    /**
     * Add default property types
     */
    private function add_default_property_types()
    {
        $default_property_types = array(
            'house' => 'House',
            'apartment' => 'Apartment',
            'villa' => 'Villa',
            'condo' => 'Condo',
            'townhouse' => 'Townhouse',
            'land' => 'Land',
            'commercial' => 'Commercial'
        );

        foreach ($default_property_types as $slug => $name) {
            if (!term_exists($slug, 'property_type')) {
                wp_insert_term($name, 'property_type', array('slug' => $slug));
            }
        }
    }

    /**
     * Add default listing types
     */
    private function add_default_listing_types()
    {
        $default_listing_types = array(
            'sale' => 'Sale',
            'rent' => 'Rent',
            'lease' => 'Lease'
        );

        foreach ($default_listing_types as $slug => $name) {
            if (!term_exists($slug, 'listing_type')) {
                wp_insert_term($name, 'listing_type', array('slug' => $slug));
            }
        }
    }
}