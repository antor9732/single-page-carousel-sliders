<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue Slick Carousel
 */
function enqueue_releted_carousel_assets()
{
    wp_enqueue_style('slick-carousel', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
    wp_enqueue_style('slick-theme', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css');

    wp_enqueue_script('jquery');
    wp_enqueue_script('slick-carousel', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', ['jquery'], null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_releted_carousel_assets');


/**
 * Display Related Products Slider
 */
add_action('woocommerce_after_single_product_summary', 'display_related_products_slick');

function display_related_products_slick()
{
    global $product;

    if (!$product) return;

    $related_products = wc_get_related_products($product->get_id(), 50);
    if (empty($related_products)) return;

    $products = wc_get_products([
        'include' => $related_products,
        'limit'   => 50,
    ]);

    if (empty($products)) return;

    /*------------------------------
     KEEP THIS EXACT DUPLICATION CODE
    ------------------------------*/
    $original_count = count($products);
    $min_products = 4; // Desktop default

    // Ensure minimum products
    if ($original_count < $min_products) {
        $original_products = $products;
        while (count($products) < $min_products) {
            foreach ($original_products as $prod) {
                if (count($products) < $min_products) {
                    $products[] = $prod;
                }
            }
        }
        $original_count = count($products);
    }

    // Duplicate products for infinite scroll
    $products = array_merge($products, $products);
    // ------------------------------

?>
    <section class="related-products-slider-section" style="margin-top: 40px;">
        <h2 style="font-size: 24px; margin-bottom: 20px; font-weight: 600;">Related Products</h2>

        <div class="releted-carousel-slider" id="relatedProductsCarousel">
            <?php foreach ($products as $p) : ?>
                <div class="carousel-slide">
                    <div class="product-card">
                        <a href="<?php echo esc_url($p->get_permalink()); ?>" class="rp-link">
                            <div class="product-image">
                                <?php echo $p->get_image('woocommerce_thumbnail'); ?>
                            </div>
                            <!-- <h3 class="product-title">
                                <//?php echo esc_html($p->get_name()); ?>
                            </h3>
                            <div class="product-price">
                                <//?php echo $p->get_price_html(); ?>
                            </div> -->
                        </a>
                        <!-- <div class="product-action">
                            <//?php woocommerce_template_loop_add_to_cart([
                                'product' => $p
                            ]); ?>
                        </div> -->
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <style>
        .carousel-slide {
            padding: 10px;
        }

        .product-card {
            background-image: linear-gradient(180deg, #F162BA0D 0%, #8B396B66 100%);
            padding: 15px;
            border-radius: 8px;
            /* border: 1px solid #250e3d; */
        }

        .releted-carousel-slider .slick-arrow {
            background-image: linear-gradient(90deg, #fcb043, #f5ef33) !important;
            border: 1px solid linear-gradient(90deg, #fcb043, #f5ef33) !important;
        }
        .releted-carousel-slider .slick-arrow:hover {
            background-image: linear-gradient(90deg, #250e3d, #8B396B66) !important;
            border: 1px solid linear-gradient(90deg, #fcb043, #f5ef33) !important;
        }

        .product-image img {
            width: 100%;
            border-radius: 6px;
        }
    </style>

<?php
}


/**
 * Inline Slick Initialization (Your Version Kept)
 */
add_action('wp_enqueue_scripts', function () {
    $inline_js = "
        jQuery(document).ready(function($){
            if ($('.releted-carousel-slider').length) {
                $('.releted-carousel-slider').slick({
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 3000,
                    speed: 600,
                    infinite: true,
                    arrows: true,
                    dots: true,
                    adaptiveHeight: true,
                    responsive: [
                        { breakpoint: 1166, settings: { slidesToShow: 3 } },
                        { breakpoint: 767, settings: { slidesToShow: 2 } },
                        { breakpoint: 499, settings: { slidesToShow: 1 } }
                    ]
                });
            }
        });
    ";

    wp_add_inline_script('slick-carousel', $inline_js);
});
