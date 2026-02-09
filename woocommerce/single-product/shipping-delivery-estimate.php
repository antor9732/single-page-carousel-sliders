<?php
/**
 * Shipping delivery estimate template.
 *
 * @package RisingBambooTheme.
 */

use RisingBambooCore\Woocommerce\Shipping;
use RisingBambooTheme\App\App;

$shipping_delivery_range = Shipping::get_shipping_delivery_range();
if ( $shipping_delivery_range ) { ?>

<div class="shipping-delivery-estimate-time overflow-hidden w-full">
	<div class="item product-meta-shipping-delivery-time">
		<i class="rbb-icon-time-6 text-[26px] align-middle pr-3"></i>
		<label class="font-semibold"><?php echo esc_html__('Estimated Delivery : ', 'gearnix'); ?></label>
        <span class="estimate-time"><?php echo Shipping::get_shipping_delivery_range(); //phpcs:ignore ?></span>
	</div>
</div>
<?php } ?>
