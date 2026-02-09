<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.0.0
 */

use RisingBambooTheme\App\App;
defined('ABSPATH') || exit;

do_action('woocommerce_before_mini_cart'); ?>
<?php if ( ! WC()->cart->is_empty() ) : ?>
	<?php do_action('woocommerce_widget_shopping_cart_before_buttons'); ?>
<ul class="woocommerce-mini-cart px-5 mb-5 max-h-[470px] cart_list product_list_widget <?php echo esc_attr($args['list_class']); ?>">
	<?php
	do_action('woocommerce_before_mini_cart_contents');

	foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
		$_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
		$product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

		if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key) ) {
			$product_name      = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
			$thumbnail         = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
			$product_price     = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
			$product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
			?>
			<li class="woocommerce-mini-cart-item mb-2.5 relative flex items-center rounded duration-300 <?php echo esc_attr(apply_filters('woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key)); ?>">
				<div class="product-image rounded-xl p-2 mr-2.5">
					<?php if ( empty($product_permalink) ) : ?>
						<?php echo wp_kses($thumbnail, 'rbb-kses'); ?>
					<?php else : ?>
						<a href="<?php echo esc_url($product_permalink); ?>">
							<?php echo wp_kses($thumbnail, 'rbb-kses'); ?>
						</a>
					<?php endif; ?>
				</div>
				<div class="product-information pr-10">
					<a class="product-name font-semibold pt-0.5 mb-[5px] block" href="<?php echo esc_url($product_permalink); ?>"><?php echo wp_kses_post($product_name); ?></a>
					<?php echo wc_get_formatted_cart_item_data($cart_item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<div class="flex text-xs leading-6">
						<?php echo apply_filters('woocommerce_widget_cart_item_quantity', '<div class="quantity">' . $cart_item['quantity'] . '</div><p class="px-2 text-[10px]">✕</p><div class="product-price font-extrabold">' . $product_price . '</div>', $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php
						echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							'woocommerce_cart_item_remove_link',
							sprintf(
								'<a href="%s" class="remove remove_from_cart_button tracking-normal absolute right-2.5 top-1/2 -mt-3 w-[25px] h-[25px] leading-[25px] ml-6 inline-block rounded-full text-center" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s"><i aria-hidden="true" class="text-xs rbb-icon-delete-outline-2"></i></a>',
								esc_url(wc_get_cart_remove_url($cart_item_key)),
								esc_attr__('Remove this item', 'gearnix'),
								esc_attr($product_id),
								esc_attr($cart_item_key),
								esc_attr($_product->get_sku())
							),
							$cart_item_key
						);
						?>
				</div>
			</div>
		</li>
			<?php
		}
	}

	do_action('woocommerce_mini_cart_contents');
	?>
</ul>
<div class="mini_scroll">
<div class="relative z-10">
	<p class="woocommerce-mini-cart__total total font-bold text-xs uppercase flex mb-4 mx-5 pb-2 pt-[27px] items-center">
	<?php
		/**
		 * Hook: woocommerce_widget_shopping_cart_total.
		 *
		 * @hooked woocommerce_widget_shopping_cart_subtotal - 10
		 */
		do_action('woocommerce_widget_shopping_cart_total');
	?>
	</p>
</div>

	<p class="woocommerce-mini-cart__buttons buttons px-5"><?php do_action('woocommerce_widget_shopping_cart_buttons'); ?></p>
	<?php do_action('woocommerce_widget_shopping_cart_after_buttons'); ?>
</div>

<?php else : ?>
	<div class="pt-[42px] px-5 text-center">
		<img  alt="cart-icon" class="w-[113px] inline-block" src="<?php echo esc_url(RBB_THEME_DIST_URI . 'images/cart/icon-cart.png'); ?>">
		<p class="title text-base pt-11 pb-[3px]"><?php esc_html_e('No products in the cart.', 'gearnix'); ?></p>
		<p class="woocommerce-mini-cart__empty-message max-w-[280px] inline-block">
			<?php
			esc_html_e('Your cart is currently empty. Let us help you find the perfect item!', 'gearnix');
			?>
		</p>
		<div class="shopping font-bold text-xs uppercase pt-3 mb-[30px]">
			<a class="h-[46px] button max-w-[230px] w-full inline-block rounded-[46px] leading-[46px] px-5 text-white duration-300 bg-[var(--rbb-general-button-bg-color)] hover:bg-[var(--rbb-general-button-bg-hover-color)]" href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>">
				<?php esc_html_e('continue shopping', 'gearnix'); ?>
			</a>
		</div>
	</div>
<?php endif; ?>

<?php do_action('woocommerce_after_mini_cart'); ?>
