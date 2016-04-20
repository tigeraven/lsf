<?php


remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

add_action('woocommerce_before_shop_loop_item_title', 'mo_product_thumbnail', 10);
add_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
add_filter('loop_shop_per_page', 'mo_products_per_page');
add_filter('loop_shop_columns', 'mo_products_loop_columns');

add_filter('body_class', 'mo_woocommerce_class');

add_filter('woocommerce_show_page_title', 'mo_woocommerce_show_page_title');

add_filter('mo_show_page_title', 'mo_show_woocommerce_title');

add_filter( 'woocommerce_output_related_products_args', 'mo_related_products_args' );


remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
add_action( 'woocommerce_after_single_product_summary', 'mo_woocommerce_output_upsells', 15 );

// add the filter 
add_filter( 'woocommerce_pagination_args', 'mo_filter_woocommerce_pagination_args', 10, 1 );

// define the woocommerce_pagination_args callback 
function mo_filter_woocommerce_pagination_args( $array ) {
    // make filter magic happen here... 
    $array['prev_text'] = '<';
    $array['next_text'] = '>';
    return $array;
};

if ( ! function_exists( 'mo_woocommerce_output_upsells' ) ) {
    function mo_woocommerce_output_upsells() {
        woocommerce_upsell_display( 3,3 ); // Display 3 products in rows of 3
    }
}

function mo_related_products_args( $args ) {
    $args['posts_per_page'] = 3; // 3 related products
    $args['columns'] = 3; // arranged in 3 columns
    return $args;
}


if (!function_exists('mo_products_per_page')) {
    function mo_products_per_page() {
        return intval(apply_filters('mo_products_per_page', 9));
    }
}

if (!function_exists('mo_products_loop_columns')) {
    function mo_products_loop_columns() {
        return intval(apply_filters('mo_products_loop_columns', 3));
    }
}

if (!function_exists('mo_woocommerce_class')) {
    function mo_woocommerce_class($classes) {
        if (class_exists('woocommerce')) {
            $classes[] = 'woocommerce-site';
        }
        return $classes;
    }
}


if (!function_exists('mo_woocommerce_show_page_title')) {
    function mo_woocommerce_show_page_title() {
        return false;
    }
}


if (!function_exists('mo_show_woocommerce_title')) {
    function mo_show_woocommerce_title() {

        if (class_exists('woocommerce') && is_woocommerce()) {
            echo '<h1 class="page-title">';
            woocommerce_page_title();
            echo '</h1>';
            return true;
        }

        return false;
    }
}

if (!function_exists('mo_product_thumbnail')) {
    function mo_product_thumbnail() {

        mo_thumbnail(array(
            'image_size' => 'shop_catalog',
            // display full image
            'wrapper' => true,
            'size' => 'full',
            'taxonomy' => 'product_cat',
            'show_image_info' => true
        ));
    }
}


?>