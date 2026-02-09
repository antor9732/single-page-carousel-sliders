<?php
/**
 * Rising Bamboo Theme.
 *
 * @package RisingBambooTheme.
 */

global $product;

use RisingBambooTheme\App\App;

?>
xxxxxxxxxxxxxxxxxxxxxxxx
<?php if ( ! $product->is_type('grouped') ) : ?>
	<div class="buy-now text-center my-5">
		<a data-product_id="<?php echo esc_attr($product->get_id()); ?>" data-product_sku="<?php echo esc_attr($product->get_sku()); ?>" data-quantity="1" class="single_add_to_cart_button ajax_add_to_cart add_to_cart_button !w-full !float-none text-center rounded-[50px] font-bold leading-[50px] block button relative" href="<?php echo esc_url('?add-to-cart=' . $product->get_id()); ?>" data-redirect="<?php echo esc_attr(wc_get_checkout_url()); ?>">
			<?php echo esc_html__('Buy it now', 'gearnix'); ?>
		</a>
	</div>
<?php endif; ?>
