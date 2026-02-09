<?php
/**
 * Cross-sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cross-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.6.0
 */

use RisingBambooTheme\App\App;
use RisingBambooTheme\Helper\Setting;
$slidestoshow = Setting::get(RISING_BAMBOO_KIRKI_FIELD_WOOCOMMERCE_PRODUCT_CROSSS_SELLS_COLS);
defined('ABSPATH') || exit;
if ( $cross_sells ) : ?>

	<div class="cross-sells rbb_woo_products pt-20">
		<?php
		$heading = apply_filters('woocommerce_product_cross_sells_products_heading', __('You May Also Like', 'gearnix'));

		if ( $heading ) :
			?>
			<div class="mb-10"><h5 class="uppercase"><?php echo esc_html($heading); ?></h5></div>
		<?php endif; ?>
		<div class="-mx-[15px] overflow-hidden">
		<div class="rbb-cross-sells-product rbb-slick-el slick-carousel slick-carousel-center pb-10" data-slick='{
				"arrows": false,
				"dots": true,
				"autoplay": false,
				"rows": 1,
				"slidesToScroll":1,
				"slidesToShow" : <?php echo esc_attr($slidestoshow); ?>,
				"responsive": [
					{
						"breakpoint": 103,
						"settings": {
							"slidesToShow": 2
						}
					},
					{
						"breakpoint": 767,
						"settings": {
							"slidesToShow": 2
						}
					},
					{
						"breakpoint": 480,
						"settings": {
							"slidesToShow": 1
						}
					}
				]
			}'>

			<?php foreach ( $cross_sells as $cross_sell ) : ?>

				<?php
					$post_object = get_post($cross_sell->get_id());

					setup_postdata($GLOBALS['post'] =& $post_object); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

					wc_get_template_part('content', 'product');
				?>

			<?php endforeach; ?>
		</div>
		</div>

	</div>
	<?php
endif;

wp_reset_postdata();
