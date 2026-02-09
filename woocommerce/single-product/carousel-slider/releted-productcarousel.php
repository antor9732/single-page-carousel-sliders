<?php
/**
 * Related products slider for WooCommerce
 * Displays related products in a carousel/slider format
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
    enqueue_carousel_assets();

    // Get products query
    $products = wc_get_products( [
        'include' => $related_products,
        'limit'   => 50,
    ] );

    if ( empty( $products ) ) {
        return;
    }

    // Ensure we have at least 4 products by duplicating if necessary
    $products = array_values( $products );
    $original_count = count( $products );
    if ( $original_count < 4 ) {
        $original_products = $products;
        while ( count( $products ) < 4 ) {
            foreach ( $original_products as $prod ) {
                if ( count( $products ) < 4 ) {
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
                    <div class="carousel-slide" style="flex: 0 0 calc(25% - 15px); margin-right: 15px;">
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
            padding: 20px 0;
        }

        .related-products-carousel-wrapper {
            position: relative;
            overflow: hidden;
            padding: 0 60px;
        }

        .related-products-carousel {
            display: flex;
            gap: 15px;
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
            transition: box-shadow 0.3s ease, transform 0.3s ease;
        }

        .product-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .carousel-btn:hover {
            background-color: #0073aa !important;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .carousel-slide {
                flex: 0 0 calc(33.333% - 15px);
            }
        }

        @media (max-width: 768px) {
            .carousel-slide {
                flex: 0 0 calc(50% - 15px);
            }

            .related-products-carousel-wrapper {
                padding: 0 40px;
            }

            .carousel-btn {
                width: 35px !important;
                height: 35px !important;
            }
        }

        @media (max-width: 480px) {
            .carousel-slide {
                flex: 0 0 calc(100% - 15px);
            }

            .related-products-carousel-wrapper {
                padding: 0 30px;
            }
        }
    </style>

    <script>
    (function() {
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
            const slideWidth = slides[0].offsetWidth + 15; // slide width + gap

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
                
                // If we're at the last original item, go to the first duplicate
                if (nextIndex >= totalSlides) {
                    nextIndex = originalCount;
                }
                
                goToSlide(nextIndex, true);
            }

            // Go to previous
            function goPrev() {
                let prevIndex = currentIndex - 1;
                
                // If we're at the first duplicate of first item, go to the last original item
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

            // Initial state
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
function enqueue_carousel_assets() {
    // This function is for future expansion if needed
    // You can add custom CSS/JS files here
}
