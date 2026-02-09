<?php
/**
 * Checkout login form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.0.0
 */

use RisingBambooTheme\App\App;
defined('ABSPATH') || exit;

if ( is_user_logged_in() || 'no' === get_option('woocommerce_enable_checkout_login_reminder') ) {
	return;
}

?>
<div class="col-span-2 xl:col-span-1">
	<div class="woocommerce-form-login-toggle rbb-checkout__login text-center rounded px-4 sm:px-[26px]">
		<div class="rbb-checkout__header uppercase font-extrabold py-5 text-[11px] leading-[18px]">
			<i class="rbb-icon-human-user-10 align-middle mr-3"></i>
			<?php echo apply_filters('woocommerce_checkout_login_message', esc_html__('Returning customer?', 'gearnix')) . ' <a href="#" class="showlogin rbb-checkout__click cursor-pointer">' . esc_html__('Click here to login', 'gearnix') . '</a>'; ?>
		</div>
		<?php
		woocommerce_login_form(
			[
				'message'  => esc_html__('If you have shopped with us before, please enter your details below. If you are a new customer, please proceed to the Billing section.', 'gearnix'),
				'redirect' => wc_get_checkout_url(),
				'hidden'   => true,
			]
		);
		?>
	</div>
</div>
