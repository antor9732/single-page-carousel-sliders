<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

use RisingBambooTheme\Helper\Helper;
use RisingBambooCore\App\App;
use RisingBambooCore\Helper\Woocommerce as RbbCoreHelperWoocommerce;
use RisingBambooTheme\Helper\Setting;
use RisingBambooTheme\Helper\Tag;

defined('ABSPATH') || exit;

global $product;

// Ensure visibility.
if ( empty($product) || ! $product->is_visible() ) {
	return;
}
$show_wishlist       = Setting::get(RISING_BAMBOO_KIRKI_SECTION_WOOCOMMERCE_PRODUCT_CATALOG_PRODUCT_ITEM_SHOW_WISHLIST);
$show_rating         = Setting::get(RISING_BAMBOO_KIRKI_SECTION_WOOCOMMERCE_PRODUCT_CATALOG_PRODUCT_ITEM_SHOW_RATING);
$show_quick_view     = Setting::get(RISING_BAMBOO_KIRKI_SECTION_WOOCOMMERCE_PRODUCT_CATALOG_PRODUCT_ITEM_SHOW_QUICK_VIEW);
$show_compare        = Setting::get(RISING_BAMBOO_KIRKI_SECTION_WOOCOMMERCE_PRODUCT_CATALOG_PRODUCT_ITEM_SHOW_COMPARE);
$show_add_to_cart    = Setting::get(RISING_BAMBOO_KIRKI_SECTION_WOOCOMMERCE_PRODUCT_CATALOG_PRODUCT_ITEM_SHOW_ADD_TO_CART);
$show_stock          = Setting::get(RISING_BAMBOO_KIRKI_SECTION_WOOCOMMERCE_PRODUCT_CATALOG_PRODUCT_ITEM_SHOW_STOCK);
$show_custom_field   = Setting::get(RISING_BAMBOO_KIRKI_SECTION_WOOCOMMERCE_PRODUCT_CATALOG_PRODUCT_ITEM_SHOW_CUSTOM_FIELDS);
$product_images      = Setting::get(RISING_BAMBOO_KIRKI_FIELD_WOOCOMMERCE_PRODUCT_IMAGES_SHOW);
$effect_images       = Setting::get(RISING_BAMBOO_KIRKI_FIELD_WOOCOMMERCE_PRODUCT_IMAGE_EFFECT);
$custom_field_ignore = [ 'total_sales', 'woosw_count', 'woosw_add', 'woosw_remove' ];
$custom_field_exists = false;
if ( $show_custom_field ) {
	if ( empty($custom_fields) ) {
		$custom_fields = get_post_custom_keys($product->get_id());
	}
	foreach ( $custom_fields as $custom_field ) {
		if ( in_array($custom_field, $custom_field_ignore, true) || strpos($custom_field, '_') === 0 ) {
			continue;
		}
		if ( $product->get_meta($custom_field) ) {
			$custom_field_exists = true;
			break;
		}
	}
}

