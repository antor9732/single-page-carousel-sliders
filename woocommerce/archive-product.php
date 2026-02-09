<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

use RisingBambooTheme\App\App;
defined('ABSPATH') || exit;

get_header('shop');

$loop_display_mode = woocommerce_get_loop_display_mode();
$shop_display      = get_option('woocommerce_shop_page_display', '');
$cate_display      = get_option('woocommerce_shop_page_display', '');
/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action('woocommerce_before_main_content');

$wrapper_classes = apply_filters(
	'rbb_theme_archive_product_classes',
	[
		'rbb-product-catalog md:py-[100px] pt-[80px] pb-[50px]',
	]
);

?>
	<div class="<?php echo esc_attr(implode(' ', $wrapper_classes)); ?>">
		<?php if ( is_search() ) { ?>
			<header class="woocommerce-products-header">
				<?php if ( apply_filters('woocommerce_show_page_title', true) ) { ?>
					<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
				<?php } ?>
			</header>
		<?php } ?>
		<?php
		// Check if we have products before entering the loop.
			$has_products = wc_get_loop_prop('total') > 0;
		if ( $has_products && woocommerce_product_loop() ) {

			/**
			 * Hook: woocommerce_before_shop_loop.
			 *
			 * @hooked woocommerce_output_all_notices - 10
			 * @hooked woocommerce_result_count - 20
			 * @hooked woocommerce_catalog_ordering - 30
			 */
			?>
			<?php if ( 'subcategories' !== $shop_display || 'subcategories' !== $cate_display ) { ?>
				<div class="flex items-center category-top-bar"><?php do_action('woocommerce_before_shop_loop'); ?></div>
			<?php } ?>
			<?php
			woocommerce_product_loop_start();

			if ( wc_get_loop_prop('total') ) {
				while ( have_posts() ) {
					the_post();

					/**
					 * Hook: woocommerce_shop_loop.
					 */
					do_action('woocommerce_shop_loop');

					wc_get_template_part('content', 'product');
				}
			}

			woocommerce_product_loop_end();

			/**
			 * Hook: woocommerce_after_shop_loop.
			 *
			 * @hooked woocommerce_pagination - 10
			 */
			do_action('woocommerce_after_shop_loop');
		} else {
			/**
			 * Hook: woocommerce_no_products_found.
			 *
			 * @hooked wc_no_products_found - 10
			 */
			do_action('woocommerce_no_products_found');
		}
		?>
	</div>

<?php

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action('woocommerce_after_main_content');

if ( is_active_sidebar('product-category-bottom') ) {
	dynamic_sidebar('product-category-bottom');
}

if ( is_product_category() ) {
	$term_id    = get_queried_object_id();
	$term_title = single_term_title('', false);
	$term_desc  = term_description($term_id, 'product_cat');
	$term_desc  = wpautop($term_desc);
	$term_desc  = wp_strip_all_tags($term_desc);
	$words      = explode(' ', $term_desc);
	$short_desc = implode(' ', array_slice($words, 0, 110));
	if ( ! empty($term_desc) ) {
		?>
	<div class="category-product-bottom bg-[#f2f2f2] overflow-hidden pb-10 -mt-10">
		<div class="container mx-auto">
			<h2 class="title text-2xl mb-6"><?php echo esc_html($term_title); ?></h2>
			<div class="rbb-accordion mb-5">
				<div class='product-desc relative max-h-32 overflow-hidden mb-1'>
					<p><?php echo wp_kses_post($short_desc); ?></p>
				</div>
				<div class='rbb-accordion-content hidden'>
					<p><?php echo wp_kses_post(implode(' ', array_slice($words, 110))); ?></p>
				</div>
				<div class='rbb-accordion-title !border-none text-center font-semibold uppercase mt-8 !text-[0.625rem] text-[color:var(--rbb-general-heading-color)]'>
					<span class='see_more cursor-pointer hover:text-[color:var(--rbb-general-primary-color)]'>
						<?php echo esc_html__('See More +', 'gearnix'); ?>
					</span>
					<span class='see_less cursor-pointer hidden hover:text-[color:var(--rbb-general-primary-color)]'>
						<?php echo esc_html__('See Less -', 'gearnix'); ?>
					</span>
				</div>
			</div>
		</div>
	</div>
		<?php
	}
}
/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 *
 *do_action( 'woocommerce_sidebar' ); */
get_footer('shop');
