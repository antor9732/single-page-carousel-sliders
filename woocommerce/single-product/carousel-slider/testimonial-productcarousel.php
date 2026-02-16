<?php

/**
 * Product Testimonial Carousel (Custom Fields)
 * Custom Fields: review_testimonial1 to review_testimonial10
 * Hook: woocommerce_product_meta_end
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Display image carousel on product page
 */
function display_product_testimonial_carousel()
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

    <div class="testimonial-carousel-wrapper">
        <div class="testimonial-image-carousel-slider">
            <?php foreach ($carousel_images as $image_url) : ?>
                <div class="testimonial-carousel-slide">
                    <img
                        src="<?php echo esc_url($image_url); ?>"
                        alt="<?php echo esc_attr(get_the_title($product_id)); ?>"
                        class="testimonial-carousel-image">
                </div>
            <?php endforeach; ?>
        </div> 
    </div>

<?php
}
add_action('woocommerce_product_meta_end', 'display_product_testimonial_carousel');


/**
 * Enqueue carousel assets
 */
function enqueue_testimonial_carousel_assets()
{

    // Slick Carousel CSS
    wp_enqueue_style('slick-carousel', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', [], '1.8.1');
    wp_enqueue_style('slick-theme', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css', ['slick-carousel'], '1.8.1');

    wp_enqueue_script('jquery');
    wp_enqueue_script('slick-carousel', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', ['jquery'], '1.8.1', true);

    // Custom Styles
    wp_add_inline_style('slick-theme', '
        .testimonial-carousel-wrapper {
            max-width: 800px;
            margin: 40px auto;
        }
        
        .testimonial-carousel-image {
            width: 100%;
            height: 100% !important;
            object-fit: cover;
            border-radius: 8px;
        }
        .testimonial-carousel-slide {
            padding: 0 10px;
        }
       
    ');

    // Initialize Slick with 3 slides per page
    wp_add_inline_script('slick-carousel', '
        jQuery(document).ready(function($){
            if ( $(".testimonial-image-carousel-slider").length ) {
                $(".testimonial-image-carousel-slider").slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: false,
                    autoplaySpeed: 3000,
                    speed: 600,
                    infinite: false,
                    arrows: false,
                    dots: true,
                    adaptiveHeight: false,
                    responsive: [
                        {
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 1
                            }
                        },
                        {
                            breakpoint: 768,
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
add_action('wp_enqueue_scripts', 'enqueue_testimonial_carousel_assets');
