<?php
/**
 * Show messages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/notices/notice.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

if ( ! defined('ABSPATH') ) {
	exit; // Exit if accessed directly.
}

if ( ! $notices ) {
	return;
}

?>

<?php foreach ( $notices as $notice ) : ?>
	<div class="container px-0 mx-auto">
	<div class="woocommerce-info rbb-alert__info border p-4 rounded-lg mb-4 flex"<?php echo esc_attr(wc_get_notice_data_attr($notice)); ?>>
		<div><i class="rbb-icon-notification-filled-6"></i></div><div class="text-sm flex-grow ml-2"><?php echo wc_kses_notice($notice['notice']); ?></div>
	</div>
</div>
<?php endforeach; ?>
