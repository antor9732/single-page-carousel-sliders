<?php 
/**
 * Single Product related product carousel image
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/carousel-slider/releted-productcarousel.php.
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.7.0
 */

defined('ABSPATH') || exit;

function add_related_products_carousel_after_summary() {
    global $product;
    
   
    if (!is_product()) {
        return;
    }
    
    $related_products = wc_get_related_products($product->get_id(), 12, $product->get_upsell_ids());
    
    if (empty($related_products)) {
        return;
    }
    
    $related_products = array_map('wc_get_product', $related_products);
    $related_products = array_filter($related_products);
    
    $total_products = count($related_products);
    $related_products = array_values($related_products);
    
    if ($total_products < 4 && $total_products > 0) {
        $needed = 4 - $total_products;
        for ($i = 0; $i < $needed; $i++) {
            $related_products[] = $related_products[$i % $total_products];
        }
        $total_products = count($related_products);
    }
    
    add_action('wp_footer', function() {
        ?>
        <style>
        .custom-related-carousel {
            margin: 40px 0;
            padding: 20px 0;
            border-top: 1px solid #eee;
            clear: both;
        }
        
        .custom-related-title {
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
            color: #333;
            font-weight: 600;
        }
        
        .custom-related-slider-container {
            position: relative;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 50px;
        }
        
        .custom-related-slider {
            display: flex;
            overflow: hidden;
        }
        
        .custom-related-slider-track {
            display: flex;
            transition: transform 0.5s ease;
            width: 100%;
        }
        
        .custom-related-item {
            flex: 0 0 25%;
            padding: 10px;
            box-sizing: border-box;
        }
        
        .custom-related-product {
            background: #fff;
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .custom-related-product:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .custom-related-image {
            width: 100%;
            height: 200px;
            object-fit: contain;
            margin-bottom: 15px;
        }
        
        .custom-related-product-title {
            font-size: 16px;
            margin: 10px 0;
            color: #333;
            line-height: 1.4;
            flex-grow: 1;
        }
        
        .custom-related-product-title a {
            color: inherit;
            text-decoration: none;
        }
        
        .custom-related-product-title a:hover {
            color: #0073aa;
        }
        
        .custom-related-price {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin: 10px 0;
            color: #ff6b6b;
        }
        
        .custom-related-rating {
            margin: 10px 0;
            color: #ffc107;
        }
        
        .custom-related-add-to-cart {
            margin-top: 15px;
        }
        
        .custom-related-add-to-cart .button {
            background: #333;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background 0.3s ease;
            font-size: 14px;
        }
        
        .custom-related-add-to-cart .button:hover {
            background: #0073aa;
        }
        
        .custom-slider-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0,0,0,0.7);
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 20px;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .custom-slider-btn:hover {
            background: rgba(0,0,0,0.9);
        }
        
        .custom-prev-btn {
            left: 0;
        }
        
        .custom-next-btn {
            right: 0;
        }
        
        .custom-slider-dots {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        
        .custom-slider-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #ddd;
            margin: 0 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        
        .custom-slider-dot.active {
            background: #333;
        }
        
        /* Responsive Styles */
        @media (max-width: 1200px) {
            .custom-related-slider-container {
                padding: 0 40px;
            }
        }
        
        @media (max-width: 992px) {
            .custom-related-item {
                flex: 0 0 33.333%;
            }
        }
        
        @media (max-width: 768px) {
            .custom-related-item {
                flex: 0 0 50%;
            }
            
            .custom-related-slider-container {
                padding: 0 30px;
            }
        }
        
        @media (max-width: 576px) {
            .custom-related-item {
                flex: 0 0 100%;
            }
            
            .custom-related-slider-container {
                padding: 0 20px;
            }
            
            .custom-related-image {
                height: 180px;
            }
        }
        </style>
        
        <script>
        jQuery(document).ready(function($) {
            if ($('.custom-related-slider').length > 0) {
                let currentSlide = 0;
                const sliderTrack = $('.custom-related-slider-track');
                const sliderItems = $('.custom-related-item');
                const totalSlides = sliderItems.length;
                let slidesToShow = 4;
                
                function updateSlidesToShow() {
                    const width = $(window).width();
                    if (width < 576) {
                        slidesToShow = 1;
                    } else if (width < 768) {
                        slidesToShow = 2;
                    } else if (width < 992) {
                        slidesToShow = 3;
                    } else {
                        slidesToShow = 4;
                    }
                    
                    sliderItems.css('flex', `0 0 ${100/slidesToShow}%`);
                    
                    // current slider adjustment after slidesToShow update
                    if (currentSlide > totalSlides - slidesToShow) {
                        currentSlide = Math.max(0, totalSlides - slidesToShow);
                        updateSlider();
                    }
                }
                
                function updateSlider() {
                    const translateX = -(currentSlide * (100 / slidesToShow));
                    sliderTrack.css('transform', `translateX(${translateX}%)`);
                    
                    // Dot update
                    $('.custom-slider-dot').removeClass('active');
                    $('.custom-slider-dot').eq(currentSlide).addClass('active');
                }
                
                function createDots() {
                    const dotsContainer = $('<div class="custom-slider-dots"></div>');
                    for (let i = 0; i < Math.ceil(totalSlides / slidesToShow); i++) {
                        const dot = $(`<div class="custom-slider-dot" data-slide="${i}"></div>`);
                        if (i === 0) dot.addClass('active');
                        dotsContainer.append(dot);
                    }
                    $('.custom-related-slider-container').after(dotsContainer);
                }
                
                // event listeners
                $('.custom-next-btn').click(function() {
                    if (currentSlide < totalSlides - slidesToShow) {
                        currentSlide++;
                        updateSlider();
                    }
                });
                
                $('.custom-prev-btn').click(function() {
                    if (currentSlide > 0) {
                        currentSlide--;
                        updateSlider();
                    }
                });
                
                // dot click event
                $(document).on('click', '.custom-slider-dot', function() {
                    currentSlide = $(this).data('slide') * slidesToShow;
                    updateSlider();
                });
                
                // auto slide every 5 seconds
                let autoSlide = setInterval(() => {
                    if (currentSlide >= totalSlides - slidesToShow) {
                        currentSlide = 0;
                    } else {
                        currentSlide++;
                    }
                    updateSlider();
                }, 5000);
                
                // hOVER STOP AUTO SLIDE
                $('.custom-related-slider-container').hover(
                    function() {
                        clearInterval(autoSlide);
                    },
                    function() {
                        autoSlide = setInterval(() => {
                            if (currentSlide >= totalSlides - slidesToShow) {
                                currentSlide = 0;
                            } else {
                                currentSlide++;
                            }
                            updateSlider();
                        }, 5000);
                    }
                );
                
                $(window).resize(function() {
                    updateSlidesToShow();
                    updateSlider();
                });
                
                updateSlidesToShow();
                createDots();
                updateSlider();
            }
        });
        </script>
        <?php
    });
    
    ?>
    <div class="custom-related-carousel">
        <h2 class="custom-related-title"><?php esc_html_e('Related Products', 'woocommerce'); ?></h2>
        
        <div class="custom-related-slider-container">
            <button class="custom-slider-btn custom-prev-btn">‹</button>
            
            <div class="custom-related-slider">
                <div class="custom-related-slider-track">
                    <?php foreach ($related_products as $related_product) : ?>
                        <div class="custom-related-item">
                            <div class="custom-related-product">
                                <a href="<?php echo esc_url(get_permalink($related_product->get_id())); ?>">
                                    <?php
                                    if (has_post_thumbnail($related_product->get_id())) {
                                        echo get_the_post_thumbnail($related_product->get_id(), 'woocommerce_thumbnail', array(
                                            'class' => 'custom-related-image',
                                            'alt' => esc_attr($related_product->get_name())
                                        ));
                                    } else {
                                        echo wc_placeholder_img('woocommerce_thumbnail', array('class' => 'custom-related-image'));
                                    }
                                    ?>
                                    
                                    <h3 class="custom-related-product-title">
                                        <?php echo esc_html($related_product->get_name()); ?>
                                    </h3>
                                </a>
                                
                                <div class="custom-related-price">
                                    <?php echo $related_product->get_price_html(); ?>
                                </div>
                                
                                <?php if ($related_product->get_average_rating() > 0) : ?>
                                    <div class="custom-related-rating">
                                        <?php echo wc_get_rating_html($related_product->get_average_rating()); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="custom-related-add-to-cart">
                                    <?php
                                    echo apply_filters(
                                        'woocommerce_loop_add_to_cart_link',
                                        sprintf(
                                            '<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
                                            esc_url($related_product->add_to_cart_url()),
                                            esc_attr(1),
                                            esc_attr('button add_to_cart_button' . ($related_product->supports('ajax_add_to_cart') ? ' ajax_add_to_cart' : '')),
                                            wc_implode_html_attributes(array(
                                                'data-product_id' => $related_product->get_id(),
                                                'data-product_sku' => $related_product->get_sku(),
                                                'aria-label' => sprintf(__('Add "%s" to cart', 'woocommerce'), $related_product->get_name()),
                                                'rel' => 'nofollow',
                                            )),
                                            esc_html($related_product->add_to_cart_text())
                                        ),
                                        $related_product
                                    );
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <button class="custom-slider-btn custom-next-btn">›</button>
        </div>
    </div>
    <?php
}
add_action('woocommerce_after_single_product_summary', 'add_related_products_carousel_after_summary', 20);