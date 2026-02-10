<?php
/**
 * Related Products Carousel Template
 * This template displays related products as a carousel slider on the single product page.
 * It is hooked to 'woocommerce_after_single_product_summary' and will show up after the product summary section.
 * The carousel is responsive and will adjust the number of visible products based on the screen size.
 * Note: This template assumes that you have the necessary CSS and JS for the carousel functionality. You may need to enqueue additional assets or customize the styles as needed.
 * To customize the appearance, you can modify the HTML structure and CSS styles within this template. Make sure to test the carousel on different devices to ensure it works well across all screen sizes.
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'woocommerce_after_single_product_summary', 'display_related_products_slider' );

/**
 * Display related products as a slider
 */
function display_related_products_slider() {
    global $product;

    if ( ! $product ) {
        return;
    }

    // Get related products
    $related_products = wc_get_related_products( $product->get_id(), 50 );

    if ( empty( $related_products ) ) {
        return;
    }

    // Enqueue carousel libraries
    // enqueue_carousel_assets();

    // Get products query
    $products = wc_get_products( [
        'include' => $related_products,
        'limit'   => 50,
    ] );

    if ( empty( $products ) ) {
        return;
    }

    // Ensure we have minimum products based on different breakpoints
    $products = array_values( $products );
    $original_count = count( $products );
    
    // Define minimum products for each breakpoint
    $min_products = 4; // Desktop default
    
    // Check if we need to duplicate products for infinite scroll
    if ( $original_count < $min_products ) {
        $original_products = $products;
        while ( count( $products ) < $min_products ) {
            foreach ( $original_products as $prod ) {
                if ( count( $products ) < $min_products ) {
                    $products[] = $prod;
                }
            }
        }
        $original_count = count( $products );
    }
    
    // Duplicate products for infinite scroll
    $products = array_merge( $products, $products );

    ?>
    <section class="related-products-slider-section" style="margin-top: 40px;">
        <h2 style="font-size: 24px; margin-bottom: 20px; font-weight: 600;">Related Products</h2>
        
        <div class="related-products-carousel-wrapper" style="position: relative; overflow: hidden; padding: 0 60px;" data-original-count="<?php echo absint( $original_count ); ?>">
            <div class="related-products-carousel" id="relatedProductsCarousel" style="display: flex; gap: 15px; transition: transform 0.5s ease; overflow: visible;">
                <?php foreach ( $products as $product ) : ?>
                    <div class="carousel-slide" style=" margin-right: 15px;">
                        <div class="product-card" style="background: #f9f9f9; padding: 15px; border-radius: 8px; transition: box-shadow 0.3s ease;">
                            <!-- Product Image -->
                            <div class="product-image" style="margin-bottom: 12px; overflow: hidden; border-radius: 6px;">
                                <?php echo $product->get_image( 'woocommerce_thumbnail' ); ?>
                            </div>

                            <!-- Product Title -->
                            <h3 class="product-title" style="font-size: 14px; font-weight: 600; margin-bottom: 8px; line-height: 1.4;">
                                <a href="<?php echo esc_url( $product->get_permalink() ); ?>" style="color: #333; text-decoration: none;">
                                    <?php echo esc_html( $product->get_name() ); ?>
                                </a>
                            </h3>

                            <!-- Product Rating -->
                            <div class="product-rating" style="margin-bottom: 8px;">
                                <?php 
                                if ( function_exists( 'woocommerce_template_loop_rating' ) ) {
                                    // Display star rating if available
                                    echo wc_get_rating_html( $product->get_average_rating(), $product->get_review_count() );
                                }
                                ?>
                            </div>

                            <!-- Product Price -->
                            <div class="product-price" style="margin-bottom: 12px; font-size: 16px; font-weight: 700; color: #1a9e35;">
                                <?php echo $product->get_price_html(); ?>
                            </div>

                            <!-- Add to Cart Button -->
                            <div class="product-action" style="margin-bottom: 8px;">
                                <form class="cart" action="<?php echo esc_url( $product->add_to_cart_url() ); ?>" method="post" enctype="multipart/form-data">
                                    <button type="submit" class="button wp-element-button add-to-cart" style="width: 100%; padding: 10px; background-color: #1a9e35; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: 600; transition: background-color 0.3s ease;">
                                        <?php echo esc_html( $product->add_to_cart_text() ); ?>
                                    </button>
                                    <input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>">
                                </form>
                            </div>

                            <!-- View Product Link -->
                            <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="view-product" style="display: block; text-align: center; color: #0073aa; text-decoration: none; font-size: 14px;">
                                View Details
                            </a>
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
            background: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
            border: 1px solid #f0f0f0;
        }

        .product-card:hover {
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.12);
            transform: translateY(-5px);
            border-color: #e0e0e0;
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
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 8px;
            line-height: 1.4;
            flex-grow: 1;
        }

        .product-title a {
            color: #333;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .product-title a:hover {
            color: #0073aa;
        }

        .product-rating {
            margin-bottom: 8px;
            font-size: 13px;
        }

        .product-price {
            margin-bottom: 12px;
            font-size: 16px;
            font-weight: 700;
            color: #1a9e35;
        }

        .product-action {
            margin-bottom: 8px;
        }

        .product-action button {
            width: 100%;
            padding: 10px;
            background-color: #1a9e35;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.3s ease;
        }

        .product-action button:hover {
            background-color: #157a2d;
            box-shadow: 0 3px 8px rgba(26, 158, 53, 0.3);
        }

        .product-action button:active {
            transform: scale(0.98);
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
            color: #005a87;
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

        /* Tablet - 3 products (768px to 1024px) */
        @media (max-width: 1024px) {
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
                font-size: 13px;
            }

            .product-price {
                font-size: 15px;
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
                flex: 0 0 calc(100% - 15px);
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
                font-size: 12px;
                margin-bottom: 6px;
            }

            .product-rating {
                margin-bottom: 6px;
            }

            .product-price {
                font-size: 14px;
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
            .carousel-slide {
                flex: 0 0 calc(100% - 10px);
            }

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
                font-size: 11px;
                margin-bottom: 5px;
                line-height: 1.3;
            }

            .product-rating {
                margin-bottom: 4px;
                font-size: 11px;
            }

            .product-price {
                font-size: 13px;
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
    (function() {
        // Get the number of items to show based on viewport width
        function getItemsPerView() {
            const width = window.innerWidth;
            if (width > 1200) {
                return 4; // Desktop - 4 items
            } else if (width > 767) {
                return 3; // Tablet (768px - 1200px) - 3 items
            } else if (width > 499) {
                return 2; // Medium Mobile (500px - 767px) - 2 items
            } else {
                return 1; // Mobile - 1 item
            }
        }

        // Initialize carousel
        function initCarousel() {
            const carousel = document.getElementById('relatedProductsCarousel');
            const wrapper = carousel.parentElement;
            const prevBtn = document.getElementById('relatedProductsPrev');
            const nextBtn = document.getElementById('relatedProductsNext');

            // Check if elements exist
            if (!carousel || !prevBtn || !nextBtn || !wrapper) {
                console.log('Carousel elements not found');
                return;
            }

            let currentIndex = 0;
            const slides = carousel.querySelectorAll('.carousel-slide');
            const originalCount = parseInt(wrapper.dataset.originalCount) || slides.length / 2;
            const totalSlides = slides.length;
            let itemsPerView = getItemsPerView();
            let slideWidth = slides[0].offsetWidth + 15; // slide width + gap

            // Function to update slide width
            function updateSlideWidth() {
                if (slides.length > 0) {
                    slideWidth = slides[0].offsetWidth + 15;
                }
            }

            // Go to specific slide
            function goToSlide(index, animate = true) {
                if (animate) {
                    carousel.style.transition = 'transform 0.5s ease';
                } else {
                    carousel.style.transition = 'none';
                }

                const position = index * slideWidth;
                carousel.style.transform = 'translateX(-' + position + 'px)';
                currentIndex = index;

                // Check if we've reached the duplicated section
                if (animate && currentIndex >= originalCount) {
                    // Reset to beginning after animation completes
                    setTimeout(function() {
                        goToSlide(0, false);
                    }, 500);
                }
            }

            // Go to next
            function goNext() {
                let nextIndex = currentIndex + 1;
                
                // If we're at or past the last original item, reset
                if (nextIndex >= originalCount) {
                    nextIndex = originalCount;
                }
                
                goToSlide(nextIndex, true);
            }

            // Go to previous
            function goPrev() {
                let prevIndex = currentIndex - 1;
                
                // If we're below first item, go to last original item
                if (prevIndex < 0) {
                    prevIndex = originalCount - 1;
                }
                
                goToSlide(prevIndex, true);
            }

            // Add click listeners
            prevBtn.addEventListener('click', goPrev);
            nextBtn.addEventListener('click', goNext);

            // Touch support
            let touchStart = 0;
            carousel.addEventListener('touchstart', function(e) {
                touchStart = e.touches[0].clientX;
            }, false);

            carousel.addEventListener('touchend', function(e) {
                const touchEnd = e.changedTouches[0].clientX;
                const diff = touchStart - touchEnd;
                
                if (Math.abs(diff) > 50) {
                    if (diff > 0) {
                        goNext();
                    } else {
                        goPrev();
                    }
                }
            }, false);

            // Handle window resize
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    itemsPerView = getItemsPerView();
                    updateSlideWidth();
                    goToSlide(currentIndex, false);
                }, 250);
            });

            // Initial state
            updateSlideWidth();
            goToSlide(0, false);
        }

        // Run when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initCarousel);
        } else {
            initCarousel();
        }

        // Also run after images load
        window.addEventListener('load', initCarousel);
        setTimeout(initCarousel, 1000);
    })();
    </script>
    <?php
}

/**
 * Enqueue carousel assets
 */
// function enqueue_carousel_assets() {
//     // This function is for future expansion if needed
//     // You can add custom CSS/JS files here
// }
