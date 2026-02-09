<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
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
use RisingBambooTheme\Helper\Helper;

if ( ! defined('ABSPATH') ) {
	exit;
}

do_action('woocommerce_before_account_navigation');
?>

<div class="woocommerce-MyAccount-navigation md:col-span-1 col-span-3">
	<div class="rbb-account__list border-2 rounded-2xl">
		<div class="rbb-account__header title uppercase font-extrabold text-lg px-[30px] py-[15px]"><?php esc_html_e('My Account', 'gearnix'); ?></div>
		<ul class="p-[30px] rounded-2xl">
			<?php
				$i     = 1;
				$items = wc_get_account_menu_items();
				$count = count($items);
			foreach ( $items as $endpoint => $label ) {
				?>
				<li class="<?php echo wc_get_account_menu_item_classes($endpoint); ?>">
					<a class="font-semibold block <?php echo esc_attr(( $i < $count ) ? 'border-b mb-4 pb-4' : ''); ?>" href="<?php echo esc_url(wc_get_account_endpoint_url($endpoint)); ?>">
						<div class="inline-flex">
						<?php echo wp_kses_post(Helper::woo_get_account_menu_item_icon($endpoint, 'align-middle mr-6 lg:mr-8 rtl:ml-0')); ?><span class="align-middle"><?php echo esc_html($label); ?></span>
						</div>
					</a>
				</li>
			<?php $i++; } ?>
		</ul>
	</div>
</div>

<?php do_action('woocommerce_after_account_navigation'); ?>
