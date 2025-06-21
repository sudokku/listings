<?php

/**
 * The main plugin class.
 */
class Listings
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @var Listings_Loader
     */
    protected $loader;

    /**
     * Initialize the class and set its properties.
     */
    public function __construct()
    {
        $this->load_dependencies();
        $this->define_admin_hooks();
        $this->define_public_hooks();
        $this->define_post_type_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     */
    private function load_dependencies()
    {
        // The class responsible for orchestrating the actions and filters of the core plugin.
        require_once LISTINGS_PLUGIN_DIR . 'includes/class-listings-loader.php';

        // The class responsible for defining all actions that occur in the admin area.
        require_once LISTINGS_PLUGIN_DIR . 'admin/class-listings-admin.php';

        // The class responsible for defining all actions that occur in the public-facing side.
        require_once LISTINGS_PLUGIN_DIR . 'public/class-listings-public.php';

        // The class responsible for handling meta boxes
        require_once LISTINGS_PLUGIN_DIR . 'includes/class-listings-meta.php';

        // The class responsible for handling taxonomies
        require_once LISTINGS_PLUGIN_DIR . 'includes/class-listings-taxonomies.php';

        // The class responsible for handling Gutenberg blocks
        require_once LISTINGS_PLUGIN_DIR . 'includes/class-listings-blocks.php';

        // The class responsible for helper functions
        require_once LISTINGS_PLUGIN_DIR . 'includes/class-listings-helpers.php';

        // The class responsible for template loading
        require_once LISTINGS_PLUGIN_DIR . 'includes/class-listings-template-loader.php';

        $this->loader = new Listings_Loader();
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     */
    private function define_admin_hooks()
    {
        $plugin_admin = new Listings_Admin();

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     */
    private function define_public_hooks()
    {
        $plugin_public = new Listings_Public();

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
    }

    /**
     * Register all of the hooks related to the custom post type
     */
    private function define_post_type_hooks()
    {
        $this->loader->add_action('init', $this, 'register_listing_post_type');
        $this->loader->add_filter('template_include', $this, 'template_loader');

        // Initialize meta boxes
        new Listings_Meta();

        // Initialize taxonomies
        new Listings_Taxonomies();

        // Initialize blocks
        new Listings_Blocks();
    }

    /**
     * Register the Listing custom post type
     */
    public function register_listing_post_type()
    {
        $labels = array(
            'name' => _x('Listings', 'post type general name', 'listings'),
            'singular_name' => _x('Listing', 'post type singular name', 'listings'),
            'menu_name' => _x('Listings', 'admin menu', 'listings'),
            'add_new' => _x('Add New', 'listing', 'listings'),
            'add_new_item' => __('Add New Listing', 'listings'),
            'edit_item' => __('Edit Listing', 'listings'),
            'new_item' => __('New Listing', 'listings'),
            'view_item' => __('View Listing', 'listings'),
            'search_items' => __('Search Listings', 'listings'),
            'not_found' => __('No listings found', 'listings'),
            'not_found_in_trash' => __('No listings found in Trash', 'listings'),
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'listing'),
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-building',
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
            'taxonomies' => array('property_type', 'listing_type', 'post_tag'),
            'show_in_rest' => true, // Enable Gutenberg editor
        );

        register_post_type('listing', $args);
    }

    /**
     * Load a template
     *
     * @param string $template
     * @return string
     */
    public function template_loader($template)
    {
        if (is_post_type_archive('listing') || is_tax('property_type') || is_tax('listing_type')) {
            $default_file = 'archive-listing.php';
            $search_files = array('archive-listing.php');
            $template = Listings_Template_Loader::locate_template($default_file, '', '', $search_files);
        } elseif (is_singular('listing')) {
            $default_file = 'single-listing.php';
            $search_files = array('single-listing.php');
            $template = Listings_Template_Loader::locate_template($default_file, '', '', $search_files);
        }

        return $template;
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     */
    public function run()
    {
        $this->loader->run();
    }
}