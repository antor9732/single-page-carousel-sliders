<?php
/**
 * Default image layout.
 *
 * @package RisingBambooTheme
 * @version 1.0.0
 * @since 1.0.0
 */

use RisingBambooTheme\Helper\Setting;

$thumbnail_position = Setting::get(RISING_BAMBOO_KIRKI_FIELD_WOOCOMMERCE_PRODUCT_DETAIL_IMAGE_THUMBNAIL_POSITION);
$thumbnail_number   = (int) ( Setting::get(RISING_BAMBOO_KIRKI_FIELD_WOOCOMMERCE_PRODUCT_DETAIL_IMAGE_THUMBNAIL_NUMBER) ?? 3 );
?>

<div class="rbb-product-single-image-default sticky top-24 col-span-1 <?php echo esc_attr(implode(' ', array_map('sanitize_html_class', $args['wrapper_classes']))); ?>">
	<div class="product-single__sticky xl:overflow-hidden <?php echo ( 'bottom' !== $thumbnail_position ) ? 'xl:flex' : ''; ?> <?php echo ( 'left' === $thumbnail_position ) ? 'flex-row-reverse' : ''; ?> <?php echo ( 'top' === $thumbnail_position ) ? 'flex-col-reverse' : ''; ?>">
		<div id="rbb-gallery-lightbox" class="overflow-hidden rounded-lg">
			<div class="rbb-slick-product-gallery flex" data-slick='{
					"dots": false,
					"arrows": true,
					"slidesToShow": 1,
					"fade": false,
					"adaptiveHeight": true,
					"infinite": true,
					"useTransform": true,
					"speed": 500,
					"cssEase": "cubic-bezier(0.77, 0, 0.18, 1)",
					"draggable": "draggable"
			}'>
				<?php
				foreach ( $args['attachment_ids'] as $attachment_id ) {
					$attachment_props = wc_get_product_attachment_props($attachment_id, $post);
					if ( ! $attachment_props['url'] ) {
						continue;
					}
					?>
					<div class="rbb-slick-product-gallery__image">
						<a href="<?php echo esc_url($attachment_props['url']); ?>" data-image-id="<?php echo esc_attr($attachment_id); ?>" data-pswp-width="1600" data-pswp-height="1600" target="_blank">
							<img src="<?php echo esc_url($attachment_props['url']); ?>" alt="<?php echo esc_attr($attachment_props['alt']); ?>" class="zoomImg max-w-full">
						</a>
					</div>
				<?php } ?>
			</div>
		</div>
		<div class="rbb-product-thumbs -mx-[7px]
			<?php echo ( 'left' === $thumbnail_position ) ? 'flex-none xl:w-[107px] xl:-my-2 xl:mr-[15px] xl:ml-0 xl:pt-0 pt-2' : ''; ?>
			<?php echo ( 'right' === $thumbnail_position ) ? 'flex-none xl:w-[107px] xl:-my-[7px] xl:ml-[15px] xl:mr-0 xl:pt-0 pt-[15px]' : ''; ?>
			<?php echo ( 'top' === $thumbnail_position ) ? 'xl:pb-[10px] pb-0 xl:pt-0 pt-[15px]' : ''; ?>
			<?php echo ( 'bottom' === $thumbnail_position ) ? 'pt-[15px]' : ''; ?>
		 ">
			<div class="rbb-slick-product-thumb <?php echo ( 'top' === $thumbnail_position || 'bottom' === $thumbnail_position ) ? 'flex items_2' : ''; ?>" data-slick='{
				"dots": false,
				"arrows": false,
				"slidesToShow": <?php echo esc_attr($thumbnail_number); ?>,
				"fade": false,
				"vertical" : <?php echo ( 'left' === $thumbnail_position || 'right' === $thumbnail_position ) ? 'true' : 'false'; ?>,
				"verticalSwiping":<?php echo ( 'left' === $thumbnail_position || 'right' === $thumbnail_position ) ? 'true' : 'false'; ?>,
				"infinite": true,
				"useTransform": false,
				"speed": 500,
				"cssEase": "cubic-bezier(0.77, 0, 0.18, 1)",
				"draggable": "draggable",
				"rtl": <?php echo ( 'left' === $thumbnail_position || 'right' === $thumbnail_position ) ? 'false' : 'true'; ?>,
				"responsive": [
					{
						"breakpoint": 1310,
						"settings": {
							"vertical":<?php echo ( 'left' === $thumbnail_position || 'right' === $thumbnail_position ) ? 'true' : 'false'; ?>,
							"verticalSwiping": <?php echo ( 'left' === $thumbnail_position || 'right' === $thumbnail_position ) ? 'true' : 'false'; ?>,
							"slidesToShow": 4,
							"slidesToScroll": 4
						}
					},
					{
						"breakpoint": 992,
						"settings": {
							"vertical":false,
							"slidesToShow": 3,
							"slidesToScroll": 3
							}
						},
					{
						"breakpoint": 768,
						"settings": {
							"vertical":false,
							"slidesToShow": 4,
							"slidesToScroll": 2
						}
					},
					{
						"breakpoint": 576,
						"settings": {
							"vertical":false,
							"slidesToShow": 4,
							"slidesToScroll": 1
						}
					}
				]
			}'
			>
				<?php
				foreach ( $args['attachment_ids'] as $attachment_id ) {
					$attachment_props = wc_get_product_attachment_props($attachment_id, $post);
					?>
					<div class="item <?php echo ( 'left' === $thumbnail_position || 'right' === $thumbnail_position ) ? 'xl:py-[7px] xl:px-0 px-2' : ' pl-[7px] pr-2'; ?>">
						<div class="thumbnail overflow-hidden rounded-lg border-slate-400 block w-full">
							<img data-image-id="<?php echo esc_attr($attachment_id); ?>" src="<?php echo esc_url($attachment_props['gallery_thumbnail_src']); ?>" alt="<?php echo esc_attr($attachment_props['alt']); ?>" class="rounded-lg w-full">
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
