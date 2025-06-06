<?php
/**
 * Handles the registration and rendering of Gutenberg blocks.
 *
 * @package Listings
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class Listings_Blocks
{
    /**
     * Initialize the class.
     */
    public function __construct()
    {
        add_action('init', array($this, 'register_blocks'));
    }

    /**
     * Register blocks.
     */
    public function register_blocks()
    {
        // Register the block
        register_block_type(
            LISTINGS_PLUGIN_DIR . 'blocks/listing-info'
        );
    }
}