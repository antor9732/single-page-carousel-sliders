<?php
/**
 * Default image layout.
 *
 * @package RisingBambooTheme
 * @version 1.0.0
 * @since 1.0.0
 */

use RisingBambooTheme\Helper\Setting;
?>

<div class="rbb-product-single-image-slider col-span-1 <?php echo esc_attr(implode(' ', array_map('sanitize_html_class', $args['wrapper_classes']))); ?>">
	<div class="product-single__sticky -mx-[15px]">
		<div id="rbb-gallery-lightbox" class="pb-14">
			<div class="rbb-slick-product-gallery flex" data-slick='{
					"dots": true,
					"arrows": false,
					"slidesToShow": 2,
					"slidesToScroll": 2,
					"fade": false,
					"adaptiveHeight": true,
					"infinite": true,
					"useTransform": true,
					"speed": 500,
					"cssEase": "cubic-bezier(0.77, 0, 0.18, 1)",
					"draggable": "draggable",
					"responsive": [
					{
						"breakpoint": 1200,
						"settings": {
							"slidesToShow": 2,
							"slidesToScroll": 2
						}
					},
					{
						"breakpoint": 992,
						"settings": {
							"slidesToShow": 2,
							"slidesToScroll": 2
							}
						},
					{
						"breakpoint": 768,
						"settings": {
							"slidesToShow": 1,
							"slidesToScroll": 1
						}
					},
					{
						"breakpoint": 576,
						"settings": {
							"slidesToShow": 1,
							"slidesToScroll": 1,
							"dots": false
						}
					}
				]
			}'>
				<?php

				foreach ( $args['attachment_ids'] as $attachment_id ) {
					$attachment_props = wc_get_product_attachment_props($attachment_id, $post);
					$attachment_alt   = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
					if ( ! $attachment_props['url'] ) {
						continue;
					}
					?>
					<div class="rbb-slick-product-gallery__image">
						<a data-image-id="<?php echo esc_attr($attachment_id); ?>" href="<?php echo esc_url($attachment_props['url']); ?>" data-pswp-width="1600" data-pswp-height="1600" target="_blank">
							<img src="<?php echo esc_url($attachment_props['url']); ?>" alt="<?php echo esc_attr($attachment_alt); ?>" class="zoomImg max-w-full">
						</a>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
