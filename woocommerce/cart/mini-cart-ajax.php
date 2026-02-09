<?php
/**
 * Mini cart Ajax
 *
 * @package RisingBambooTheme.
 * @version 1.0.0
 * @since 1.0.0
 */

use RisingBambooTheme\Helper\Helper;
use RisingBambooTheme\Helper\Setting;
use RisingBambooTheme\Woocommerce\Woocommerce as RisingBambooWoocommerce;

if ( ! Helper::woocommerce_activated() ) {
	return;
}
$layout          = Setting::get(RISING_BAMBOO_KIRKI_FIELD_WOOCOMMERCE_MINI_CART_LAYOUT);
$modal_effect    = Setting::get(RISING_BAMBOO_KIRKI_FIELD_COMPONENT_MODAL_EFFECT);
$outside         = Setting::get(RISING_BAMBOO_KIRKI_FIELD_COMPONENT_MODAL_CLICK_OUTSIDE_CLOSE);
$backdrop_filter = Setting::get(RISING_BAMBOO_KIRKI_FIELD_COMPONENT_MODAL_BACKDROP_FILTER);
$classes         = [ 'rbb-mini-cart-canvas rbb-modal ' ];
$classes[]       = ( true === $backdrop_filter ) ? 'backdrop' : 'backdrop-none';
$classes[]       = ( false === $outside ) ? 'outside-modal' : '';
$class_string    = implode(' ', array_filter($classes));
?>
<div id="_desktop_cart" class="rbb-mini-cart relative flex items-center justify-center" data-text_added="<?php echo esc_attr__('Product was added to cart successfully!', 'gearnix'); ?>">
	<div class="dropdown">
		<div class="mini-cart-icon duration-300 justify-center flex items-center relative">
			<button onclick="RisingBambooModal.modal('.rbb-mini-cart-canvas', event)"  class="border-none button-icon h-8 min-w-8 justify-end flex items-center text-center relative bg-transparent p-0 inline-flex justify-center w-full text-sm transition duration-150 ease-in-out focus:outline-none" type="button">
				<span class="cart-icon <?php echo esc_attr(Setting::get(RISING_BAMBOO_KIRKI_FIELD_WOOCOMMERCE_MINI_CART_ICON)); ?>"></span>
				<?php echo wp_kses_post(RisingBambooWoocommerce::cart_count()); ?>
			</button>
		</div>
		<?php if ( 'dropdown' === $layout ) { ?>
		<div class="mini-cart-content bg-[color:var(--rbb-mini-cart-content-background-color)] z-10 absolute top-full pt-5 xl:-right-[30px] right-0 opacity-0 invisible dropdown-menu transition-all duration-300 transform origin-top-right">
			<div class="pt-5 overflow-hidden min-w-[332px] rounded-[18px] origin-top-right outline-none shadow-[5px_6px_15px_0px_rgba(0,0,0,0.15)]" id="mini-cart-content-control" role="menu">
				<?php echo wp_kses_post(RisingBambooWoocommerce::mini_cart_content()); ?>
			</div>
		</div>
			<?php
		} else {
			?>
			<div class="<?php echo esc_attr($class_string); ?>">
				<div class="cart-right md:w-[370px] w-4/5 fixed top-0 -right-[370px] bottom-0 bg-white z-30 shadow-[-10px_0_15px_0_rgba(0,0,0,0.1)]">
					<div class="title-cart title relative items-center flex px-5 pt-[14px] pb-3 mb-5">
						<?php echo wp_kses_post(RisingBambooWoocommerce::cart_count()); ?>
						<i class="text-2xl <?php echo esc_attr(Setting::get(RISING_BAMBOO_KIRKI_FIELD_WOOCOMMERCE_MINI_CART_ICON)); ?>"></i>
						<span class="pl-4 text-sm title uppercase"><?php echo esc_html__('Shopping Cart', 'gearnix'); ?></span>
					</div>
					<?php echo wp_kses_post(RisingBambooWoocommerce::mini_cart_content()); ?>
				</div>
			</div>
		<?php } ?>
	</div>
</div>
