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
        wp_enqueue_style(
            'listings-public',
            LISTINGS_PLUGIN_URL . 'public/css/listings-public.css',
            array(),
            LISTINGS_VERSION,
            'all'
        );
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