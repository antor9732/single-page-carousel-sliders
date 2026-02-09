<?php
/**
 * Guarantee && Secure Checkout Template.
 *
 * @package RisingBamBooTheme.
 */

use RisingBambooTheme\App\App;
use RisingBambooTheme\Helper\Setting;

$image = Setting::get(RISING_BAMBOO_KIRKI_FIELD_WOOCOMMERCE_PRODUCT_DETAIL_SUMMARY_GUARANTEE_CHECKOUT);
if ( isset($image['url']) && Setting::get(RISING_BAMBOO_KIRKI_FIELD_WOOCOMMERCE_PRODUCT_DETAIL_SUMMARY_SHOW_GUARANTEE_CHECKOUT) ) {
	?>
	<div class="guarantee-safe-checkout bg-[#ededed] p-5 mb-9 text-center w-full rounded-lg overflow-hidden">
		<h5 class="text-[13px] mb-4">
			<?php echo esc_html(Setting::get(RISING_BAMBOO_KIRKI_FIELD_WOOCOMMERCE_PRODUCT_DETAIL_SUMMARY_GUARANTEE_CHECKOUT_TEXT)); ?>
		</h5>
		<img class="inline-block" alt="<?php echo esc_attr__('Guarantee & safe checkout', 'gearnix'); ?>" src="<?php echo esc_url($image['url']); ?>"/>
	</div>
	<?php
}
