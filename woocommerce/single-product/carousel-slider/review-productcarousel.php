<?php

/**
 * Product Image Carousel (Custom Fields)
 * Custom Fields: review_image1 to review_image10
 * Hook: woocommerce_product_meta_end
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Display image carousel on product page
 */
function display_product_review_carousel()
{
    global $product;

    if (! $product || ! is_a($product, 'WC_Product')) {
        return;
    }

    $product_id = $product->get_id();
    $carousel_images = [];

    for ($i = 1; $i <= 10; $i++) {
        $image_id = get_post_meta($product_id, 'review_testimonial' . $i, true);
        if (! empty($image_id)) {
            $carousel_images[] = wp_get_attachment_url($image_id);
        }
    }

    if (empty($carousel_images)) {
        return;
    }
?>

    <div class="review-carousel-wrapper">
        <div class="image-carousel-slider">
            <?php foreach ($carousel_images as $image_url) : ?>
                <div class="review-carousel-slide">
                    <img
                        src="<?php echo esc_url($image_url); ?>"
                        alt="<?php echo esc_attr(get_the_title($product_id)); ?>"
                        class="review-carousel-image">
                </div>
            <?php endforeach; ?>
        </div>
    </div>

<?php
}
add_action('woocommerce_after_single_product', 'display_product_review_carousel');


/**
 * Enqueue carousel assets
 */
function enqueue_review_carousel_assets()
{

    // Slick Carousel CSS
    wp_enqueue_style('slick-carousel', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', [], '1.8.1');
    wp_enqueue_style('slick-theme', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css', ['slick-carousel'], '1.8.1');

    wp_enqueue_script('jquery');
    wp_enqueue_script('slick-carousel', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', ['jquery'], '1.8.1', true);

    // Custom Styles
    wp_add_inline_style('slick-theme', '
        .review-carousel-wrapper {
            max-width: 100%;
            margin: 40px auto;
        }
        
        .review-carousel-image {
            width: 260px;
            height: 250px;
            object-fit: cover;
            border-radius: 8px;
        }
        .review-carousel-slide {
            padding: 0 10px;
        }
        @media (max-width: 1024px) {
            .review-carousel-image {
                height: 85%;
            }
          img.review-carousel-image {
                width: 150px;
                height: 100%;
            }
        }
        @media (max-width: 768px) {
            .review-carousel-image {
                height: 200px;
            }
          img.review-carousel-image {
                width: 100%;
                height: 100%;
            }
            }
       
    ');

    // Initialize Slick with 3 slides per page
    wp_add_inline_script('slick-carousel', '
        jQuery(document).ready(function($){
            if ( $(".image-carousel-slider").length ) {
                $(".image-carousel-slider").slick({
                    slidesToShow: 5,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 3000,
                    speed: 600,
                    infinite: true,
                    arrows: true,
                    dots: true,
                    adaptiveHeight: true,
                    responsive: [
                        {
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 5
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 2
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1
                            }
                        }
                    ]
                });
            }
        });
    ');
}
add_action('wp_enqueue_scripts', 'enqueue_review_carousel_assets');
