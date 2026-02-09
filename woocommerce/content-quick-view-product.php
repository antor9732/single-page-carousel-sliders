<?php
/**
 * Quick view product.
 *
 * @package RisingBambooTheme
 */

global $product;
use RisingBambooTheme\Helper\Setting;
$outside           = Setting::get(RISING_BAMBOO_KIRKI_FIELD_COMPONENT_MODAL_CLICK_OUTSIDE_CLOSE);
$modal_effect      = Setting::get(RISING_BAMBOO_KIRKI_FIELD_COMPONENT_MODAL_EFFECT);
$backdrop_filter   = Setting::get(RISING_BAMBOO_KIRKI_FIELD_COMPONENT_MODAL_BACKDROP_FILTER);
$show_excerpt      = Setting::get(RISING_BAMBOO_KIRKI_FIELD_WOOCOMMERCE_PRODUCT_DETAIL_SUMMARY_SHOW_EXCERPT);
$classes           = [ 'quick-view-product-wrap' ];
$classes[]         = ( true === $backdrop_filter ) ? 'backdrop' : 'backdrop-none';
$classes[]         = ( false === $outside ) ? 'outside-modal' : '';
$class_string      = implode(' ', array_filter($classes));
$short_description = apply_filters('woocommerce_short_description', $product->get_short_description());
if ( $show_excerpt && ! empty($short_description) ) {
	add_action(
		'woocommerce_single_product_summary',
		function() use ( $product ) {
			$short_description = apply_filters('woocommerce_short_description', $product->get_short_description());
			if ( ! empty($short_description) ) {
				echo '<div class="woocommerce-product-details__short-description mt-2 text-sm leading-relaxed">';
				echo wp_kses($short_description, 'rbb-kses');
				echo '</div>';
			}
		},
		15
	);
}
?>

<div class="<?php echo esc_attr($class_string); ?>" id="quick-view-product-wrap-<?php echo esc_attr($product->get_id()); ?>" data-modal-animation="<?php echo esc_attr($modal_effect); ?>">
	<div class="woocommerce bg-white py-5 pl-5 pr-[5px]">
		<?php
		/**
		 * Hook woocommerce_before_single_product.
		 *
		 * @hooked woocommerce_show_messages - 10
		 */
		do_action('woocommerce_before_single_product');
		?>
		<div id="product-<?php echo esc_attr($product->get_id()); ?>" <?php post_class('product single-product'); ?>>
			<div class="product-detail grid grid-cols-2 gap-4">
				<div class="product-detail-image">
					<?php
					/**
					 * Hook woocommerce_show_product_images
					 *
					 * @hooked woocommerce_show_product_sale_flash - 10
					 * @hooked woocommerce_show_product_images - 20
					 */
					wc_get_template('single-product/product-image-quick-view.php');
					?>
				</div>
				<div class="product-detail-info flex relative overflow-hidden flex-col">
					<div class="content_product_detail text-left entry-summary w-full h-full absolute overflow-y-auto px-5 lg:pr-[30px] left-0">
						<?php
						/**
						 * Hook woocommerce_single_product_summary
						 *
						 * @hooked woocommerce_template_single_title - 5
						 * @hooked woocommerce_template_single_price - 10
						 * @hooked woocommerce_template_single_excerpt - 20
						 * @hooked woocommerce_template_single_add_to_cart - 30
						 * @hooked woocommerce_template_single_meta - 40
						 * @hooked woocommerce_template_single_sharing - 50
						 */
						remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
						add_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 20);
						remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);
						do_action('woocommerce_single_product_summary');
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
