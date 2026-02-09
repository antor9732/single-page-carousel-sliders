<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.1
 */

use RisingBambooTheme\App\App;
use RisingBambooTheme\Helper\Setting;

defined('ABSPATH') || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists('wc_get_gallery_image_html') ) {
	return;
}

global $product;

$attachment_ids = $product->get_gallery_image_ids();
$thumbnail_id   = (int) $product->get_image_id();
if ( $thumbnail_id ) {
	array_unshift($attachment_ids, $thumbnail_id);
}

if ( empty($attachment_ids) ) {
	echo apply_filters('woocommerce_single_product_image_html', sprintf('<img src="%s" alt="%s" />', wc_placeholder_img_src(), esc_attr__('Placeholder', 'gearnix')), $product->get_id());
	return;
}

$wrapper_classes = apply_filters(
	'rbb_theme_single_product_image_gallery_classes',
	[
		'product-single__photos',
	]
);

?>
<div class="rbb-product_quick-view overflow-hidden max-h-[460px]">
	<div class="rbb-slick-product_quick-view" data-slick='{
		"dots": false,
		"nav": true,
		"slidesToShow": 1,
		"fade": false,
		"adaptiveHeight": true,
		"infinite": false
	}'>
	<?php
	foreach ( $attachment_ids as $attachment_id ) {
		$attachment_props = wc_get_product_attachment_props($attachment_id, $post);
		if ( ! $attachment_props['url'] ) {
			continue;
		}
		?>
		<div class="rbb-slick-product-gallery__image">
			<img src="<?php echo esc_url($attachment_props['url']); ?>" width="<?php echo esc_attr($attachment_props['src_w']); ?>" height="100%" alt="<?php echo wp_kses_post($product->get_name()); ?>" class="max-w-full">
		</div>
	<?php } ?>
	</div>
</div>
