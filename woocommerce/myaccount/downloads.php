<?php
/**
 * Downloads
 *
 * Shows downloads on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/downloads.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.8.0
 */

use RisingBambooTheme\App\App;

if ( ! defined('ABSPATH') ) {
	exit;
}

$downloads     = WC()->customer->get_downloadable_products();
$has_downloads = (bool) $downloads;

do_action('woocommerce_before_account_downloads', $has_downloads); ?>

<?php if ( $has_downloads ) : ?>

	<?php do_action('woocommerce_before_available_downloads'); ?>

	<?php do_action('woocommerce_available_downloads', $downloads); ?>

	<?php do_action('woocommerce_after_available_downloads'); ?>

<?php else : ?>
	<div class="rbb-account__order">
		<div class="rbb-account__order-no border-t-4 rounded-b-lg px-6 sm:pl-7 sm:pr-2 py-2 mb-8 flex justify-between">
			<div class="leading-10">
				<i class="rbb-icon-notification-filled-6 text-lg mr-5 align-middle"></i><span><?php esc_html_e('No downloads available yet.', 'gearnix'); ?></span>
			</div>
			<div class="overflow-hidden h-10 leading-10">
				<a class="woocommerce-Button button py-4" href="<?php echo esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))); ?>">
					<?php esc_html_e('Browse products', 'gearnix'); ?>
				</a>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php do_action('woocommerce_after_account_downloads', $has_downloads); ?>
