<?php
/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     9.6.0
 */

use RisingBambooTheme\App\App;
use RisingBambooTheme\Helper\Setting;
$tabsproduct  = Setting::get(RISING_BAMBOO_KIRKI_FIELD_WOOCOMMERCE_PRODUCT_RELATED_UP_CROSS_SELLS_LAYOUT);
$slidestoshow = Setting::get(RISING_BAMBOO_KIRKI_FIELD_WOOCOMMERCE_PRODUCT_UP_SELLS_COLS);
if ( ! defined('ABSPATH') ) {
	exit;
}

if ( $upsells ) : ?>

	<section class="up-sells upsells products rbb_woo_products relative <?php echo ( 'tabs' !== $tabsproduct ) ? 'pb-[85px]' : ''; ?>">
		<?php
		if ( 'tabs' !== $tabsproduct ) {
			$heading = apply_filters('woocommerce_product_upsells_products_heading', __('Recommended', 'gearnix'));
			if ( $heading ) :
				?>
			<div class="rbb-title -mb-9"><div class="text-[30px] font-extrabold"><?php echo esc_html($heading); ?></div></div>
				<?php
		endif;
		}
		?>
			<div class="slider_content overflow-hidden pt-20">
			<div class="rbb-upsells-product rbb-slick-el slick-carousel slick-carousel-center mb-[30px]" data-slick='{
				"arrows": false,
				"dots": true,
				"autoplay": false,
				"rows": 1,
				"slidesToScroll":1,
				"slidesToShow" : <?php echo esc_attr($slidestoshow); ?>,
				"responsive": [
					{
						"breakpoint": 1024,
						"settings": {
							"slidesToShow": 3
						}
					},
					{
						"breakpoint": 991,
						"settings": {
							"dots": false,
							"slidesToShow": 2
						}
					},
					{
						"breakpoint": 767,
						"settings": {
							"dots": false,
							"slidesToShow": 2
						}
					},
					{
						"breakpoint": 480,
						"settings": {
							"dots": false,
							"slidesToShow": 1
						}
					}
				]
			}'>
			<?php foreach ( $upsells as $upsell ) : ?>
				<?php
				$post_object = get_post($upsell->get_id());
				setup_postdata($GLOBALS['post'] =& $post_object); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found
				wc_get_template_part('content', 'product');
				?>
			<?php endforeach; ?>

		</div>
	</div>

	</section>

	<?php
endif;

wp_reset_postdata();
