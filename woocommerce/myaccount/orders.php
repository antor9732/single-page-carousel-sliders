<?php
/**
 * Orders
 * Shows orders on the account page.
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/orders.php.
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.5.0
 */

use RisingBambooTheme\App\App;

defined('ABSPATH') || exit;

do_action('woocommerce_before_account_orders', $has_orders); ?>

<div class="rbb-account__order">
	<?php if ( $has_orders ) { ?>

		<div class="rbb-account__order-content border-2 rounded-2xl">
			<div class="rbb-account__table-header hidden lg:block font-bold uppercase px-8 xl:px-12">
				<div class="flex">
					<?php
					$column_order = 1;
					foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) {
						?>
						<div class="rbb-account__table-col text-[13px] px-4 py-[21px] leading-5 <?php echo 1 === $column_order ? 'sm:pl-0' : ''; ?> rbb-account__item-<?php echo esc_attr(strtolower($column_id)); ?>"><?php echo esc_html($column_name); ?></div>
						<?php
						$column_order++;
					}
					?>
				</div>
			</div>

			<div class="rbb-account__order-list bg-white px-7 lg:px-7 rounded-2xl">
				<?php
				foreach ( $customer_orders->orders as $customer_order ) {
					$order      = wc_get_order($customer_order); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
					$item_count = $order->get_item_count() - $order->get_item_count_refunded();
					?>
					<div class="rbb-account__item lg:flex items-center border-b py-4 lg:py-0 woocommerce-orders-table__row--status-<?php echo esc_attr($order->get_status()); ?>">
						<?php
						$column_order = 1;
						foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) {
							?>
							<div class="rbb-account__table-col rbb-account__item-<?php echo esc_attr(strtolower($column_id)); ?> py-3 lg:py-9 <?php echo 1 === $column_order ? 'lg:pl-0 items-center' : ''; ?> text-[13px] leading-5" data-title="<?php echo esc_attr($column_name); ?>">
								<?php if ( has_action('woocommerce_my_account_my_orders_column_' . $column_id) ) : ?>
									<?php do_action('woocommerce_my_account_my_orders_column_' . $column_id, $order); ?>

								<?php elseif ( 'order-number' === $column_id ) : ?>
									<a href="<?php echo esc_url($order->get_view_order_url()); ?>">
										<?php echo esc_html(_x('#', 'hash before order number', 'gearnix') . $order->get_order_number()); ?>
									</a>

								<?php elseif ( 'order-date' === $column_id ) : ?>
									<time datetime="<?php echo esc_attr($order->get_date_created()->date('c')); ?>"><?php echo esc_html(wc_format_datetime($order->get_date_created())); ?></time>

								<?php elseif ( 'order-status' === $column_id ) : ?>
									<?php echo esc_html(wc_get_order_status_name($order->get_status())); ?>

								<?php elseif ( 'order-total' === $column_id ) : ?>
									<?php
									/* translators: 1: formatted order total 2: total order items */
									echo wp_kses_post(sprintf(_n('%1$s for %2$s item', '%1$s for %2$s items', $item_count, 'gearnix'), $order->get_formatted_order_total(), $item_count));
									?>

								<?php elseif ( 'order-actions' === $column_id ) : ?>
									<?php
									$actions = wc_get_account_orders_actions($order);

									if ( ! empty($actions) ) {
										foreach ( $actions as $key => $action ) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
											echo '<a href="' . esc_url($action['url']) . '" class="text-xs font-bold ' . sanitize_html_class($key) . '">' . esc_html($action['name']) . '</a>';
										}
									}
									?>
								<?php endif; ?>
							</div>
							<?php
							$column_order++;
						}
						?>
					</div>
					<?php
				}
				?>
			</div>
		</div>

		<?php do_action('woocommerce_before_account_orders_pagination'); ?>

		<?php if ( 1 < $customer_orders->max_num_pages ) : ?>
			<div class="woocommerce-pagination woocommerce-pagination--without-numbers woocommerce-Pagination">
				<?php if ( 1 !== $current_page ) : ?>
					<a class="woocommerce-button woocommerce-button--previous woocommerce-Button woocommerce-Button--previous button" href="<?php echo esc_url(wc_get_endpoint_url('orders', $current_page - 1)); ?>"><?php esc_html_e('Previous', 'gearnix'); ?></a>
				<?php endif; ?>

				<?php if ( intval($customer_orders->max_num_pages) !== $current_page ) : ?>
					<a class="woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next button" href="<?php echo esc_url(wc_get_endpoint_url('orders', $current_page + 1)); ?>"><?php esc_html_e('Next', 'gearnix'); ?></a>
				<?php endif; ?>
			</div>
		<?php endif; ?>

	<?php } else { ?>
		<div class="rbb-account__order-no border-t-4 rounded-b-lg px-6 sm:px-10 py-8 mb-8 flex justify-between">
			<div>
				<i class="rbb-icon-notification-filled-6 text-lg mr-8 align-middle"></i>
				<span>
					<?php esc_html_e('No order has been made yet.', 'gearnix'); ?>
				</span>
			</div>
			<a class="font-semibold" href="<?php echo esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))); ?>"><?php esc_html_e('Browse products', 'gearnix'); ?></a>
		</div>
	<?php } ?>

	<?php do_action('woocommerce_after_account_orders', $has_orders); ?>
</div>
