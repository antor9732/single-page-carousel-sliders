<?php
/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     9.7.0
 */

use RisingBambooCore\Helper\Helper as RbbCoreHelper;
use RisingBambooTheme\App\App;

if ( ! defined('ABSPATH') ) {
	exit;
}
$query_string = RbbCoreHelper::get_query_string();
parse_str($query_string, $params);
$query_string = '?' . $query_string;
?>
<div class="ml-auto mr-0">
	<div class="woocommerce-ordering pwb-dropdown dropdown relative">
		<div class="rbb-accordion-title flex h-[46px] leading-10 min-w-[165px] rounded-[4px] items-center relative cursor-pointer" data-sortby-filter data-toggle="dropdown">
			<span class="sort-by__label text-xs font-semibold text-[color:var(--rbb-general-link-color)]"><?php esc_html_e('Shop order', 'gearnix'); ?></span>
			<i class="rbb-icon-direction-42 text-[10px] text-[#222] font-bold pl-5 ml-auto mr-0"></i>
		</div>
		<div class="rbb-accordion-content bg-white absolute hidden z-10 left-auto right-0 min-w-[250px] pt-4 px-4 rounded-b-[10px] rounded-tl-[10px] -mt-[1px] shadow-[10px_10px_10px_rgba(0,0,0,0.1)] border border-[#e4e4e4]">
			<?php foreach ( $catalog_orderby_options as $oder_by_id => $name ) : ?>
				<div class="item duration-300 ease-out mb-[15px] <?php echo esc_attr(( $orderby === $oder_by_id ) ? 'active' : ''); ?>" data-sortby-item data-value="<?php echo esc_attr($name); ?>" >
					<a class="flex duration-300" href="<?php echo esc_url(add_query_arg('orderby', $oder_by_id, $query_string)); ?>">
						<span class="w-5 h-5 rounded-full border border-[color:var(--rbb-general-button-bg-color)] mr-[15px] duration-150"></span>
						<?php echo esc_attr($name); ?>
					</a>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
