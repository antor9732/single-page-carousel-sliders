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
function display_product_image_carousel()
{
    global $product;

    if (! $product || ! is_a($product, 'WC_Product')) {
        return;
    }

    $product_id = $product->get_id();
    $carousel_images = [];

    for ($i = 1; $i <= 10; $i++) {
        $image_id = get_post_meta($product_id, 'review_image' . $i, true);
        if (! empty($image_id)) {
            $carousel_images[] = wp_get_attachment_url($image_id);
        }
    }

    if (empty($carousel_images)) {
        return;
    }
?>

    <div class="image-carousel-wrapper">
        <div class="image-carousel-slider">
            <?php foreach ($carousel_images as $image_url) : ?>
                <div class="carousel-slide">
                    <img
                        src="<?php echo esc_url($image_url); ?>"
                        alt="<?php echo esc_attr(get_the_title($product_id)); ?>"
                        class="carousel-image">
                </div>
            <?php endforeach; ?>
        </div>
    </div>

<?php
}
add_action('woocommerce_product_meta_end', 'display_product_image_carousel');


/**
 * Enqueue carousel assets
 */
function enqueue_image_carousel_assets()
{

    // Slick Carousel CSS
    wp_enqueue_style('slick-carousel', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', [], '1.8.1');
    wp_enqueue_style('slick-theme', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css', ['slick-carousel'], '1.8.1');

    wp_enqueue_script('jquery');
    wp_enqueue_script('slick-carousel', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', ['jquery'], '1.8.1', true);

    // Custom Styles
    wp_add_inline_style('slick-theme', '
        .image-carousel-wrapper {
            max-width: 800px;
            margin: 40px auto;
        }
        
        .carousel-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 8px;
        }
        @media (max-width: 1024px) {
            .carousel-image {
                height: 85%;
            }
          img.carousel-image {
                width: 150px;
                height: 100%;
            }
        }
        @media (max-width: 768px) {
            .carousel-image {
                height: 200px;
            }
          img.carousel-image {
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
                    slidesToShow: 3,
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
                                slidesToShow: 2
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 2
                            }
                        }
                    ]
                });
            }
        });
    ');
}
add_action('wp_enqueue_scripts', 'enqueue_image_carousel_assets');
