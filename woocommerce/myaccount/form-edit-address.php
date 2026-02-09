<?php
/**
 * Edit address form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-address.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

use RisingBambooTheme\App\App;

defined('ABSPATH') || exit;

$page_title = ( 'billing' === $load_address ) ? esc_html__('Billing address', 'gearnix') : esc_html__('Shipping address', 'gearnix');

do_action('woocommerce_before_edit_account_address_form'); ?>

<?php if ( ! $load_address ) : ?>
	<?php wc_get_template('myaccount/my-address.php'); ?>
<?php else : ?>
<div class="rbb-account__address">
	<p class="rbb-account__address-top text-base border-t-[5px] rounded-b-lg sm:px-[30px] py-4 leading-[23px] font-bold">
        <?php echo apply_filters( 'woocommerce_my_account_edit_address_title', $page_title, $load_address ); ?><?php // @codingStandardsIgnoreLine ?>
	</p>
	<form method="post" class="mt-14">
		<div class="woocommerce-address-fields">
			<?php do_action("woocommerce_before_edit_address_form_{$load_address}"); ?>

			<div class="woocommerce-address-fields__field-wrapper woocommerce-form-row">
				<?php
				foreach ( $address as $key => $field ) {
					woocommerce_form_field($key, $field, wc_get_post_data_by_key($key, $field['value']));
				}
				?>
			</div>

			<?php do_action("woocommerce_after_edit_address_form_{$load_address}"); ?>
			<button type="submit" class="rbb-address-more__btn woocommerce-Button button px-12 h-[50px] font-extrabold text-white text-[10px] uppercase rounded-lg" name="save_address" value="<?php esc_attr_e('Save address', 'gearnix'); ?>"><?php esc_html_e('Save address', 'gearnix'); ?></button>
			<?php wp_nonce_field('woocommerce-edit_address', 'woocommerce-edit-address-nonce'); ?>
			<input type="hidden" name="action" value="edit_address" />
		</div>
	</form>
</div>

<?php endif; ?>

<?php do_action('woocommerce_after_edit_account_address_form'); ?>
