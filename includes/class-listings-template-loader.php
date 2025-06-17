<?php
/**
 * Template loader for the Listings plugin
 */
class Listings_Template_Loader
{
    /**
     * Get the template path
     *
     * @return string
     */
    public static function get_template_path()
    {
        return apply_filters('listings_template_path', 'listings/');
    }

    /**
     * Get the template part
     *
     * @param string $template_name Template name
     * @param array $args Arguments passed to the template
     * @param string $template_path Template path
     * @param string $default_path Default path
     */
    public static function get_template($template_name, $args = array(), $template_path = '', $default_path = '')
    {
        if ($args && is_array($args)) {
            extract($args);
        }

        $located = self::locate_template($template_name, $template_path, $default_path);

        if (!file_exists($located)) {
            return;
        }

        include $located;
    }

    /**
     * Locate a template and return the path for inclusion
     *
     * @param string $template_name Template name
     * @param string $template_path Template path
     * @param string $default_path Default path
     * @return string
     */
    public static function locate_template($template_name, $template_path = '', $default_path = '')
    {
        if (!$template_path) {
            $template_path = self::get_template_path();
        }

        if (!$default_path) {
            $default_path = LISTINGS_PLUGIN_DIR . 'templates/';
        }

        // Look within passed path within the theme - this is priority
        $template = locate_template(
            array(
                trailingslashit($template_path) . $template_name,
                $template_name,
            )
        );

        // Get default template
        if (!$template) {
            $template = $default_path . $template_name;
        }

        // Return what we found
        return apply_filters('listings_locate_template', $template, $template_name, $template_path);
    }
}