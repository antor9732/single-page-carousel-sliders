<?php
/**
 * Order Customer Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-customer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.7.0
 */

use RisingBambooTheme\App\App;

defined('ABSPATH') || exit;

$show_shipping = ! wc_ship_to_billing_address_only() && $order->needs_shipping_address();
?>
<section class="woocommerce-customer-details grid <?php echo esc_attr(( $show_shipping ) ? 'grid-cols-2' : 'grid-cols-1'); ?> gap-8 lg:gap-[30px] mt-[30px]">
	<div class="lg:col-span-1 col-span-2">
		<div class="rbb-account__order-detail border-2 rounded-3xl overflow-hidden">
			<div class="rbb-account__address-header font-bold px-[30px] py-[18px] flex items-center justify-between">
				<h3 class="rbb-account__address-title text-base"><?php esc_html_e('Billing address', 'gearnix'); ?></h3>
			</div>
			<div class="rbb-address__content bg-white rbb-address__billing rounded-2xl px-[30px] py-8 leading-8">
					<?php echo wp_kses_post($order->get_formatted_billing_address(esc_html__('N/A', 'gearnix'))); ?>

					<?php if ( $order->get_billing_phone() ) : ?>
						<p class="woocommerce-customer-details--phone"><?php echo esc_html($order->get_billing_phone()); ?></p>
					<?php endif; ?>

					<?php if ( $order->get_billing_email() ) : ?>
						<p class="woocommerce-customer-details--email"><?php echo esc_html($order->get_billing_email()); ?></p>
					<?php endif; ?>
			</div>
		</div>
	</div>

	<?php if ( $show_shipping ) : ?>
		<div class="lg:col-span-1 col-span-2">
			<div class="rbb-account__order-detail border-2 rounded-2xl overflow-hidden">
				<div class="rbb-account__address-header font-bold px-[30px] py-[18px] flex items-center justify-between">
					<h3 class="rbb-account__address-title text-base"><?php esc_html_e('Shipping address', 'gearnix'); ?></h3>
				</div>
				<div class="rbb-address__content bg-white rbb-address__shipping rounded-2xl px-[30px] py-8 leading-8">
					<?php echo wp_kses_post($order->get_formatted_shipping_address(esc_html__('N/A', 'gearnix'))); ?>

					<?php if ( $order->get_shipping_phone() ) : ?>
						<p class="woocommerce-customer-details--phone"><?php echo esc_html($order->get_shipping_phone()); ?></p>
					<?php endif; ?>
				<?php
					/**
					 * Action hook fired after an address in the order customer details.
					 *
					 * @since 8.7.0
					 * @param string $address_type Type of address (billing or shipping).
					 * @param WC_Order $order Order object.
					 */
					do_action('woocommerce_order_details_after_customer_address', 'shipping', $order);
				?>
				</div>
			</div>
		</div><!-- /.col-2 -->
	<?php endif; ?>

	<?php do_action('woocommerce_order_details_after_customer_details', $order); ?>

</section>