?>
<div class="item md:px-[15px] px-1.5 !flex justify-center h-auto">
	<div class="item-product relative rounded-[10px] w-full">
		<div class="relative z-[3] product-content h-full flex items-start flex-col rounded-2xl bg-white">
			<div class="thumbnail-container relative
				<?php
				echo wp_kses_post($effect_images);
				echo ( true === $product_images ) && \RisingBambooCore\Helper\Woocommerce::get_gallery_image($product, [ 600, 600 ]) ? ' hover-images ' : ' none-hover-images ';
				?>
			">
				<a class="relative block overflow-hidden" href="<?php echo esc_url($product->get_permalink()); ?>">
					<?php
					echo wp_kses(
						$product->get_image(
							[ 600, 600 ],
							[
								'class' => 'max-w-full w-full',
								'alt'   => esc_attr($product->get_name()),
							]
						),
						'rbb-kses'
					);
					if ( RbbCoreHelperWoocommerce::get_gallery_image($product, [ 600, 600 ]) ) {
						$second_image = RbbCoreHelperWoocommerce::get_gallery_image($product, [ 600, 600 ])[0];
						?>
					<img class="max-w-full image-cover absolute left-0 top-0 opacity-0" src="<?php echo esc_url($second_image->src); ?>" alt="<?php echo esc_attr__('Second image of ', 'gearnix') . esc_attr($product->get_name()); ?>"/>
						<?php
					}
					?>
			</a>
			<div class="product_button absolute md:right-6 right-2.5 md:top-6 top-2.5">
				<?php if ( $show_wishlist ) { ?>
					<?php echo Tag::wish_list_button($product); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<?php } ?>
				<?php
				if ( $show_quick_view ) {
					echo Tag::quick_view_button($product); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
				?>
				<?php
				if ( $show_compare ) {
					echo Tag::compare_button($product); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
				?>
				<?php
				if ( $show_add_to_cart ) {
					$args      = [];
					$text_cart = '';
					$icon      = Setting::get(RISING_BAMBOO_KIRKI_FIELD_WOOCOMMERCE_MINI_CART_ICON);
					if ( 'instock' !== $product->get_stock_status() ) {
						$text_cart = esc_html__('Out of stock', 'gearnix');
					} elseif ( $product instanceof WC_Product_Variable && $product->get_available_variations() ) {
						$text_cart = esc_html__('Select options', 'gearnix');
					} else {
						$text_cart = esc_html__('Add to Cart', 'gearnix');
					}
					if ( $icon ) {
						$args['cart-icon'] = '<div class="add-to-cart-icon relative text-center leading-10" data-tooltips="' . $text_cart . '">
					<i class="rbb-icon ' . $icon . '"></i>
					</div>';
					}
					woocommerce_template_loop_add_to_cart($args);
				}
				?>
			</div>
			<?php
			$countdown_date_to = $product->get_date_on_sale_to();
			if ( $countdown_date_to ) {
				$current_date         = new \WC_DateTime();
				$countdown_date_start = $product->get_date_on_sale_from() ?? $product->get_date_modified();
				if ( ( $current_date >= $countdown_date_start ) && ( $current_date <= $countdown_date_to ) ) {
					?>
					<div class="item-countdown absolute md:inset-x-[30px] inset-x-1 bottom-3.5 duration-300">
						<div class="rbb-countdown flex justify-center relative" data-countdown-date="<?php echo esc_attr($countdown_date_to->format('Y/m/d')); ?>">
						<div class="item-time"><span class="data-number">%D</span><span class="name-time"><?php echo esc_html__('Day%!H', 'gearnix'); ?></span></div>
						<div class="item-time"><span class="data-number">%H</span><span class="name-time"><?php echo esc_html__('Hour%!H', 'gearnix'); ?></span></div>
						<div class="item-time"><span class="data-number">%M</span><span class="name-time"><?php echo esc_html__('Min%!H', 'gearnix'); ?></span></div>
						<div class="item-time"><span class="data-number">%S</span><span class="name-time"><?php echo esc_html__('Secs', 'gearnix'); ?></span></div>
						</div>
					</div>
					<?php
				}
			}
			?>
		</div>
		<div class="product_info text-center w-full px-2.5 pt-5 pb-5 relative md:pb-16">
			<a href="<?php echo esc_url($product->get_permalink()); ?>" class="product_name line-clamp-2 block xl:text-base text-[0.8125rem] font-bold md:mb-6 mb-2"><?php echo wp_kses_post($product->get_name()); ?></a>
			<?php if ( $show_rating ) { ?>
				<div class="product_ratting text-amber-400 flex items-center justify-center my-3.5">
					<?php echo wc_get_rating_html($product->get_average_rating()); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<span class="ratting-count text-[#c3c3c3] font-medium ml-1 text-[10px]">(<?php echo esc_html($product->get_rating_count()); ?>)</span>
				</div>
			<?php } ?>
			<div class="product_info-bottom flex justify-center">
				<div class="product_price md:text-2xl text-sm font-semibold">
					<?php echo wp_kses($product->get_price_html(), 'rbb-kses'); ?>
				</div>
			</div>
			<div class="short_description hidden pt-[22px] mb-6 leading-6">
				<?php echo esc_html(wp_trim_words($product->get_short_description(), 28, '...')); ?>
			</div>
		</div>
		<?php if ( $show_stock || ( $show_custom_field && true === $custom_field_exists ) ) { ?>
				<div class="product_custom_field grid justify-center pt-7 pb-8 w-full border-t-[1px] border-[#e4e4e4]">
					<?php if ( $show_stock ) { ?>
						<div class="pb-2 text-xs font-normal leading-6">
							<?php 
							if ( $product->get_stock_status() === 'instock' ) {
								if ( $product->get_stock_quantity() ) {
									?>
									<span class="stock in-stock text-[#34ad5e]">
										<?php
										// translators: 1: Product stock.
										echo sprintf(esc_html__(' %s Products in stock', 'gearnix'), esc_html($product->get_stock_quantity()));
										?>
									</span>
								<?php } else { ?>
									<span class="stock in-stock text-[#34ad5e]">
										<?php
										echo sprintf(esc_html__('In Stock', 'gearnix'));
										?>
									</span>
								<?php } ?>
							<?php } else { ?>
								<span class="stock out-of-stock"><?php echo esc_html__('Out of stock', 'gearnix'); ?></span>
							<?php } ?>
						</div>
					<?php } ?>
					<?php
					if ( $show_custom_field ) {
						if ( empty($custom_fields) ) {
							$custom_fields = get_post_custom_keys($product->get_id());
						}
						$popular_keywords = Helper::get_popular_keyword_custom_fields();

						if ( ! empty($popular_keywords) ) {
							$common_fields = array_intersect($custom_fields, $popular_keywords);
						} else {
							$common_fields = $custom_fields;
						}
						if ( ! empty($common_fields) ) {
							foreach ( $common_fields as $custom_field ) {
								if ( in_array($custom_field, $custom_field_ignore, true) || strpos($custom_field, '_') === 0 ) {
									continue;
								}

								$meta_value = $product->get_meta($custom_field);
								if ( $meta_value ) {
									?>
									<div class="product_info_custom_field">
										<div class="data-item flex items-center">
											<i class="rbb-icon-check-9 pl-[3px]"></i>
											<span class="block ml-4 text-xs font-normal leading-6 text-[color:var(--rbb-general-body-text-color)]">
												<?php echo esc_html($meta_value); ?>
											</span>
										</div>
									</div>
									<?php
								}
							}
						}
					}
					?>
				</div>
			<?php } ?>
		</div>
	<div class="product-bottom-fade bg-white rounded-[10px]"></div>
</div>
</div>
