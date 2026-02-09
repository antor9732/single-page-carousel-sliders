<?php
/**
 * Result Count
 *
 * Shows text: Showing x - x of x results.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/result-count.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     9.9.0
 */

use RisingBambooTheme\App\App;
use RisingBambooTheme\Helper\Setting;
if ( ! defined('ABSPATH') ) {
	exit;
}
$position       = Setting::get(RISING_BAMBOO_KIRKI_SECTION_WOOCOMMERCE_PRODUCT_CATALOG_FILTER_POSITION);
$catalog_layout = Setting::get(RISING_BAMBOO_KIRKI_SECTION_WOOCOMMERCE_PRODUCT_CATALOG_LAYOUT_TYPE);
$products_row   = wc_get_default_products_per_row();
?>
<div class="flex justify-center items-center">
	<div class="grid-list flex justify-center items-center text-center mr-7 text-lg text-[color:var(--rbb-general-button-color)]">
		<?php if ( 'full' === $catalog_layout || 'canvas_bottom' === $position || 'canvas_top' === $position || 'top' === $position || 'off' === $position ) { ?>
		<span class="grid_4 w-[46px] h-[46px] leading-[50px] mr-1.5 rounded <?php echo ( 4 === $products_row ) ? 'active' : ''; ?> " data-type="grid_4">
			<i class="rbb-icon-view-grid-3"></i>
		</span>
		<?php } ?>
		<span class="grid_3 w-[46px] h-[46px] leading-[50px] mr-1.5 rounded <?php echo ( 3 === $products_row ) ? 'active' : ''; ?> " data-type="grid_3">
			<i class="rbb-icon-view-grid-2"></i>
		</span>
		<span class="grid_2 w-[46px] h-[46px] leading-[50px] mr-1.5 rounded <?php echo ( 2 === $products_row ) ? 'active' : ''; ?> " data-type="grid_2">
			<i class="rbb-icon-view-grid-1"></i>
		</span>
		<span class="list w-[46px] h-[46px] leading-[50px] rounded <?php echo ( 1 === $products_row ) ? 'active' : ''; ?> " data-type="grid_1">
			<i class="rbb-icon-view-list-2"></i>
		</span>
	</div>
	<p class="woocommerce-result-count mb-0 text-xs">
		<?php
	// phpcs:disable WordPress.Security
		if ( 1 === intval($total) ) {
			_e('Showing the single result', 'gearnix');
		} elseif ( $total <= $per_page || -1 === $per_page ) {
			/* translators: %d: total results */
			printf(_n('Showing all %d result', 'Showing all %d results', $total, 'gearnix'), $total);
		} else {
			// $first = ( $per_page * $current ) - $per_page + 1;
			$last = min($total, $per_page * $current);
			/* translators: 1: last result 2: total results */
			printf(_nx('Showing %1$d of %2$d result', 'Showing %1$d of %2$d results', $total, 'with first and last result', 'gearnix'), $last, $total);
		}
	// phpcs:enable WordPress.Security
		?>
	</p>
</div>
