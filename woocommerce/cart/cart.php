<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.1.0
 */

use RisingBambooTheme\App\App;

defined('ABSPATH') || exit;

?>
<div class="cart-template">
	<?php do_action('woocommerce_before_cart'); ?>
	<div class="grid grid-cols-3 gap-[30px] relative z-10">
		<div class="lg:col-span-2 col-span-3">
			<form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
				<?php do_action('woocommerce_before_cart_table'); ?>

				<div class="rbb-cart__table rounded-2xl shop_table shop_table_responsive cart woocommerce-cart-form__contents mb-[30px]">
					<div class="rbb-cart__table-header hidden sm:flex font-bold uppercase sm:px-7 px-4">
						<div class="product-name rbb-cart__table-col py-5 rbb-cart__product"><?php esc_html_e('Product', 'gearnix'); ?></div>
						<div class="product-price rbb-cart__table-col px-4 xl-px-8 py-5 rbb-cart__price"><?php esc_html_e('Price', 'gearnix'); ?></div>
						<div class="product-quantity rbb-cart__table-col px-4 xl-px-8 py-5 rbb-cart__qty hidden sm:block"><?php esc_html_e('Quantity', 'gearnix'); ?></div>
						<div class="product-subtotal rbb-cart__table-col px-6 py-5 rbb-cart__subtotal mr-5 hidden sm:block"><?php esc_html_e('Subtotal', 'gearnix'); ?></div>
					</div>

					<div class="rbb-cart__table-content rounded-2xl bg-white px-7">
						<?php do_action('woocommerce_before_cart_contents'); ?>
						<?php
						foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
							$_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
							$product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

							if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key) ) {
								$product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
								?>
								<div class="rbb-cart__item sm:flex items-center woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">

									<div class="rbb-cart__remove sm:hidden text-right md:px-8 pt-10 pb-8 product-remove">
										<?php
										echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
											'woocommerce_cart_item_remove_link',
											sprintf(
												'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><i class="rbb-icon-delete-outline-2"></i></a>',
												esc_url(wc_get_cart_remove_url($cart_item_key)),
												esc_html__('Remove this item', 'gearnix'),
												esc_attr($product_id),
												esc_attr($_product->get_sku())
											),
											$cart_item_key
										);
										?>
									</div>

									<div class="rbb-cart__table-col  sm:pl-0 py-[30px] rbb-cart__product flex items-center justify-between sm:justify-start product-thumbnail" data-title="<?php esc_attr_e('Product', 'gearnix'); ?>">
										<div class="rbb-cart__product-image border md:ml-0 md:mr-0 sm:block">
											<?php
											$thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
											if ( ! $product_permalink ) {
												echo wp_kses($thumbnail, 'rbb-kses');
											} else {
												printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
											}
											?>
										</div>
										<div class="rbb-cart__product-name pl-5 product-name" data-title="<?php esc_attr_e('Product', 'gearnix'); ?>">
											<?php
											if ( ! $product_permalink ) {
												echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key) . '&nbsp;');
											} else {
												echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
											}

											do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);

											// Meta data.
											echo wc_get_formatted_cart_item_data($cart_item); // phpcs:ignore Standard.Category.SniffName.ErrorCode

											// Backorder notification.
											if ( $_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity']) ) {
												echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'gearnix') . '</p>', $product_id));
											}
											?>
										</div>
									</div>

									<div class="rbb-cart__table-col md:px-4 xl:px-3 py-6 rbb-cart__price flex justify-between font-extrabold uppercase product-price" data-title="<?php esc_attr_e('Price', 'gearnix'); ?>">
										<?php
										echo wp_kses_post(apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key)); // phpcs:ignore Standard.Category.SniffName.ErrorCode
										?>
									</div>

									<div class="rbb-cart__table-col md:px-4 xl:px-3 py-6 rbb-cart__qty flex justify-between product-quantity" data-title="<?php esc_attr_e('Quantity', 'gearnix'); ?>">
										<div class="rbb-item__qty relative flex h-10 justify-between items-center font-medium">
											<?php
											if ( $_product->is_sold_individually() ) {
												$product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
											} else {
												$product_quantity = woocommerce_quantity_input(
													[
														'input_name' => "cart[{$cart_item_key}][qty]",
														'input_value' => $cart_item['quantity'],
														'max_value' => $_product->get_max_purchase_quantity(),
														'min_value' => '0',
														'product_name' => $_product->get_name(),
													],
													$_product,
													false
												);
											}

											echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item); // phpcs:ignore Standard.Category.SniffName.ErrorCode WordPress.Security.EscapeOutput.OutputNotEscaped
											?>
										</div>
									</div>

									<div class="rbb-cart__table-col md:px-4 xl:px-[18px] pt-6 pb-12 sm:pb-6 rbb-cart__subtotal flex justify-between font-extrabold uppercase py-4 product-subtotal" data-title="<?php esc_attr_e('Subtotal', 'gearnix'); ?>">
										<?php
										echo wp_kses_post(apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key)); // phpcs:ignore Standard.Category.SniffName.ErrorCode
										?>
									</div>

									<div class="rbb-cart__remove hidden sm:block product-remove">
										<?php
										echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
											'woocommerce_cart_item_remove_link',
											sprintf(
												'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><i class="rbb-icon-delete-outline-2"></i></a>',
												esc_url(wc_get_cart_remove_url($cart_item_key)),
												esc_html__('Remove this item', 'gearnix'),
												esc_attr($product_id),
												esc_attr($_product->get_sku())
											),
											$cart_item_key
										);
										?>
									</div>
								</div>
								<?php
							}
						}
						?>

						<?php do_action('woocommerce_cart_contents'); ?>

						<?php do_action('woocommerce_after_cart_contents'); ?>
					</div>
				</div>
				<div class="mt-2"><?php do_action('woocommerce_after_cart_table'); ?></div>
				<div class="rbb-cart__bottom sm:flex justify-between">
					<div class="rbb-cart__coupon flex" colspan="6" class="actions">
						<?php if ( wc_coupons_enabled() ) { ?>
								<input type="text" name="coupon_code" class="input-text border border-dashed rounded-[5px] px-8 h-[60px]" id="coupon_code" value="" placeholder="<?php esc_attr_e('Coupon code', 'gearnix'); ?>"/>
								<button type="submit" class="font-bold uppercase rounded-[5px] px-8 ml-[5px] h-[60px] button" name="apply_coupon"
										value="<?php esc_attr_e('Apply coupon', 'gearnix'); ?>"><?php esc_html_e('Apply coupon', 'gearnix'); ?></button>
								<?php do_action('woocommerce_cart_coupon'); ?>
						<?php } ?>

						<?php do_action('woocommerce_cart_actions'); ?>

						<?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
					</div>
					<button type="submit" class="rbb-cart__btn-update duration-300 font-bold uppercase rounded-[5px] h-[60px] px-16 mt-6 sm:mt-0 w-full sm:w-auto button" name="update_cart"
							value="<?php esc_attr_e('Update cart', 'gearnix'); ?>"><?php esc_html_e('Update cart', 'gearnix'); ?></button>
				</div>
			</form>
			<?php add_action('woocommerce_before_cart_collaterals', 'woocommerce_cross_sell_display'); ?>
			<?php do_action('woocommerce_before_cart_collaterals'); ?>
		</div>
		<div class="lg:col-span-1 col-span-3">
			<div class="cart-collaterals">
				<?php
				/**
				 * Cart collaterals hook.
				 *
				 * @hooked woocommerce_cross_sell_display
				 * @hooked woocommerce_cart_totals - 10
				 */
				remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
				do_action('woocommerce_cart_collaterals');
				?>
			</div>
		</div>
	</div>
	<?php do_action('woocommerce_after_cart'); ?>
</div>
