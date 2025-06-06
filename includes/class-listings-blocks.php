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
        // Get all block.json files from the build directory
        $block_dirs = glob(LISTINGS_PLUGIN_DIR . 'build/*/block.json');

        foreach ($block_dirs as $block_file) {
            // Register each block
            register_block_type(dirname($block_file));
        }
    }
}