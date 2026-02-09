<?php
/**
 * Order details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.
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

$order = wc_get_order($order_id); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

if ( ! $order ) {
	return;
}

$order_items        = $order->get_items(apply_filters('woocommerce_purchase_order_item_types', 'line_item'));
$show_purchase_note = $order->has_status(apply_filters('woocommerce_purchase_note_order_statuses', [ 'completed', 'processing' ]));
$downloads          = $order->get_downloadable_items();
$show_downloads     = $order->has_downloadable_item() && $order->is_download_permitted();

if ( $show_downloads ) {
	wc_get_template(
		'order/order-downloads.php',
		[
			'downloads'  => $downloads,
			'show_title' => true,
		]
	);
}
?>
<section class="woocommerce-order-details rbb-account__order-detail-content bg-white rounded-2xl px-[30px] pt-[30px] pb-[1px]">
	<?php do_action('woocommerce_order_details_before_order_table', $order); ?>

	<div class="woocommerce-table woocommerce-table--order-details shop_table order_details rbb-account__order-detail-info">
		<div class="flex justify-between border-b-4 pb-[15px] mb-4 pt-2">
			<div class="woocommerce-table__product-name product-name rbb-account__order-detail-title font-bold"><?php esc_html_e('Product', 'gearnix'); ?></div>
			<div class="woocommerce-table__product-table product-total rbb-account__order-detail-title font-bold"><?php esc_html_e('Total', 'gearnix'); ?></div>
		</div>

		<div class="rbb-account__order-detail-info-content">
			<?php
			do_action('woocommerce_order_details_before_order_table_items', $order);

			foreach ( $order_items as $item_id => $item ) {
				$product = $item->get_product();

				wc_get_template(
					'order/order-details-item.php',
					[
						'order'              => $order,
						'item_id'            => $item_id,
						'item'               => $item,
						'show_purchase_note' => $show_purchase_note,
						'purchase_note'      => $product ? $product->get_purchase_note() : '',
						'product'            => $product,
					]
				);
			}

			do_action('woocommerce_order_details_after_order_table_items', $order);
			?>
		</div>
			<?php
			$order_note        = $order->get_customer_note();
			$item_totals       = $order->get_order_item_totals();
			$item_total        = 1;
			$item_totals_count = count($item_totals);
			foreach ( $item_totals as $key => $total ) {
				?>
				<div class="rbb-account__order-detail-subtotal flex justify-between <?php echo esc_attr(( $item_total !== $item_totals_count || ( $order_note ) ) ? 'border-b' : ''); ?> pb-4 mb-4">
					<div class="rbb-account__order-detail-title text-sm font-bold"><?php echo esc_html($total['label']); ?></div>
					<div class="rbb-account__order-detail-subtotal-price rbb-account__order-detail-title font-bold"><?php echo ( 'payment_method' === $key ) ? esc_html($total['value']) : wp_kses_post($total['value']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
				</div>
			<?php $item_total++; } ?>
			<?php if ( $order_note ) : ?>
				<div class="rbb-account__order-detail-note sm:flex justify-between">
					<div class="rbb-account__order-detail-title text-base font-bold sm:mb-0 mb-8"><?php esc_html_e('Note:', 'gearnix'); ?></div>
					<p class="rbb-account__order-detail-desc pb-5 xl:w-3/5 lg:w-2/3 md:w-3/4 w-full xl:pl-8 sm:text-right leading-8 text-sm"><?php echo wp_kses_post(nl2br(wptexturize($order->get_customer_note()))); ?></p>
				</div>
			<?php endif; ?>
	</div>

	<?php do_action('woocommerce_order_details_after_order_table', $order); ?>
</section>

<?php
/**
 * Action hook fired after the order details.
 *
 * @since 4.4.0
 * @param WC_Order $order Order data.
 */
do_action('woocommerce_after_order_details', $order);

if ( $show_customer_details ) {
	wc_get_template('order/order-details-customer.php', [ 'order' => $order ]);
}
