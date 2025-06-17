<?php

/**
 * The public-facing functionality of the plugin.
 */
class Listings_Public
{

    /**
     * Initialize the class and set its properties.
     */
    public function __construct()
    {
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     */
    public function enqueue_styles()
    {
        // Enqueue Font Awesome
        wp_enqueue_style(
            'font-awesome',
            'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
            array(),
            '6.5.1',
            'all'
        );

        wp_enqueue_style(
            'listings-public',
            LISTINGS_PLUGIN_URL . 'public/css/listings-public.css',
            array('font-awesome'),
            LISTINGS_VERSION,
            'all'
        );

        // Enqueue archive styles if on archive page
        if (is_post_type_archive('listing') || is_tax('property_type') || is_tax('listing_type')) {
            wp_enqueue_style(
                'listings-archive',
                LISTINGS_PLUGIN_URL . 'public/css/listings-archive.css',
                array('listings-public'),
                LISTINGS_VERSION,
                'all'
            );
        }
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script(
            'listings-public',
            LISTINGS_PLUGIN_URL . 'public/js/listings-public.js',
            array('jquery'),
            LISTINGS_VERSION,
            false
        );
    }
}