<?php
/**
 * RisingBambooCore.
 *
 * @package RisingBambooCore
 */

global $product;

use RisingBambooCore\Woocommerce\Swatches;
use RisingBambooTheme\App\App;

$variations_json = wp_json_encode($available_variations);
$variations_attr = function_exists('wc_esc_json') ? wc_esc_json($variations_json) : _wp_specialchars($variations_json, ENT_QUOTES, 'UTF-8', true);

do_action('woocommerce_before_add_to_cart_form');
?>
<form class="rbb-swatches rbb-swatches__single variations_form cart" method="post" enctype="multipart/form-data" data-product_id="<?php echo esc_attr(absint(get_the_ID())); ?>" data-product_variations="<?php echo esc_attr($variations_attr); ?>"
>
	<?php do_action('woocommerce_before_variations_form'); ?>

	<?php if ( empty($available_variations) && false !== $available_variations ) { ?>
		<p class="stock out-of-stock"><?php esc_html__('This product is currently out of stock and unavailable.', 'gearnix'); ?></p>
	<?php } else { ?>
		<div class="variations flex flex-wrap justify-flex-start">
			<?php
			foreach ( $attributes as $attribute_name => $product_attribute ) {
				$attr_data = $product_attribute->get_data();
				if ( false === $attr_data['variation'] ) {
					continue;
				}
				$attr_info    = wc_get_attribute($attr_data['id']);
				$data         = [];
				$data['type'] = $attr_info->type ?? 'select';
				$data['slug'] = $attr_info->slug ?? '';
				$data['name'] = $attr_info->name ?? '';
				if ( taxonomy_exists($attr_data['name']) ) {
					$data['terms'] = wp_get_post_terms($product->get_id(), $attr_data['name'], [ 'hide_empty' => false ]);
				}
				?>
				<div class="grow-0 shrink-0 mt-2 mb-2 rbb-swatch__wrap rbb-swatch__wrap-<?php echo esc_attr($data['type']); ?>">
					<div class="label mb-4">
						<label for="<?php echo esc_attr($data['slug']); ?>">
							<span class="label-title"><?php echo esc_html($data['name'] ?: wc_attribute_label($attribute_name)); ?><span class="pl-[3px]">:</span></span>
							<span class="label-val"></span>
						</label>
					</div>
					<div class="value">
						<?php if ( ( '' !== $data['type'] ) && ( 'select' !== $data['type'] ) ) { ?>
							<div class="rbb-swatch rbb-swatch__<?php echo esc_attr($data['type']); ?>" data-attribute="<?php echo esc_attr($attribute_name); ?>">
								<?php
								switch ( $data['type'] ) {
									case 'text':
										foreach ( $data['terms'] as $_term ) {
											?>
											<a class="inline-block px-2 py-1 rounded-[3px] cursor-pointer rbb-swatch__term bg-white h-[45px] min-w-[45px] leading-10 border border-[#ececec] text-center <?php echo apply_filters('rbb_swatch_term_class', '', $_term); ?>" aria-label="<?php echo esc_attr($_term->name); ?>" title="<?php echo esc_attr($_term->name); ?>" data-term="<?php echo esc_attr($_term->slug); ?>">
												<?php echo esc_attr($_term->name); ?>
											</a>
											<?php
										}
										break;
									case 'color':
										foreach ( $data['terms'] as $_term ) {
											$val = get_term_meta($_term->term_id, Swatches::get_field('color'), true) ?: '#fff';
											?>
											<a class="inline-block rounded-full p-1 cursor-pointer rbb-swatch__term <?php echo apply_filters('rbb_swatch_term_class', '', $_term); ?>" aria-label="<?php echo esc_attr($_term->name); ?>" title="<?php echo esc_attr($_term->name); ?>" data-term="<?php echo esc_attr($_term->slug); ?>">
												<span class="block w-[26px] h-[26px] rounded-full" style="background-color: <?php echo esc_attr($val); ?>; border:1px solid <?php echo esc_attr($val); ?>"></span>
											</a>
											<?php
										}
										break;
									case 'image':
										foreach ( $data['terms'] as $_term ) {
											$val = get_term_meta($_term->term_id, Swatches::get_field('image'), true) ? wp_get_attachment_thumb_url(get_term_meta($_term->term_id, Swatches::get_field('image'), true)) : wc_placeholder_img_src();
											?>
											<a class="inline-block p-1 cursor-pointer rbb-swatch__term <?php echo apply_filters('rbb_swatch_term_class', '', $_term); ?>" aria-label="<?php echo esc_attr($_term->name); ?>" title="<?php echo esc_attr($_term->name); ?>" data-term="<?php echo esc_attr($_term->slug); ?>">
												<img class="w-[40px] h-[40px]" src="<?php echo esc_url($val); ?>" alt="<?php echo esc_attr($_term->name); ?>"/>
											</a>
											<?php
										}
										break;
									default:
										break;
								}
								?>
							</div>
							<?php
						}
						$attribute_request = 'attribute_' . sanitize_title($attribute_name);
						//phpcs:ignore
						if (isset($_REQUEST[$attribute_request])) {
							//phpcs:ignore
							$selected = $_REQUEST[$attribute_request];
						} elseif ( isset($selected_attributes[ sanitize_title($attribute_name) ]) ) {
							$selected = $selected_attributes[ sanitize_title($attribute_name) ];
						} else {
							$selected = '';
						}
						if ( ! $attr_info ) {
							$attr_data      = $product_attribute->get_data();
							$attribute_name = $attr_data['name'];
						}
						$args = [
							'options'   => $variation_attributes[ $attribute_name ],
							'attribute' => $attribute_name,
							'product'   => $product,
							'selected'  => $selected,
							'class'     => 'rbb-swatch__dropdown-' . $data['type'] . ( in_array($data['type'], [ 'text', 'color', 'image' ], true) ? ' hidden' : '' ),
						];
						wc_dropdown_variation_attribute_options($args);
						?>
					</div>
				</div>
			<?php } ?>
			<div class="clear-variations w-full order-[1]">
				<div class="value uppercase text-xs pt-2 font-medium relative">
					<a class="reset_variations reset_variations--single pl-5" href="#"><?php esc_html_e('Clear', 'gearnix'); ?></a>
				</div>
			</div>
		</div>
		<div class="single_variation_wrap">
			<?php
			/**
			 * Hook woocommerce_before_single_variation
			 */
			do_action('woocommerce_before_single_variation');

			/**
			 * Hook woocommerce_single_variation
			 * Used to output the cart button and placeholder for variation data.
			 *
			 * @since  2.4.0
			 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
			 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
			 */
			do_action('woocommerce_single_variation');

			/**
			 * Hook woocommerce_after_single_variation
			 */
			do_action('woocommerce_after_single_variation');
			?>
		</div>
	<?php } ?>
	<?php do_action('woocommerce_after_variations_form'); ?>
</form>
<?php do_action('woocommerce_after_add_to_cart_form'); ?>
