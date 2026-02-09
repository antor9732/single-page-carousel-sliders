<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     9.7.0
 */

use RisingBambooTheme\App\App;
use RisingBambooTheme\Helper\Setting as RisingBambooThemeSetting;

if ( ! defined('ABSPATH') ) {
	exit;
}

global $product;
$show_sku      = (bool) RisingBambooThemeSetting::get(RISING_BAMBOO_KIRKI_FIELD_WOOCOMMERCE_PRODUCT_DETAIL_SUMMARY_SHOW_SKU);
$show_category = (bool) RisingBambooThemeSetting::get(RISING_BAMBOO_KIRKI_FIELD_WOOCOMMERCE_PRODUCT_DETAIL_SUMMARY_SHOW_CATEGORY);
$show_tag      = (bool) RisingBambooThemeSetting::get(RISING_BAMBOO_KIRKI_FIELD_WOOCOMMERCE_PRODUCT_DETAIL_SUMMARY_SHOW_TAG);
?>
<div class="product_meta pt-9 mt-9">

	<?php do_action('woocommerce_product_meta_start'); ?>

	<?php if ( $show_sku && wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type('variable') ) ) : ?>

		<span class="sku_wrapper flex mb-1.5"><span class="block font-semibold pr-[3px] whitespace-nowrap"><?php esc_html_e('SKU : ', 'gearnix'); ?></span> <span class="sku"><?php echo esc_html(( $product->get_sku() ) ?: __('N/A', 'gearnix')); ?></span></span>

	<?php endif; ?>

	<?php
	if ( $show_category ) {
        // phpcs:ignore
		echo wc_get_product_category_list($product->get_id(), ', ', '<span class="posted_in flex mb-1.5">' . _n('<span class="block font-semibold pr-[3px] whitespace-nowrap">' . __('Category', 'gearnix') . ' : </span><span>', '<span class="block font-semibold pr-[3px] whitespace-nowrap">' . __('Categories:', 'gearnix') . ' : </span><span>', count($product->get_category_ids())) . ' ', '</span></span>');
	}
	?>

	<?php
	if ( $show_tag ) {
		// phpcs:ignore
		echo wc_get_product_tag_list($product->get_id(), ', ', '<span class="tagged_as flex mb-1.5">' . _n('<span class="block font-semibold pr-[3px] whitespace-nowrap">' . __('Tag', 'gearnix') . ' :</span><span>', '<span class="block font-semibold pr-[3px] whitespace-nowrap">Tags :</span><span>', count($product->get_tag_ids())) . ' ', '</span></span>');
	}
	?>
	<?php do_action('woocommerce_product_meta_end'); ?>
</div>
