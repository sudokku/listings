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
        // Add hook for block editor assets
        //add_action('enqueue_block_editor_assets', array($this, 'enqueue_block_editor_assets'));
    }

    /**
     * Register the stylesheets for the admin area.
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
            'listings-admin',
            LISTINGS_PLUGIN_URL . 'admin/css/listings-admin.css',
            array('font-awesome'),
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

    /**
     * Register assets for the block editor.
     */
    public function enqueue_block_editor_assets()
    {
        // Enqueue Font Awesome specifically for the block editor
        wp_enqueue_style(
            'font-awesome',
            'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
            array(),
            '6.5.1',
            'all'
        );
    }
}