<?php
/**
 * Rbb Tabs.
 *
 * @package RisingBambooTheme
 */

$rbb_tabs = apply_filters('rbb_woocommerce_after_single_product_tabs', []);
uasort(
	$rbb_tabs,
	static function ( $a, $b ) {
		$priority_a = $a['priority'] ?? 10;
		$priority_b = $b['priority'] ?? 10;
		return $priority_a <=> $priority_b;
	}
);
?>
<?php if ( ! empty($rbb_tabs) ) { ?>
	<div class="pb-[90px]">
		<div class="tabs-product relative">
			<ul class="whitespace-nowrap title_heading overflow-x-auto md:overflow-x-visible flex lg:absolute relative top-0 left-0 z-10" id="tabs-nav">
				<?php
				foreach ( $rbb_tabs as $key => $rbb_tab ) {
					?>
					<li class="nav-item tab-a relative cursor-pointer font-extrabold text-2xl mr-[60px] transition ease-out duration-200" data-id="<?php echo esc_attr($key); ?>">
						<?php echo wp_kses_post($rbb_tab['title']); ?>
					</li>
					<?php
				}
				?>
			</ul>
			<div id="tabs-content">
				<?php
				foreach ( $rbb_tabs as $key => $rbb_tab ) {
					?>
					<div class="tab-content ease-out duration-300" data-id="<?php echo esc_attr($key); ?>" >
						<?php
						if ( isset($rbb_tab['callback']) ) {
							call_user_func($rbb_tab['callback'], $key, $rbb_tab);
						}
						?>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
<?php } ?>
