<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.7.0
 */

use RisingBambooTheme\App\App;

defined('ABSPATH') || exit;

do_action('woocommerce_before_edit_account_form'); ?>
<div class="rbb-account__address">
	<p class="rbb-account__address-top text-base border-t-[5px] rounded-b-lg px-6 sm:px-[30px] py-4 leading-[23px] font-bold"><?php echo esc_html__('My Account', 'gearnix'); ?></p>
	<form class="woocommerce-EditAccountForm edit-account mt-14" action=""
		  method="post" <?php do_action('woocommerce_edit_account_form_tag'); // phpcs:ignore WordPress.WhiteSpace.PrecisionAlignment.Found ?> >

		<?php do_action('woocommerce_edit_account_form_start'); // phpcs:ignore WordPress.WhiteSpace.PrecisionAlignment.Found ?>

		<div class="grid grid-cols-2 gap-8 mb-7">
			<div class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first col-span-1">
				<label class="rbb-account-detail__subtitle text-sm mb-4 font-semibold inline-block" for="account_first_name"><?php esc_html_e('First name', 'gearnix'); ?>&nbsp;<span
							class="required">*</span></label>
				<input type="text" class="rbb-account-detail__input px-4 outline-none h-12 w-full border text-sm font-bold rounded-lg woocommerce-Input woocommerce-Input--text input-text" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr($user->first_name); ?>"/>
			</div>
			<div class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last col-span-1">
				<label class="rbb-account-detail__subtitle text-sm mb-4 font-semibold inline-block" for="account_last_name"><?php esc_html_e('Last name', 'gearnix'); ?>&nbsp;<span class="required">*</span></label>
				<input type="text" class="rbb-account-detail__input px-4 outline-none h-12 w-full border text-sm font-bold rounded-lg woocommerce-Input woocommerce-Input--text input-text" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr($user->last_name); ?>"/>
			</div>
		</div>

		<div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide mb-7">
			<label class="rbb-account-detail__subtitle text-sm mb-4 font-semibold inline-block" for="account_display_name"><?php esc_html_e('Display name', 'gearnix'); ?>&nbsp;<span
						class="required">*</span></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text rbb-account-detail__input px-4 outline-none h-12 w-full border text-sm font-bold rounded-lg" name="account_display_name" id="account_display_name" value="<?php echo esc_attr($user->display_name); ?>"/>
			<p class="mt-4 text-xs"><span><?php esc_html_e('This will be how your name will be displayed in the account section and in reviews', 'gearnix'); ?></span></p>
		</div>

		<div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide mb-7">
			<label class="rbb-account-detail__subtitle text-sm mb-4 font-semibold inline-block" for="account_email"><?php esc_html_e('Email address', 'gearnix'); ?>&nbsp;<span class="required">*</span></label>
			<input type="email" class="woocommerce-Input woocommerce-Input--email input-text rbb-account-detail__input px-4 outline-none h-12 w-full border text-sm font-bold rounded-lg" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr($user->user_email); ?>"/>
		</div>
				<?php
						/**
						 * Hook where additional fields should be rendered.
						 *
						 * @since 8.7.0
						 */
						do_action('woocommerce_edit_account_form_fields');
				?>
		<fieldset>
			<legend class="rbb-account__header title uppercase font-extrabold text-lg pt-6 mb-11"><?php esc_html_e('Password change', 'gearnix'); ?></legend>
			<div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide mb-6">
				<label class="rbb-account-detail__subtitle text-sm mb-4 font-semibold inline-block" for="password_current"><?php esc_html_e('Current password (leave blank to leave unchanged)', 'gearnix'); ?></label>
				<input type="password" class="woocommerce-Input woocommerce-Input--password input-text rbb-account-detail__input px-4 outline-none border h-12 w-full text-sm font-bold rounded-lg" name="password_current" id="password_current" autocomplete="off"/>
			</div>
			<div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide mb-6">
				<label class="rbb-account-detail__subtitle text-sm mb-4 font-semibold inline-block" for="password_1"><?php esc_html_e('New password (leave blank to leave unchanged)', 'gearnix'); ?></label>
				<input type="password" class="woocommerce-Input woocommerce-Input--password input-text rbb-account-detail__input px-4 outline-none h-12 w-full border text-sm font-bold rounded-lg" name="password_1" id="password_1" autocomplete="off"/>
			</div>
			<div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label class="rbb-account-detail__subtitle text-sm mb-4 font-semibold inline-block" for="password_2"><?php esc_html_e('Confirm new password', 'gearnix'); ?></label>
				<input type="password" class="woocommerce-Input woocommerce-Input--password input-text rbb-account-detail__input px-4 outline-none h-12 w-full border text-sm font-bold rounded-lg" name="password_2" id="password_2" autocomplete="off"/>
			</div>
		</fieldset>

		<?php do_action('woocommerce_edit_account_form'); // phpcs:ignore WordPress.WhiteSpace.PrecisionAlignment.Found ?>

		<div>
			<?php wp_nonce_field('save_account_details', 'save-account-details-nonce'); ?>
			<button type="submit" class="woocommerce-Button button rbb-account-detail__btn h-16 px-12 text-white text-sm font-extrabold uppercase rounded-lg" name="save_account_details" value="<?php esc_attr_e('Save changes', 'gearnix'); ?>"><?php esc_html_e('Save changes', 'gearnix'); ?></button>
			<input type="hidden" name="action" value="save_account_details"/>
		</div>

		<?php do_action('woocommerce_edit_account_form_end'); // phpcs:ignore WordPress.WhiteSpace.PrecisionAlignment.Found ?>
	</form>
</div>
<?php do_action('woocommerce_after_edit_account_form'); // phpcs:ignore WordPress.WhiteSpace.PrecisionAlignment.Found ?>
