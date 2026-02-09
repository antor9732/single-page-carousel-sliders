<?php
/**
 * Free shipping calculator template.
 *
 * @package RisingBambooTheme
 */

use RisingBambooCore\App\App;
use RisingBambooCore\Woocommerce\FreeShippingCalculator;

$min_amount = FreeShippingCalculator::instance()->get_min_amount()['min_amount'];
?>

<div class="rbb-free-shipping-calculator overflow-hidden w-full mt-3">
	<i class="rbb-icon-delivery-10 text-[26px] align-middle pr-3"></i>
	<label class="font-semibold"><?php echo esc_html__('Free Shipping & Returns', 'gearnix'); ?> : </label>
	<?php if ( $min_amount ) { ?>
	<span><?php printf( __('On all order over %s', 'gearnix'), wc_price($min_amount) ); //phpcs:ignore ?></span>
	<?php } else { ?>
	<span><?php echo esc_html__('On all order', 'gearnix'); ?></span>
	<?php } ?>
</div>
