<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

if ( ! defined('ABSPATH') ) {
	exit;
}

use RisingBambooTheme\App\App;

?>
<div class="checkout-template">
	<div class="container mx-auto px-[15px] xl:px-0 text-left">

		<div class="flex">
			<?php do_action('woocommerce_before_checkout_form_notification', $checkout); ?>
		</div>
		<div class="grid grid-cols-2 gap-4 mt-[60px] lg:mt-[120px]">
			<?php do_action('woocommerce_before_checkout_form', $checkout); ?>
		</div>
		<?php
		// If checkout registration is disabled and not logged in, the user cannot checkout.
		if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
			echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'gearnix')));
			return;
		}
		?>
		<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">
			<div class="grid grid-cols-3 gap-[30px] mt-[30px] mb-[30px] lg:mb-[90px]">
				<!-- Left -->
				<div class="lg:col-span-2 col-span-3 mt-6">

					<?php if ( $checkout->get_checkout_fields() ) : ?>

						<?php do_action('woocommerce_checkout_before_customer_details'); ?>

						<div id="customer_details">
							<div class="rbb-checkout__billing-detail">
								<?php do_action('woocommerce_checkout_billing'); ?>
							</div>

							<div class="rbb-checkout__address">
								<?php do_action('woocommerce_checkout_shipping'); ?>
							</div>
						</div>

						<?php do_action('woocommerce_checkout_after_customer_details'); ?>

					<?php endif; ?>

				</div>
				<!-- Right -->
				<div class="lg:col-span-1 col-span-3">
					<div class="rbb-checkout__order-review border rounded-2xl overflow-hidden mb-[30px] lg:mb-0">
						<?php do_action('woocommerce_checkout_before_order_review_heading'); ?>

						<h3 id="order_review_heading"
						class="rbb-checkout__order-header text-lg uppercase px-7 py-4"><?php esc_html_e('Your order', 'gearnix'); ?></h3>

						<div class="rbb-checkout__order-content px-7 py-6 rounded-2xl">
							<?php do_action('woocommerce_checkout_before_order_review'); ?>

							<div id="order_review" class="woocommerce-checkout-review-order">
								<?php do_action('woocommerce_checkout_order_review'); ?>
							</div>

							<?php do_action('woocommerce_checkout_after_order_review'); ?>
						</div>
					</div>
				</div>
			</div>
		</form>

		<?php do_action('woocommerce_after_checkout_form', $checkout); ?>
	</div>
</div>
