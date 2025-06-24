<?php
/**
 * Helper functions for the Listings plugin
 */
class Listings_Helpers
{
    /**
     * Generate breadcrumbs HTML
     *
     * @param array $args Optional. Array of arguments.
     * @return string Breadcrumbs HTML
     */
    public static function get_breadcrumbs($args = array())
    {
        $defaults = array(
            'separator' => '&raquo;',
            'home_text' => __('Home', 'listings'),
            'home_link' => home_url('/'),
            'container_class' => 'breadcrumbs',
            'item_class' => 'breadcrumb-item',
            'current_class' => 'breadcrumb-current'
        );

        $args = wp_parse_args($args, $defaults);
        $breadcrumbs = array();

        // Add home link
        $breadcrumbs[] = sprintf(
            '<a href="%s" class="%s">%s</a>',
            esc_url($args['home_link']),
            esc_attr($args['item_class']),
            esc_html($args['home_text'])
        );

        if (is_post_type_archive('listing')) {
            // Add current page (no link)
            $breadcrumbs[] = sprintf(
                '<span class="%s">%s</span>',
                esc_attr($args['current_class']),
                __('Listings', 'listings')
            );
        } elseif (is_singular('listing')) {
            // Add archive link
            $breadcrumbs[] = sprintf(
                '<a href="%s" class="%s">%s</a>',
                esc_url(get_post_type_archive_link('listing')),
                esc_attr($args['item_class']),
                __('Listings', 'listings')
            );

            // Add current page (no link)
            $breadcrumbs[] = sprintf(
                '<span class="%s">%s</span>',
                esc_attr($args['current_class']),
                get_the_title()
            );
        } elseif (is_tax('property_type') || is_tax('listing_type')) {
            $taxonomy = get_queried_object();

            // Add archive link
            $breadcrumbs[] = sprintf(
                '<a href="%s" class="%s">%s</a>',
                esc_url(get_post_type_archive_link('listing')),
                esc_attr($args['item_class']),
                __('Listings', 'listings')
            );

            // Add current page (no link)
            $breadcrumbs[] = sprintf(
                '<span class="%s">%s</span>',
                esc_attr($args['current_class']),
                $taxonomy->name
            );
        } elseif (is_search() && get_query_var('post_type') === 'listing') {
            // Add archive link
            $breadcrumbs[] = sprintf(
                '<a href="%s" class="%s">%s</a>',
                esc_url(get_post_type_archive_link('listing')),
                esc_attr($args['item_class']),
                __('Listings', 'listings')
            );

            // Add search results (no link)
            $breadcrumbs[] = sprintf(
                '<span class="%s">%s</span>',
                esc_attr($args['current_class']),
                sprintf(__('Search Results for "%s"', 'listings'), get_search_query())
            );
        }

        // Build the breadcrumbs HTML
        $html = sprintf('<div class="%s">', esc_attr($args['container_class']));
        $html .= implode(
            sprintf(' <span class="breadcrumb-separator">%s</span> ', $args['separator']),
            $breadcrumbs
        );
        $html .= '</div>';

        return $html;
    }

    /**
     * Get the search form template part
     *
     * @param array $args Optional. Array of arguments.
     * @return string Search form HTML
     */
    public static function get_search_form($args = array())
    {
        $defaults = array(
            'show_title' => true,
            'title' => __('Search Listings', 'listings'),
            'container_class' => 'listings-search-form-wrapper'
        );

        $args = wp_parse_args($args, $defaults);

        ob_start();

        if ($args['show_title']) {
            echo '<h2 class="search-form-title">' . esc_html($args['title']) . '</h2>';
        }

        Listings_Template_Loader::get_template('partials/search-form.php', $args);

        $html = ob_get_clean();

        return sprintf(
            '<div class="%s">%s</div>',
            esc_attr($args['container_class']),
            $html
        );
    }

    /**
     * Build search query for listings
     *
     * @param array $search_args Search arguments
     * @return array WP_Query arguments
     */
    public static function build_search_query($search_args = array())
    {
        $defaults = array(
            's' => '',
            'location' => '',
            'listing_type' => '',
            'price_min' => '',
            'price_max' => '',
            'posts_per_page' => get_option('posts_per_page', 10),
            'paged' => get_query_var('paged') ? get_query_var('paged') : 1
        );

        $args = wp_parse_args($search_args, $defaults);
        $query_args = array(
            'post_type' => 'listing',
            'post_status' => 'publish',
            'posts_per_page' => $args['posts_per_page'],
            'paged' => $args['paged'],
            'meta_query' => array(),
            'tax_query' => array()
        );

        // Basic search
        if (!empty($args['s'])) {
            $query_args['s'] = $args['s'];
        }

        // Location search
        if (!empty($args['location'])) {
            $query_args['meta_query'][] = array(
                'relation' => 'OR',
                array(
                    'key' => '_listing_address',
                    'value' => $args['location'],
                    'compare' => 'LIKE'
                ),
                array(
                    'key' => '_listing_city',
                    'value' => $args['location'],
                    'compare' => 'LIKE'
                ),
                array(
                    'key' => '_listing_state',
                    'value' => $args['location'],
                    'compare' => 'LIKE'
                )
            );
        }

        // Listing type filter
        if (!empty($args['listing_type'])) {
            $query_args['tax_query'][] = array(
                'taxonomy' => 'listing_type',
                'field' => 'slug',
                'terms' => $args['listing_type']
            );
        }

        // Price range filter
        if (!empty($args['price_min']) || !empty($args['price_max'])) {
            $price_query = array('key' => '_listing_price');

            if (!empty($args['price_min'])) {
                $price_query['value'] = $args['price_min'];
                $price_query['compare'] = '>=';
                $price_query['type'] = 'NUMERIC';
            }

            if (!empty($args['price_max'])) {
                $price_query['value'] = array($args['price_min'], $args['price_max']);
                $price_query['compare'] = 'BETWEEN';
                $price_query['type'] = 'NUMERIC';
            }

            $query_args['meta_query'][] = $price_query;
        }

        return $query_args;
    }
}