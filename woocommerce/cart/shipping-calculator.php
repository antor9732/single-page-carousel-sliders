<?php
/**
 * Shipping Calculator
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/shipping-calculator.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.7.0
 */

use RisingBambooTheme\App\App;
defined('ABSPATH') || exit;

do_action('woocommerce_before_shipping_calculator'); ?>

<form class="rbb-cart__shipping-calculator border-b pb-9 mb-8 woocommerce-shipping-calculator" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">

	<?php printf('<a href="#" class="shipping-calculator-button font-bold">%s<span class="ml-2.5 align-middle"></span></a>', esc_html( ! empty($button_text) ? $button_text : __('Calculate shipping', 'gearnix'))); // phpcs:ignore PEAR.Functions.FunctionCallSignature.SpaceAfterOpenBracket ?>
	<section class="shipping-calculator-form hidden">
		<?php if ( apply_filters('woocommerce_shipping_calculator_enable_country', true) ) : ?>
			<div class="form-row form-row-wide mt-6 pb-2.5" id="calc_shipping_country_field">
				<select name="calc_shipping_country" id="calc_shipping_country" class="country_to_state country_select w-full" rel="calc_shipping_state">
					<option value="default"><?php esc_html_e('Select a country / region&hellip;', 'gearnix'); ?></option>
					<?php
					foreach ( WC()->countries->get_shipping_countries() as $key => $value ) {
						echo '<option value="' . esc_attr($key) . '"' . selected(WC()->customer->get_shipping_country(), esc_attr($key), false) . '>' . esc_html($value) . '</option>';
					}
					?>
				</select>
			</div>
		<?php endif; ?>

		<?php if ( apply_filters('woocommerce_shipping_calculator_enable_state', true) ) : ?>
			<div class="form-row form-row-wide mb-3" id="calc_shipping_state_field">
				<?php
				$current_cc = WC()->customer->get_shipping_country();
				$current_r  = WC()->customer->get_shipping_state();
				$states     = WC()->countries->get_states($current_cc);

				if ( is_array($states) && empty($states) ) {
					?>
					<input type="hidden" name="calc_shipping_state" id="calc_shipping_state" placeholder="<?php esc_attr_e('State / County', 'gearnix'); ?>" />
					<?php
				} elseif ( is_array($states) ) {
					?>
					<div>
						<select name="calc_shipping_state" class="state_select" id="calc_shipping_state" data-placeholder="<?php esc_attr_e('State / County', 'gearnix'); ?>">
							<option value=""><?php esc_html_e('Select an option&hellip;', 'gearnix'); ?></option>
							<?php
							foreach ( $states as $ckey => $cvalue ) {
								echo '<option value="' . esc_attr($ckey) . '" ' . selected($current_r, $ckey, false) . '>' . esc_html($cvalue) . '</option>';
							}
							?>
						</select>
					</div>
					<?php
				} else {
					?>
					<input type="text" class="input-text border boder-solid rounded-md outline-none px-2 h-12 w-full" value="<?php echo esc_attr($current_r); ?>" placeholder="<?php esc_attr_e('State / County', 'gearnix'); ?>" name="calc_shipping_state" id="calc_shipping_state" />
					<?php
				}
				?>
			</div>
		<?php endif; ?>

		<?php if ( apply_filters('woocommerce_shipping_calculator_enable_city', true) ) : ?>
			<div class="form-row form-row-wide mb-2.5" id="calc_shipping_city_field">
				<input type="text" class="input-text border boder-solid rounded outline-none px-2 h-12 w-full" value="<?php echo esc_attr(WC()->customer->get_shipping_city()); ?>" placeholder="<?php esc_attr_e('City', 'gearnix'); ?>" name="calc_shipping_city" id="calc_shipping_city" />
			</div>
		<?php endif; ?>

		<?php if ( apply_filters('woocommerce_shipping_calculator_enable_postcode', true) ) : ?>
			<div class="form-row form-row-wide mb-2.5" id="calc_shipping_postcode_field">
				<input type="text" class="input-text border boder-solid rounded outline-none px-2 h-12 w-full" value="<?php echo esc_attr(WC()->customer->get_shipping_postcode()); ?>" placeholder="<?php esc_attr_e('Postcode / ZIP', 'gearnix'); ?>" name="calc_shipping_postcode" id="calc_shipping_postcode" />
			</div>
		<?php endif; ?>

		<button type="submit" name="calc_shipping" value="1" class="button text-white h-12 rounded px-10 font-bold text-xs"><?php esc_html_e('Update', 'gearnix'); ?></button>
		<?php wp_nonce_field('woocommerce-shipping-calculator', 'woocommerce-shipping-calculator-nonce'); ?>
	</section>
</form>

<?php do_action('woocommerce_after_shipping_calculator'); ?>
