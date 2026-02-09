<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 *
 * @var WC_Order $order
 */

use RisingBambooTheme\App\App;
defined('ABSPATH') || exit;
?>

<div class="woocommerce-order container mx-auto px-[15px] xl:px-0 py-14 lg:py-[116px]">

	<?php
	if ( $order ) :

		do_action('woocommerce_before_thankyou', $order->get_id());
		?>

		<?php if ( $order->has_status('failed') ) : ?>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e('Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'gearnix'); ?></p>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
				<a href="<?php echo esc_url($order->get_checkout_payment_url()); ?>" class="button pay"><?php esc_html_e('Pay', 'gearnix'); ?></a>
				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="button pay"><?php esc_html_e('My account', 'gearnix'); ?></a>
				<?php endif; ?>
			</p>

		<?php else : ?>
			<div class="flex justify-center mb-9">
				<img  alt="checked-icon" class="w-24 h-24" src="<?php echo esc_url(RBB_THEME_DIST_URI . '/images/icons-checked.gif'); ?>">
			</div>
			<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received header font-bold text-center text-2xl"><?php echo apply_filters('woocommerce_thankyou_order_received_text', esc_html__('Thank you. Your order has been received.', 'gearnix'), $order); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<?php
			/**
			 * Cannot use dynamic class. Tailwind JIT v3 force use dummy class.
			 */
			$grid_col            = 'grid-cols-3';
			$grid_col_sm         = 'sm:gird-cols-3';
			$grid_col_lg         = 'lg:gird-cols-3';
			$col_span            = 'col-span-3';
			$col_span_sm         = 'sm:col-span-1';
			$show_email          = ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() );
			$show_payment_method = $order->get_payment_method_title();
			if ( $show_email && $show_payment_method ) {
				$grid_col         = 'grid-cols-5';
				$grid_col_sm      = 'sm:grid-cols-4';
				$grid_col_lg      = 'xl:grid-cols-5';
				$col_span         = 'col-span-5';
				$col_span_sm      = 'sm:col-span-2';
				$col_span_sm_last = 'sm:col-span-4';

			} elseif ( $show_email || $show_payment_method ) {
				$grid_col    = 'grid-cols-4';
				$grid_col_sm = 'sm:grid-cols-4';
				$grid_col_lg = 'lg:grid-cols-4';
				$col_span    = 'col-span-4';
				$col_span_sm = 'sm:col-span-2';
			}
			?>
			<div class="woocommerce-order-overview woocommerce-thankyou-order-details order_details grid <?php echo esc_attr($grid_col); ?> <?php echo esc_attr($grid_col_sm); ?> <?php echo esc_attr($grid_col_lg); ?> gap-[10px] mt-[38px] mb-12">

				<div class="xl:col-span-1 <?php echo esc_attr($col_span_sm); ?> <?php echo esc_attr($col_span); ?>">
					<div class="woocommerce-order-overview__order order text-center px-2 rounded-lg rbb-order-received__btn h-14 leading-[58px] truncate">
						<?php esc_html_e('Order number:', 'gearnix'); ?>
						<strong><?php echo esc_html($order->get_order_number()); ?></strong>
					</div>
				</div>

				<div class="xl:col-span-1 <?php echo esc_attr($col_span_sm); ?> <?php echo esc_attr($col_span); ?>">
					<div class="woocommerce-order-overview__date date text-center px-2 rounded-lg rbb-order-received__btn h-14 leading-[58px] truncate">
						<?php esc_html_e('Date:', 'gearnix'); ?>
						<strong><?php echo wp_kses(wc_format_datetime($order->get_date_created()), 'entities'); ?></strong>
					</div>
				</div>
				<?php if ( $show_email ) : ?>
					<div class="xl:col-span-1 <?php echo esc_attr($col_span_sm); ?> <?php echo esc_attr($col_span); ?>">
						<div class="woocommerce-order-overview__email email text-center px-2 rounded-lg rbb-order-received__btn h-14 leading-[58px] truncate">
							<?php esc_html_e('Email:', 'gearnix'); ?>
							<strong><?php echo wp_kses($order->get_billing_email(), 'entities'); ?></strong>
						</div>
					</div>
				<?php endif; ?>

				<div class="xl:col-span-1 <?php echo esc_attr($col_span_sm); ?> <?php echo esc_attr($col_span); ?>">
					<div class="woocommerce-order-overview__total total text-center px-2 rounded-lg rbb-order-received__btn h-14 leading-[58px] truncate">
						<?php esc_html_e('Total:', 'gearnix'); ?>
						<strong><?php echo wp_kses($order->get_formatted_order_total(), 'entities'); ?></strong>
					</div>
				</div>

				<?php if ( $show_payment_method ) : ?>
					<div class="xl:col-span-1 <?php echo esc_attr($col_span_sm); ?> <?php echo esc_attr($col_span_sm_last); ?> <?php echo esc_attr($col_span); ?>">
						<div class="woocommerce-order-overview__payment-method method text-center px-2 rounded-lg rbb-order-received__btn h-14 leading-[58px] truncate">
							<?php esc_html_e('Payment method:', 'gearnix'); ?>
							<strong><?php echo wp_kses_post($order->get_payment_method_title()); ?></strong>
						</div>
					</div>
				<?php endif; ?>
			</div>

		<?php endif; ?>
		<div class="-m-[30px]">

			<?php do_action('woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id()); ?>
			<?php do_action('woocommerce_thankyou', $order->get_id()); ?>
		</div>

	<?php else : ?>

		<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters('woocommerce_thankyou_order_received_text', esc_html__('Thank you. Your order has been received.', 'gearnix'), null); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>

	<?php endif; ?>

</div>
