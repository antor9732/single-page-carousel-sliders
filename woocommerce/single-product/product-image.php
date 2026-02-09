<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.7.0
 */

use RisingBambooCore\Helper\WoocommerceImage;
use RisingBambooTheme\App\App;
use RisingBambooTheme\Helper\Setting;

defined('ABSPATH') || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists('wc_get_gallery_image_html') ) {
	return;
}

global $product;
$attachment_ids = WoocommerceImage::get_images_id($product);

if ( empty($attachment_ids) ) {
	echo apply_filters('woocommerce_single_product_image_html', sprintf('<img src="%s" alt="%s" />', wc_placeholder_img_src(), esc_attr__('Placeholder', 'gearnix')), $product->get_id());
	return;
}

$wrapper_classes = apply_filters(
	'rbb_theme_single_product_image_gallery_classes',
	[
		'product-single__photos',
	]
);

$image_layout      = Setting::get(RISING_BAMBOO_KIRKI_FIELD_WOOCOMMERCE_PRODUCT_DETAIL_IMAGE_LAYOUT);
$image_layout_path = realpath(get_template_directory() . '/woocommerce/single-product/image-layout/' . $image_layout . '.php');
if ( $image_layout_path ) {
	get_template_part('woocommerce/single-product/image-layout/' . $image_layout, null, compact('wrapper_classes', 'attachment_ids'));
}
