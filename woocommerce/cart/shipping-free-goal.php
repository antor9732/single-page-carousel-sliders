<?php
/**
 * Shipping free goal template.
 *
 * @package RisingBambooCore
 * @since 1.0.0
 * @version 1.0.0
 */

use RisingBambooTheme\App\App;
?>

<div class="rbb-free-ship-goal w-full pt-[2px] pb-10 <?php echo ( ! $amount_left ) ? 'free-ship-eligible' : esc_attr($percent_class); ?> <?php echo esc_attr(str_replace('_', '-', $position)); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>">
	<div class="rbb-free-ship-goal-text text-left <?php echo ( 100 === $percent ) ? 'mb-9' : 'mb-10'; ?>">
		<?php if ( $amount_left ) { ?>
			<span class="text-[13px] amount-left pb-1">
				<?php
				/* translators: 1: Product price */
				echo sprintf(__('Buy <strong>%s</strong> more to get <strong>Free Shipping</strong>', 'gearnix'), wc_price($min_amount - $amount)); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				?>
			</span>
		<?php } else { ?>
			<span class="text-[#1b9730] text-[13px] font-medium flex items-center"><?php echo wp_kses_post(__('Congratulations! You’ve got<strong class="uppercase pl-1">Free Shipping</strong>', 'gearnix')); ?><i class="rbb-icon-delivery-11 text-[30px] pl-[5px]"></i></span>
		<?php } ?>
	</div>
	<div class="rbb-free-ship-goal-process-bar w-full bg-gray-200 h-[6px] rounded">
		<div class="progress-bar h-[6px] relative rounded" title="<?php echo esc_attr($percent) . '%'; ?>" style=" transition: width 2s; width: <?php echo esc_attr($percent); ?>%">
			<?php if ( 100 !== $percent ) { ?>
				<div class="progress-mark absolute right-0 bottom-[1px] text-center w-[32px] h-[32px] flex justify-center items-center">
					<i class="rbb-icon-delivery-11 text-[30px] pl-[5px]"></i>
				</div>
			<?php } else { ?>
				<div class="progress-mark absolute right-0 top-2/4 text-center -translate-y-2/4 flex justify-center items-center bg-transparent">
					<i aria-hidden="true" class="icon_check rbb-icon-check-1 text-[8px] w-5 h-5 leading-[20px] text-white rounded-full"></i>
				</div>
			<?php } ?>
		</div>
	</div>
</div>
