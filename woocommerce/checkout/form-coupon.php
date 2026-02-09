<?php
/**
 * Checkout coupon form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-coupon.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.8.0
 */

use RisingBambooTheme\App\App;
defined('ABSPATH') || exit;

if (!wc_coupons_enabled()) { // @codingStandardsIgnoreLine.
	return;
}

?>
<div class="col-span-2 xl:col-span-1">
	<div class="woocommerce-form-coupon-toggle overflow-hidden rbb-checkout__code text-center rounded px-4 sm:px-[26px]">
		<div class="rbb-checkout__header uppercase font-extrabold py-5 text-[11px] leading-[18px]">
			<i class="rbb-icon-discount-filled-2 align-middle mr-3"></i>
			<?php echo apply_filters('woocommerce_checkout_coupon_message', esc_html__('Have a coupon?', 'gearnix') . ' <a href="#" class="showcoupon rbb-checkout__click cursor-pointer">' . esc_html__('Click here to enter your code', 'gearnix') . '</a>'); ?>
		</div>
		<div class="rbb-checkout__toggle-content">
			<form class="checkout_coupon woocommerce-form-coupon hidden" method="post">
				<p class="leading-9 pb-8"><?php esc_html_e('If you have a coupon code, please apply it below.', 'gearnix'); ?></p>
				<p class="form-row form-row-first">
					<input type="text" name="coupon_code" class="input-text rbb-checkout__input w-full text-center rounded border-dashed border-2 mb-2.5 h-12 px-5 border outline-none shadow-none" placeholder="<?php esc_attr_e('Coupon code', 'gearnix'); ?>" id="coupon_code" value=""/>
				</p>
				<p class="form-row form-row-last">
					<button type="submit" class="button rbb-checkout__btn w-full rounded mb-7 w-full h-12 text-center text-white" name="apply_coupon" value="<?php esc_attr_e('Apply coupon', 'gearnix'); ?>"><?php esc_html_e('Apply coupon', 'gearnix'); ?></button>
				</p>
				<div class="clear"></div>
			</form>
		</div>
	</div>
</div>
