<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
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
$slidestoshow = Setting::get(RISING_BAMBOO_KIRKI_FIELD_WOOCOMMERCE_PRODUCT_RELATED_COLS);
if ( ! defined('ABSPATH') ) {
	exit;
}

if ( $related_products ) : ?>

	<section class="related rbb_woo_products relative <?php echo ( 'list' === $tabsproduct ) ? ' pb-[85px]' : ''; ?>">
		<?php if ( 'tabs' !== $tabsproduct ) { ?>
		<div class="rbb-title -mb-9 mt-[108px]">
			<div class="text-[30px] font-extrabold"><?php echo esc_html__('Related Products', 'gearnix'); ?></div>
		</div>
		<?php } ?>
		<div class="slider_content pt-20">
			<div class="rbb-related-product rbb-slick-el slick-carousel slick-carousel-center" data-slick='{
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
						"breakpoint": 768,
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
				<?php foreach ( $related_products as $related_product ) : ?>
					<?php
					$post_object = get_post($related_product->get_id());
                    //phpcs:ignore
					setup_postdata($GLOBALS['post'] =& $post_object);
					wc_get_template_part('content', 'product');
					?>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php
endif;

wp_reset_postdata();
