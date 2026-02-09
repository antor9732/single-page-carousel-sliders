<?php
/**
 * Ask a question.
 *
 * @package RisingBambooTheme.
 */

use RisingBambooTheme\Helper\Setting;

$contact_form_title = Setting::get(RISING_BAMBOO_KIRKI_FIELD_WOOCOMMERCE_PRODUCT_DETAIL_SUMMARY_CONTACT_TEXT);
$contact_form_id    = Setting::get(RISING_BAMBOO_KIRKI_FIELD_WOOCOMMERCE_PRODUCT_DETAIL_SUMMARY_CONTACT_FORM);
$contact_form       = get_post($contact_form_id);
$outside            = Setting::get(RISING_BAMBOO_KIRKI_FIELD_COMPONENT_MODAL_CLICK_OUTSIDE_CLOSE);
$modal_effect       = Setting::get(RISING_BAMBOO_KIRKI_FIELD_COMPONENT_MODAL_EFFECT);
$backdrop_filter    = Setting::get(RISING_BAMBOO_KIRKI_FIELD_COMPONENT_MODAL_BACKDROP_FILTER);
$classes            = [ 'hidden' ];
$classes[]          = ( true === $backdrop_filter ) ? 'backdrop' : 'backdrop-none';
$classes[]          = ( false === $outside ) ? 'outside-modal' : '';
$class_string       = implode(' ', array_filter($classes));
?>

<div class="ask-questions text-xs">
	<div class="leading-6 flex items-center">
		<i class="rbb-icon-question-1 pr-[14px] text-base"></i>
		<a href="javascript:void(0)" onclick="RisingBambooModal.modal('#rbb-contact-form', event)"><?php echo esc_html($contact_form_title); ?></a>
	</div>
	<div id="rbb-contact-form" class="<?php echo esc_attr($class_string); ?>" data-modal-animation="<?php echo esc_attr($modal_effect); ?>">
		<?php echo do_shortcode('[contact-form-7 id="' . $contact_form->ID . '" title="' . $contact_form->post_title . '"]'); ?>
	</div>
</div>
