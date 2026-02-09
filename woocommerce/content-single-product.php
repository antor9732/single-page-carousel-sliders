<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action('woocommerce_before_single_product');

if ( post_password_required() ) {
	echo get_the_password_form(); // phpcs:ignore
	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class('container mx-auto pb-[80px] lg:pb-[120px]', $product); ?>>

	<div class="grid gap-0 grid-cols-12">
		<?php
		$image_wrapper_classes = apply_filters(
			'rbb_theme_single_product_image_wrapper_classes',
			[
				'product-image',
				'relative',
				'col-span-12',
			]
		);
		?>
		<div class="<?php echo esc_attr(implode(' ', $image_wrapper_classes)); ?>">
			<?php
			/**
			 * Hook: woocommerce_before_single_product_summary.
			 *
			 * @hooked woocommerce_show_product_sale_flash - 10
			 * @hooked woocommerce_show_product_images - 20
			 */
			do_action('woocommerce_before_single_product_summary');
			?>
		</div>
		<?php
		$summary_wrapper_classes = apply_filters(
			'rbb_theme_single_product_summary_wrapper_classes',
			[
				'product-summary',
				'summary',
				'entry-summary',
				'col-span-12 relative mt-7 md:mt-0',
			]
		);
		?>
		
		<div class="<?php echo esc_attr(implode(' ', $summary_wrapper_classes)); ?>">
			<div class="single-sticky sticky top-24">
				<?php
				/**
				 * Hook: woocommerce_single_product_summary.
				 *
				 * @hooked woocommerce_template_single_title - 5
				 * @hooked woocommerce_template_single_rating - 10
				 * @hooked woocommerce_template_single_price - 10
				 * @hooked woocommerce_template_single_excerpt - 20
				 * @hooked woocommerce_template_single_add_to_cart - 30
				 * @hooked woocommerce_template_single_meta - 40
				 * @hooked woocommerce_template_single_sharing - 50
				 * @hooked WC_Structured_Data::generate_product_data() - 60
				 */
				remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
				add_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 80);
				do_action('woocommerce_single_product_summary');
				?>
			</div>
		</div>
	</div>

	<?php
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	do_action('woocommerce_after_single_product_summary');
	?>
</div>
<div id="after-product-<?php the_ID(); ?>" class="after-product overflow-hidden">
	<div class="container mx-auto">
		<?php do_action('woocommerce_after_single_product'); ?>
	</div>
</div>
