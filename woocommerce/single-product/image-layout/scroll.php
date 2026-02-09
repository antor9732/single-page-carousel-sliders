<?php
/**
 * Default image layout.
 *
 * @package RisingBambooTheme
 * @version 1.0.0
 * @since 1.0.0
 */

use RisingBambooTheme\Helper\Setting;

$thumbnail_position = Setting::get(RISING_BAMBOO_KIRKI_FIELD_WOOCOMMERCE_PRODUCT_DETAIL_IMAGE_SCROLL_THUMBNAIL_POSITION);
$thumbnail_number   = (int) ( Setting::get(RISING_BAMBOO_KIRKI_FIELD_WOOCOMMERCE_PRODUCT_DETAIL_IMAGE_THUMBNAIL_NUMBER) ?? 3 );
?>

<div class="rbb-product-single-image-scroll col-span-1 <?php echo esc_attr(implode(' ', array_map('sanitize_html_class', $args['wrapper_classes']))); ?>">
	<div class="lg:flex <?php echo ( 'left' === $thumbnail_position ) ? 'flex-row-reverse' : ''; ?>">
		<div id="rbb-gallery-lightbox" class="overflow-hidden">
			<div class="rbb-product-gallery" >
				<?php
				$i = 1;
				foreach ( $args['attachment_ids'] as $attachment_id ) {
					$attachment_props = wc_get_product_attachment_props($attachment_id, $post);
					if ( ! $attachment_props['url'] ) {
						continue;
					}
					?>
					<div class="rbb-product-gallery__image item rounded-lg overflow-hidden mb-[15px] <?php echo ( 1 === $i ) ? 'act' : ''; ?>" data-position="<?php echo esc_attr($i); ?>">
						<a href="<?php echo esc_url($attachment_props['url']); ?>" data-image-id="<?php echo esc_attr($attachment_id); ?>" data-pswp-width="1600" data-pswp-height="1600" target="_blank">
							<img src="<?php echo esc_url($attachment_props['url']); ?>" alt="<?php echo esc_attr($attachment_props['alt']); ?>" class="zoomImg max-w-full">
						</a>
					</div>
				<?php $i++; } ?>
			</div>
		</div>
		<div class="rbb-product-thumbs -mx-[7px] lg:w-[105px] flex-none -my-[7.5px] lg:pt-0 pt-[8px] lg:mx-0
			<?php echo ( 'left' === $thumbnail_position ) ? 'lg:mr-[15px]' : ''; ?>
			<?php echo ( 'right' === $thumbnail_position ) ? 'lg:ml-[15px]' : ''; ?>
		">
			<div class="rbb-slick-product-thumb product-single__sticky" data-slick='{
				"dots": false,
				"arrows": false,
				"slidesToShow": <?php echo esc_attr($thumbnail_number); ?>,
				"slidesToScroll": <?php echo esc_attr($thumbnail_number); ?>,
				"fade": false,
				"vertical" : true,
				"verticalSwiping": true,
				"loop" : true,
				"adaptiveHeight": true,
				"infinite": false,
				"useTransform": true,
				"speed": 500,
				"cssEase": "cubic-bezier(0.77, 0, 0.18, 1)",
				"draggable": "draggable",
				"rtl": false,
				"responsive": [
					{
						"breakpoint": 1200,
						"settings": {
							"slidesToShow": 4,
							"slidesToScroll": 4
						}
					},
					{
						"breakpoint": 992,
						"settings": {
							"vertical" : false,
							"slidesToShow": 3,
							"slidesToScroll": 3
							}
						},
					{
						"breakpoint": 768,
						"settings": {
							"vertical" : false,
							"slidesToShow": 2,
							"slidesToScroll": 2
						}
					},
					{
						"breakpoint": 576,
						"settings": {
							"vertical" : false,
							"slidesToShow": 4,
							"slidesToScroll": 1
						}
					}
				]
			}'
			>
				<?php
				$j = 1;
				foreach ( $args['attachment_ids'] as $attachment_id ) {
					$attachment_props = wc_get_product_attachment_props($attachment_id, $post);
					?>
					<div class="item <?php echo ( 1 === $j ) ? 'active' : ''; ?> <?php echo ( 'left' === $thumbnail_position || 'right' === $thumbnail_position ) ? 'lg:py-[7.5px]  lg:px-0 px-[7.5px]' : 'px-4'; ?>" data-position="<?php echo esc_attr($j); ?>">
						<div class="thumbnail overflow-hidden rounded-lg border-slate-400">
							<div class="w-full">
								<img data-image-id="<?php echo esc_attr($attachment_id); ?>" src="<?php echo esc_url($attachment_props['gallery_thumbnail_src']); ?>" alt="<?php echo esc_attr($attachment_props['alt']); ?>" class="max-w-full">
							</div>
						</div>
					</div>
				<?php $j++; } ?>
			</div>
		</div>
	</div>
</div>
