<?php
/**
 * Single Product Accordion
 *
 * @package RisingBambooTheme
 * @version 1.0.0
 */

if ( ! defined('ABSPATH') ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters('woocommerce_product_tabs', []);

if ( ! empty($product_tabs) ) : ?>
	<div class="block_accordion mb-35">
		<div class="rbb-accordion pt-10">
			<?php
			$index = 1;
			foreach ( $product_tabs as $key => $product_tab ) {
				?>
				<div class="product-single__tabs">
					<div class="rbb-accordion-title cursor-pointer font-extrabold capitalize <?php echo ( 1 === $index ) ? 'act' : ''; ?>">
						<?php echo wp_kses_post(apply_filters('woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key)); ?>
					</div>
					<div class="rbb-accordion-content <?php echo ( 1 === $index ) ? 'block' : 'hidden'; ?>">
						<div class="block pt-8">
							<?php
							if ( isset($product_tab['callback']) ) {
								call_user_func($product_tab['callback'], $key, $product_tab);
							}
							?>
						</div>
					</div>
				</div>
			<?php $index++; } ?>
		</div>
		<?php do_action('woocommerce_product_after_tabs'); ?>
	</div>

<?php endif; ?>
