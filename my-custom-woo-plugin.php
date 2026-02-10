<?php
/**
 * Plugin Name: My Custom Woo Templates
 * Description: Load all WooCommerce templates from plugin
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Add plugin templates to WooCommerce template path (priority 999 = after theme).
 */
add_filter( 'woocommerce_locate_template', 'my_plugin_woocommerce_templates', 999, 4 );

/**
 * Override WooCommerce templates with plugin copies when they exist.
 *
 * @param string $template      Full path to the template (theme or default WC).
 * @param string $template_name Relative path e.g. 'single-product/product-image.php'.
 * @param string $template_path Template path slug (e.g. 'woocommerce').
 * @param string $default_path  Default WooCommerce templates directory (WC 9.5+).
 * @return string Template path.
 */
function my_plugin_woocommerce_templates( $template, $template_name, $template_path, $default_path = '' ) {
    $plugin_path = plugin_dir_path( __FILE__ ) . 'woocommerce/';
    $plugin_file = wp_normalize_path( $plugin_path . $template_name );
    //print_r($plugin_file);
    if ( file_exists( $plugin_file ) ) {
        return $plugin_file;
    }

    return $template;
}


require_once plugin_dir_path( __FILE__ ) . 'woocommerce/single-product/carousel-slider/releted-productcarousel.php';
require_once plugin_dir_path( __FILE__ ) . 'woocommerce/single-product/carousel-slider/testimonial-productcarousel.php';
