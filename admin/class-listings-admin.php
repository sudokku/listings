<?php

/**
 * The admin-specific functionality of the plugin.
 */
class Listings_Admin
{

    /**
     * Initialize the class and set its properties.
     */
    public function __construct()
    {
    }

    /**
     * Register the stylesheets for the admin area.
     */
    public function enqueue_styles()
    {
        wp_enqueue_style(
            'listings-admin',
            LISTINGS_PLUGIN_URL . 'admin/css/listings-admin.css',
            array(),
            LISTINGS_VERSION,
            'all'
        );
    }

    /**
     * Register the JavaScript for the admin area.
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script(
            'listings-admin',
            LISTINGS_PLUGIN_URL . 'admin/js/listings-admin.js',
            array('jquery'),
            LISTINGS_VERSION,
            false
        );
    }
}