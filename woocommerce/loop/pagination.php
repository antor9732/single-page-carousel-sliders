<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/pagination.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

use RisingBambooTheme\App\App;
use RisingBambooTheme\Helper\Setting;
if ( ! defined('ABSPATH') ) {
	exit;
}

$pagination_type = Setting::get(RISING_BAMBOO_KIRKI_SECTION_WOOCOMMERCE_PRODUCT_CATALOG_PAGINATION, 'pagination');
$total           = $total ?? wc_get_loop_prop('total_pages');
if ( $total <= 1 ) {
	return;
}
$current          = $current ?? wc_get_loop_prop('current_page');
$base             = $base ?? esc_url_raw(str_replace(999999999, '%#%', remove_query_arg('add-to-cart', get_pagenum_link(999999999, false))));
$format           = $format ?? '';
$pagination_count = $total ?? wc_get_loop_prop('total_pages');
$post_per_page    = get_query_var('posts_per_page');
$result_count     = wc_get_loop_prop('total');
?>
<nav class="woocommerce-pagination rbb-woo-pagination text-center" data-type="<?php echo esc_attr($pagination_type); ?>">
	<?php
	if ( in_array($pagination_type, [ 'load_more', 'infinity' ], true) ) {
		$url            = str_replace('%#%', $current + 1, $base);
		$pagination_bar = ( $current / $pagination_count ) * 100;
		?>
		<div class="pagination_count mb-[15px] pt-6 text-xs">
			<?php
			$last = $post_per_page * $current;
			if ( (int) $current === (int) $total ) {
				$last = $result_count;
			}
			// translators: %1$s: Number of products being shown. %2$s: Total number of products.
			echo sprintf(
				wp_kses(
				/* translators: %1$s: Number of products being shown. %2$s: Total number of products. */
					__('Showing %1$s of %2$s products', 'gearnix'),
					[ 'strong' => [] ] // Allow strong tags for numbers.
				),
				'<strong>' . esc_html($last) . '</strong>',
				'<strong>' . esc_html($result_count) . '</strong>'
			);
			?>
		</div>
		<div class="pagination_bar bg-[#ebebeb] relative h-[7px] rounded-[7px] mx-auto mb-[30px] max-w-[250px]">
			<span class="progress bg-[color:var(--rbb-general-secondary-color)] absolute left-0 h-[7px] top-0 rounded-[7px]" style="width: <?php echo esc_attr($pagination_bar); ?>%;"></span>
		</div>
		<?php
		if ( $current < $total ) {
			?>
			<button
				class="text-center h-12 px-5 rounded-[4px] min-w-[250px] rbb-load-more duration-300 text-[color:var(--rbb-general-heading-color)] hover:text-white bg-[#ebebeb] hover:bg-[color:var(--rbb-general-secondary-color)] text-xs <?php echo ( 'infinity' === $pagination_type ) ? 'hidden' : ''; ?>"
				data-url="<?php echo esc_url($url); ?>"><?php echo esc_html__('Load more items', 'gearnix'); ?>

			</button>
			<?php
		}
	} else {
		//phpcs:ignore
		echo paginate_links(
			apply_filters(
                // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
				'woocommerce_pagination_args',
				[ // WPCS: XSS ok.
					'base'      => $base,
					'format'    => $format,
					'add_args'  => false,
					'current'   => max(1, $current),
					'total'     => $total,
					'prev_text' => is_rtl() ? '&rarr;' : '&larr;',
					'next_text' => is_rtl() ? '&larr;' : '&rarr;',
					'type'      => 'list',
					'end_size'  => 3,
					'mid_size'  => 3,
				]
			)
		);
	}
	?>
</nav>
