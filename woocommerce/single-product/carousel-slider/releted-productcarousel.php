<?php

/**
 * Related Products Carousel
 *
 * Displays related products as a responsive carousel
 * on the single product page using
 * `woocommerce_after_single_product_summary`.
 *
 * Requires custom CSS & JS for slider functionality.
 *
 * @package WooCommerce
 * @version 9.7.0
 */

if (! defined('ABSPATH')) {
    exit;
}

add_action('woocommerce_after_single_product_summary', 'display_related_products_slider');

function display_related_products_slider()
{
    global $product;

    if (! $product) {
        return;
    }

    // Get related products
    $related_products = wc_get_related_products($product->get_id(), 50);

    if (empty($related_products)) {
        return;
    }

    $products = wc_get_products([
        'include' => $related_products,
        'limit'   => 50,
    ]);

    if (empty($products)) {
        return;
    }

    $products = array_values($products);
    $original_count = count($products);

    $min_products = 4; // Desktop default
    // Check if we need to duplicate products for infinite scroll
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

?>
    <section class="related-products-slider-section" style="margin-top: 40px;">
        <h2 style="font-size: 24px; margin-bottom: 20px; font-weight: 600;">Related Products</h2>

        <div class="related-products-carousel-wrapper" style="position: relative; overflow: hidden; padding: 0 60px;" data-original-count="<?php echo absint($original_count); ?>">
            <div class="related-products-carousel" id="relatedProductsCarousel" style="display: flex; gap: 15px; transition: transform 0.5s ease; overflow: visible;">
                <?php foreach ($products as $p) : ?>
                    <div class="carousel-slide" style="margin-right: 15px;">
                        <div class="product-card">

                            <a href="<?php echo esc_url($p->get_permalink()); ?>" class="rp-link">
                                <div class="product-image">
                                    <?php echo $p->get_image('woocommerce_thumbnail'); ?>
                                </div>
                                <h3 class="product-title">
                                    <?php echo esc_html($p->get_name()); ?>
                                </h3>
                                <div class="product-price">
                                    <?php echo $p->get_price_html(); ?>
                                </div>
                            </a>
                            <div class="product-action">
                                <?php woocommerce_template_loop_add_to_cart([
                                    'product' => $p
                                ]); ?>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- Navigation Arrows -->
            <button class="carousel-btn carousel-prev" id="relatedProductsPrev" style="position: absolute; left: 0px; top: 50%; transform: translateY(-50%); background: #333; color: white; border: none; width: 40px; height: 40px; border-radius: 50%; cursor: pointer; font-size: 20px; display: flex; align-items: center; justify-content: center; transition: background-color 0.3s ease; z-index: 10;">
                ❮
            </button>
            <button class="carousel-btn carousel-next" id="relatedProductsNext" style="position: absolute; right: 0px; top: 50%; transform: translateY(-50%); background: #333; color: white; border: none; width: 40px; height: 40px; border-radius: 50%; cursor: pointer; font-size: 20px; display: flex; align-items: center; justify-content: center; transition: background-color 0.3s ease; z-index: 10;">
                ❯
            </button>
        </div>
    </section>

    <style>
        .related-products-slider-section {
            position: relative;
            padding: 30px 0;
            margin-top: 40px;
        }
        .related-products-slider-section h2 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 25px;
            color: #333;
        }
        .related-products-carousel-wrapper {
            position: relative;
            overflow: hidden;
            padding: 0 70px;
        }
        .related-products-carousel {
            display: flex;
            gap: 20px;
            transition: transform 0.5s ease;
            overflow: visible;
        }
        .carousel-slide {
            flex: 0 0 calc(25% - 15px);
        }
        .product-card {
            display: flex;
            flex-direction: column;
            height: 100%;
            background: #1B0631;
            padding: 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
            border: 1px solid #250e3d;
        }
        .product-card:hover {
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.12);
            border-color: #250e3d;
        }
        .product-image {
            margin-bottom: 12px;
            overflow: hidden;
            border-radius: 6px;
            height: auto;
        }
        .product-image img {
            width: 100%;
            height: auto;
            display: block;
        }
        .product-title {
            font-size: 32px;
            color: #fff;
            font-weight: 600;
            margin-bottom: 8px;
            line-height: 1.4;
            flex-grow: 1;
        }

        .product-title a {
            color: #fff;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .product-title a:hover {
            color: #fff;
        }
        .product-rating {
            margin-bottom: 8px;
            font-size: 13px;
        }
        .product-price {
            margin-bottom: 12px;
            font-size: 24px;
            font-weight: 700;
            color: #fcb043;
        }
        .product-action {
            margin-bottom: 8px;
        }

        .product-action button, .product-action a {
            width: 100%;
            padding: 10px;
            background-image: linear-gradient(var(--rbb-general-gradient-deg), var(--rbb-general-gradient-color) 0, var(--rbb-general-gradient-color2) 51%, var(--rbb-general-gradient-color) 100%);
            color: #0f0b16;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.3s ease;
        }
 
        .view-product {
            display: block;
            text-align: center;
            color: #0073aa;
            text-decoration: none;
            font-size: 13px;
            transition: color 0.3s ease;
        }

        .view-product:hover {
            color: #fff;
        }

        .carousel-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: #333;
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            z-index: 10;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }

        .carousel-btn:hover {
            background-color: #0073aa;
            box-shadow: 0 4px 12px rgba(0, 115, 170, 0.3);
        }

        .carousel-btn:active {
            transform: translateY(-50%) scale(0.95);
        }

        .carousel-prev {
            left: 15px;
        }

        .carousel-next {
            right: 15px;
        }

        /* Tablet - 3 products (768px to 1166px) */
        @media (max-width: 1166px) {
            .carousel-slide {
                flex: 0 0 calc(33.333% - 15px);
            }

            .related-products-carousel-wrapper {
                padding: 0 60px;
            }

            .carousel-btn {
                width: 38px;
                height: 38px;
                font-size: 16px;
            }

            .related-products-slider-section h2 {
                font-size: 24px;
                margin-bottom: 20px;
            }
        }

        /* Medium Mobile - 2 products (500px to 767px) */
        @media (max-width: 767px) {
            .carousel-slide {
                flex: 0 0 calc(50% - 15px);
            }

            .related-products-carousel {
                gap: 15px;
            }

            .related-products-carousel-wrapper {
                padding: 0 50px;
            }

            .carousel-btn {
                width: 35px;
                height: 35px;
                font-size: 15px;
            }

            .carousel-prev {
                left: 8px;
            }

            .carousel-next {
                right: 8px;
            }

            .product-card {
                padding: 12px;
            }

            .product-image {
                margin-bottom: 10px;
            }

            .product-title {
                font-size: 20px;
            }

            .product-price {
                font-size: 18px;
                margin-bottom: 10px;
            }

            .product-action button {
                padding: 8px;
                font-size: 12px;
            }

            .view-product {
                font-size: 12px;
            }

            .related-products-slider-section h2 {
                font-size: 20px;
                margin-bottom: 15px;
            }
        }

        /* Mobile - 1 product (below 500px) */
        @media (max-width: 499px) {
            .carousel-slide {
                flex: 0 0 calc(100% - 10px);
            }

            .related-products-carousel {
                gap: 15px;
            }

            .related-products-carousel-wrapper {
                padding: 0 40px;
            }

            .carousel-btn {
                width: 32px;
                height: 32px;
                font-size: 14px;
            }

            .carousel-prev {
                left: 5px;
            }

            .carousel-next {
                right: 5px;
            }

            .product-card {
                padding: 10px;
            }

            .product-image {
                margin-bottom: 8px;
            }

            .product-title {
                font-size: 16px;
                margin-bottom: 6px;
            }

            .product-rating {
                margin-bottom: 6px;
            }

            .product-price {
                font-size: 16px;
                margin-bottom: 8px;
            }

            .product-action {
                margin-bottom: 6px;
            }

            .product-action button {
                padding: 7px;
                font-size: 11px;
            }

            .view-product {
                font-size: 11px;
            }

            .related-products-slider-section {
                padding: 20px 0;
                margin-top: 30px;
            }

            .related-products-slider-section h2 {
                font-size: 18px;
                margin-bottom: 12px;
            }
        }

        /* Extra Small Mobile */
        @media (max-width: 360px) {
            .related-products-carousel {
                gap: 10px;
            }

            .related-products-carousel-wrapper {
                padding: 0 35px;
            }

            .carousel-btn {
                width: 30px;
                height: 30px;
                font-size: 12px;
            }

            .carousel-prev {
                left: 2px;
            }

            .carousel-next {
                right: 2px;
            }

            .product-card {
                padding: 8px;
                border-radius: 6px;
            }

            .product-image {
                margin-bottom: 6px;
                border-radius: 4px;
            }

            .product-title {
                font-size: 16px;
                margin-bottom: 5px;
                line-height: 1.3;
            }

            .product-rating {
                margin-bottom: 4px;
                font-size: 12px;
            }

            .product-price {
                font-size: 16px;
                margin-bottom: 6px;
            }

            .product-action {
                margin-bottom: 4px;
            }

            .product-action button {
                padding: 6px;
                font-size: 10px;
                border-radius: 3px;
            }

            .view-product {
                font-size: 10px;
            }

            .related-products-slider-section {
                padding: 15px 0;
                margin-top: 25px;
            }

            .related-products-slider-section h2 {
                font-size: 16px;
                margin-bottom: 10px;
                font-weight: 600;
            }
        }

        /* Landscape Mobile */
        @media (max-height: 500px) and (orientation: landscape) {
            .product-image {
                margin-bottom: 6px;
                max-height: 150px;
                overflow: hidden;
            }

            .product-card {
                padding: 8px;
            }

            .related-products-slider-section {
                padding: 10px 0;
                margin-top: 15px;
            }
        }
    </style>

    <script>
        (() => {
            const getItemsPerView = () =>
                innerWidth > 1200 ? 4 : innerWidth > 767 ? 3 : innerWidth > 499 ? 2 : 1;

            const initCarousel = () => {
                const carousel = document.getElementById('relatedProductsCarousel');
                if (!carousel) return;

                const wrapper = carousel.parentElement,
                    prevBtn = document.getElementById('relatedProductsPrev'),
                    nextBtn = document.getElementById('relatedProductsNext'),
                    slides = carousel.querySelectorAll('.carousel-slide');

                let currentIndex = 0,
                    originalCount = +wrapper.dataset.originalCount || slides.length / 2,
                    slideWidth = slides[0].offsetWidth + 10;

                const goTo = (index, animate = true) => {
                    carousel.style.transition = animate ? 'transform .5s ease' : 'none';
                    carousel.style.transform = `translateX(-${index * slideWidth}px)`;
                    currentIndex = index;

                    if (animate && currentIndex >= originalCount) {
                        setTimeout(() => goTo(0, false), 500);
                    }
                };
                nextBtn.onclick = () =>
                    goTo(currentIndex + 1 >= originalCount ? originalCount : currentIndex + 1);
                prevBtn.onclick = () =>
                    goTo(currentIndex - 1 < 0 ? originalCount - 1 : currentIndex - 1);

                // Touch support
                let touchStartX = 0;
                carousel.ontouchstart = e => touchStartX = e.touches[0].clientX;
                carousel.ontouchend = e => {
                    const diff = touchStartX - e.changedTouches[0].clientX;
                    if (Math.abs(diff) > 50) diff > 0 ? nextBtn.onclick() : prevBtn.onclick();
                };

                // Resize handler
                let resizeTimer;
                addEventListener('resize', () => {
                    clearTimeout(resizeTimer);
                    resizeTimer = setTimeout(() => {
                        slideWidth = slides[0].offsetWidth + 10;
                        goTo(currentIndex, false);
                    }, 200);
                });

                goTo(0, false);
            };

            document.readyState === 'loading' ?
                addEventListener('DOMContentLoaded', initCarousel) :
                initCarousel();
        })();
    </script>
<?php
}
 