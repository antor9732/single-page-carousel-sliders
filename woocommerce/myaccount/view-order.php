<?php
/**
 * View Order
 *
 * Shows the details of a particular order on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/view-order.php.
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

$notes                 = $order->get_customer_order_notes();
$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();

?>
<div class="rbb-account__order-detail border-2 rounded-2xl">
<p class="rbb-account__order-detail-top px-6 sm:px-[30px] py-5 leading-[22px]">
	<span class="icon-i mr-4 sm:mr-2.5 inline-block text-white rounded-full text-sm text-center">i</span>
<?php
printf(
	/* translators: 1: order number 2: order date 3: order status */
	esc_html__('Order #%1$s was placed on %2$s and is currently %3$s.', 'gearnix'),
	'<strong class="order-number">' . $order->get_order_number() . '</strong>', // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	'<strong class="order-date">' . wc_format_datetime($order->get_date_created()) . '</strong>', // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	'<strong class="order-status">' . wc_get_order_status_name($order->get_status()) . '</strong>' // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
);
?>
</p>

<?php if ( $notes ) : ?>
	<div class="p-[30px] bg-white mb-5 rounded-2xl">
	<h2 class="text-lg pb-3 text-[#222222]"><?php esc_html_e('Order updates', 'gearnix'); ?></h2>
	<ol class="woocommerce-OrderUpdates commentlist notes leading-[22px]">
		<?php foreach ( $notes as $note ) : ?>
		<li class="woocommerce-OrderUpdate comment note">
			<div class="woocommerce-OrderUpdate-inner comment_container">
				<div class="woocommerce-OrderUpdate-text comment-text">
					<p class="woocommerce-OrderUpdate-meta meta"><?php echo date_i18n(esc_html__('l jS \o\f F Y, h:ia', 'gearnix'), strtotime($note->comment_date)); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
					<div class="woocommerce-OrderUpdate-description description">
						<?php echo wpautop(wptexturize($note->comment_content)); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>
		</li>
		<?php endforeach; ?>
	</ol>
</div>
<?php endif; ?>

<?php do_action('woocommerce_view_order', $order_id); ?>
</div>

<?php
if ( $show_customer_details ) {
	wc_get_template('order/order-details-customer.php', [ 'order' => $order ]);
}
?>
