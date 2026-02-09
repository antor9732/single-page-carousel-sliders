<?php
/**
 * Login form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     9.2.0
 */

use RisingBambooTheme\App\App;
if ( ! defined('ABSPATH') ) {
	exit; // Exit if accessed directly.
}

if ( is_user_logged_in() ) {
	return;
}

?>
<form class="woocommerce-form woocommerce-form-login login <?php echo esc_attr($hidden ? 'hidden' : ''); ?>" method="post">
	<?php do_action('woocommerce_login_form_start'); ?>
	<div class="text-xs">
		<?php
		if ( $message ) {
			echo wpautop(wptexturize($message)); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		?>
	</div>
	<p class="form-row form-row-first mt-6">
		<input type="text" placeholder="<?php esc_attr_e('Username or email*', 'gearnix'); ?>" class="input-text rbb-checkout__input w-full text-center rounded mb-2.5 h-12 px-5 border outline-none" name="username" id="username" autocomplete="username" />
	</p>
	<p class="form-row form-row-last">
		<input placeholder="<?php esc_attr_e('Password*', 'gearnix'); ?>" class="input-text rbb-checkout__input w-full text-center rounded h-12 px-5 border outline-none" type="password" name="password" id="password" autocomplete="current-password" />
	</p>
	<div class="clear"></div>
	<?php do_action('woocommerce_login_form'); ?>
	<div class="form-row flex py-8">
		<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme flex items-center rbb-checkout__remember mr-3">
			<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" />
			<span></span>
		</label>
		<span class="rbb-checkout__subtitle mr-10"><?php esc_html_e('Remember me', 'gearnix'); ?></span>
		<a class="lost_password" href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php esc_html_e('Lost your password?', 'gearnix'); ?></a>
	</div>

	<?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
	<input type="hidden" name="redirect" value="<?php echo esc_url($redirect); ?>" />
	<button type="submit" class="woocommerce-button button woocommerce-form-login__submit rbb-checkout__btn w-full rounded mb-7 w-full h-12 text-center text-white" name="login" value="<?php esc_attr_e('Login', 'gearnix'); ?>"><?php esc_html_e('Login', 'gearnix'); ?></button>

	<div class="clear"></div>

	<?php do_action('woocommerce_login_form_end'); ?>

</form>
