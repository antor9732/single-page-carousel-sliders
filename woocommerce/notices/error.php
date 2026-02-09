<?php
/**
 * Show error messages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/notices/error.php.
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
	exit;
}

if ( ! $notices ) {
	return;
}
?>
<div class="woocommerce-error rbb-alert__danger border p-4 rounded-lg mb-4 flex text-left" role="alert">
	<div>
		<i class="rbb-icon-notification-filled-6"></i>
	</div>
	<ul class="flex-grow ml-2">
	<?php foreach ( $notices as $notice ) : ?>
		<li <?php echo esc_attr(wc_get_notice_data_attr($notice)); ?>>
			<strong class="font-bold text-sm"><?php echo wc_kses_notice($notice['notice']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
		</li>
	<?php endforeach; ?>
	</ul>
</div>
