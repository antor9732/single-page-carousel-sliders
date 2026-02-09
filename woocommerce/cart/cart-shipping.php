<?php
/**
 * Shipping Methods Display
 *
 * In 2.1 we show methods per package. This allows for multiple methods per order if so desired.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-shipping.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.8.0
 */

use RisingBambooTheme\App\App;
defined('ABSPATH') || exit;

$formatted_destination    = isset($formatted_destination) ? $formatted_destination : WC()->countries->get_formatted_address($package['destination'], ', ');
$has_calculated_shipping  = ! empty($has_calculated_shipping);
$show_shipping_calculator = ! empty($show_shipping_calculator);
$calculator_text          = '';
?>
<div class="rbb-cart__totals-shipping woocommerce-shipping-totals shipping">
	<div class="rbb-cart__header font-bold pb-6"><?php echo wp_kses_post($package_name); ?></div>
	<div data-title="<?php echo esc_attr($package_name); ?>">
		<?php if ( ! empty($available_methods) && is_array($available_methods) ) { ?>
			<div id="shipping_method" class="woocommerce-shipping-methods">
				<?php foreach ( $available_methods as $method ) { ?>
					<div class="rbb-cart__shipping-<?php echo esc_attr($method->method_id); ?> flex mb-4">
						<?php
						if ( 1 < count($available_methods) ) {
							printf('<label class="rbb__input-radio grow-0" for="shipping_method_%1$s_%2$s"><input type="radio" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method" %4$s /><span class="presentation !align-middle"></span></label>', esc_attr($index), esc_attr(sanitize_title($method->id)), esc_attr($method->id), checked($method->id, $chosen_method, false)); // phpcs:ignore Standard.Category.SniffName.ErrorCod
						} else {
							printf('<label for="rbb__input-radio shipping_method_%1$s_%2$s"><input type="hidden" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method" /><span class="presentation !align-middle"></span></label>', esc_attr($index), esc_attr(sanitize_title($method->id)), esc_attr($method->id)); // phpcs:ignore Standard.Category.SniffName.ErrorCod
						}
						printf('<div class="flex-grow flex items-center justify-between">%1$s</div>', wp_kses(wc_cart_totals_shipping_method_label($method), 'entities')); // phpcs:ignore Standard.Category.SniffName.ErrorCode
						do_action('woocommerce_after_shipping_rate', $method, $index);
						?>
					</div>
				<?php } ?>
			</div>
			<?php if ( is_cart() ) : ?>
				<div class="mb-8 pl-8 woocommerce-shipping-destination">
					<?php
					if ( $formatted_destination ) {
						// Translators: $s shipping destination.
						printf(esc_html__('Shipping to %s.', 'gearnix') . ' ', '<strong>' . esc_html($formatted_destination) . '</strong>');
						$calculator_text = esc_html__('Change address', 'gearnix');
					} else {
						echo wp_kses_post(apply_filters('woocommerce_shipping_estimate_html', __('Shipping options will be updated during checkout.', 'gearnix')));
					}
					?>
				</div>
			<?php endif; ?>
			<?php
		} elseif ( ! $has_calculated_shipping || ! $formatted_destination ) {
			if ( is_cart() && 'no' === get_option('woocommerce_enable_shipping_calc') ) {
				echo wp_kses_post(apply_filters('woocommerce_shipping_not_enabled_on_cart_html', __('Shipping costs are calculated during checkout.', 'gearnix')));
			} else {
				echo wp_kses_post(apply_filters('woocommerce_shipping_may_be_available_html', __('Enter your address to view shipping options.', 'gearnix')));
			}
		} elseif ( ! is_cart() ) {
			echo wp_kses_post(apply_filters('woocommerce_no_shipping_available_html', __('There are no shipping options available. Please ensure that your address has been entered correctly, or contact us if you need any help.', 'gearnix')));
		} else {
			// Translators: $s shipping destination.
			echo wp_kses_post(apply_filters('woocommerce_cart_no_shipping_available_html', sprintf(esc_html__('No shipping options were found for %s.', 'gearnix') . ' ', '<strong>' . esc_html($formatted_destination) . '</strong>')));
			$calculator_text = esc_html__('Enter a different address', 'gearnix');
		}
		?>

		<?php if ( $show_package_details ) : ?>
			<?php echo '<p class="woocommerce-shipping-contents"><small>' . esc_html($package_details) . '</small></p>'; ?>
		<?php endif; ?>

		<?php if ( $show_shipping_calculator ) : ?>
			<?php woocommerce_shipping_calculator($calculator_text); ?>
		<?php endif; ?>
	</div>
</div>
