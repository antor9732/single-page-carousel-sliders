<?php
	/**
	 * Displayed when no products are found matching the current query
	 *
	 * This template can be overridden by copying it to yourtheme/woocommerce/loop/no-products-found.php.
	 *
	 * @see https://docs.woocommerce.com/document/template-structure/
	 * @package WooCommerce\Templates
	 * @version 7.8.0
	 */
	
	defined('ABSPATH') || exit;
?>
<div class="products-category rbb-product-content rbb_woo_products products flex flex-wrap -mx-6 px-[9px] overflow-hidden <?php echo 'grid_' . esc_attr(wc_get_default_products_per_row()); ?> ">
	<div class="no-products-found text-center py-16 w-full">
		<div class="no-products-found__icon mb-8">
			<img src="<?php echo esc_url(RBB_THEME_DIST_URI . 'images/cart/icon-cart.png'); ?>" alt="no-products" class="w-[113px] inline-block">
		</div>
		<h2 class="text-2xl font-bold mb-4"><?php esc_html_e('No products found', 'gearnix'); ?></h2>
		<p class="text-base mb-8"><?php esc_html_e('Sorry, no products matched your selection. Please try again with different criteria.', 'gearnix'); ?></p>
		<a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="inline-block h-[46px] leading-[46px] px-8 rounded-[46px] bg-[color:var(--rbb-general-primary-color)] !text-[color:var(--rbb-general-button-hover-color)] font-bold text-sm uppercase transition-all duration-300 hover:text-white hover:bg-[color:var(--rbb-general-secondary-color)]">
			<?php esc_html_e('Continue Shopping', 'gearnix'); ?>
		</a>
	</div>
</div>
