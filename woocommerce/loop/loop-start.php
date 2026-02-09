<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.3.0
 */

use RisingBambooTheme\Helper\Setting;
if ( ! defined('ABSPATH') ) {
	exit;
}
$show_stock        = Setting::get(RISING_BAMBOO_KIRKI_SECTION_WOOCOMMERCE_PRODUCT_CATALOG_PRODUCT_ITEM_SHOW_STOCK);
$show_custom_field = Setting::get(RISING_BAMBOO_KIRKI_SECTION_WOOCOMMERCE_PRODUCT_CATALOG_PRODUCT_ITEM_SHOW_CUSTOM_FIELDS);
?>
<div class="products-category rbb_woo_products products flex flex-wrap -mx-6 px-[9px] pb-[30px] overflow-hidden <?php echo 'grid_' . esc_attr(wc_get_default_products_per_row()); ?> <?php echo esc_attr(( $show_stock || $show_custom_field ) ? 'rbb-product-content rbb-custom_field' : ''); ?>">
