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
}