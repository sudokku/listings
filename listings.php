<?php
/**
 * Plugin Name: Listings
 * Plugin URI: https://yourwebsite.com/listings
 * Description: A custom WordPress plugin for managing listings
 * Version: 1.0.0
 * Author: Radu Chirilov
 * Author URI: https://yourwebsite.com
 * Text Domain: listings
 * Domain Path: /languages
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// Define plugin constants
define('LISTINGS_VERSION', '1.0.0');
define('LISTINGS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('LISTINGS_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include required files
require_once LISTINGS_PLUGIN_DIR . 'includes/class-listings.php';

// Initialize the plugin
function run_listings()
{
    $plugin = new Listings();
    $plugin->run();
}
run_listings();