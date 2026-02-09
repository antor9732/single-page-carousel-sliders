<?php
/**
 * My Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-address.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

use RisingBambooTheme\App\App;

defined('ABSPATH') || exit;

$customer_id = get_current_user_id();

if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		[
			'billing'  => __('Billing address', 'gearnix'),
			'shipping' => __('Shipping address', 'gearnix'),
		],
		$customer_id
	);
} else {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		[
			'billing' => __('Billing address', 'gearnix'),
		],
		$customer_id
	);
}
?>
<div class="rbb-account__address">
	<p class="rbb-account__address-top text-[0.8125rem] border-t-[3px] rounded-b-lg px-6 sm:px-7 py-4 mb-[30px]">
		<span class="icon-i mr-4 sm:mr-5 inline-block text-white rounded-full text-center">i</span><?php echo wp_kses_post(apply_filters('woocommerce_my_account_my_address_description', esc_html__('The following addresses will be used on the checkout page by default.', 'gearnix'))); ?>
	</p>
	<div class="grid <?php echo ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) ? 'grid-cols-2' : 'grid-cols-1'; ?> gap-[30px] lg:gap-[30px] woocommerce-Addresses addresses">
		<?php
		foreach ( $get_addresses as $name => $address_title ) {
			$address = wc_get_account_formatted_address($name);
			?>
			<div class="lg:col-span-1 col-span-2 woocommerce-Address">
				<div class="rbb-account__address-content border-2 rounded-2xl overflow-hidden">
					<header class="woocommerce-Address-title rbb-account__address-header font-bold px-[30px] py-[18px] flex items-center justify-between">
						<h3 class="rbb-account__address-title text-sm"><?php echo esc_html($address_title); ?></h3>
						<div class="rbb-account__edit flex items-center">
							<a href="<?php echo esc_url(wc_get_endpoint_url('edit-address', $name)); ?>" class="edit leading-5">
								<?php
								if ( $address ) {
									echo esc_html__('Edit', 'gearnix');
								} else {
									echo esc_html__('Add', 'gearnix');
								}
								?>
								<span class="ml-4 align-middle"></span>
							</a>
						</div>
					</header>
					<p class="rbb-address__content bg-white rbb-address__billing rounded-2xl px-8 pt-8 pb-11 leading-[30px]">
						<?php
						if ( $address ) {
							echo wp_kses_post($address);
						} else {
							esc_html_e('You have not set up this type of address yet.', 'gearnix'); }
														/**
				 * Used to output content after core address fields.
				 *
				 * @param string $name Address type.
				 * @since 8.7.0
				 */
						do_action('woocommerce_my_account_after_my_address', $name);
						?>
					</p>
				</div>
			</div>
		<?php } ?>
	</div>
</div>
