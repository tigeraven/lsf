<?php

add_filter('mo_sidebar_names', 'mo_init_woocommerce_sidebar', 10, 1);

add_filter('mo_sidebar_descriptions', 'mo_init_woocommerce_sidebar_description', 10, 1);

add_filter('mo_sidebar_id_suffix', 'mo_check_for_woocommerce_sidebar', 10, 1);


if (!function_exists('mo_check_for_woocommerce_sidebar')) {
    function mo_check_for_woocommerce_sidebar($suffix) {
        //If woocommerce template
        if (class_exists('woocommerce')) {
            if (is_singular('product')) {
                $suffix = 'product';
            }
            elseif (is_woocommerce() || is_checkout() || is_cart() || is_order_received_page()) {
                $suffix = 'shop';
            }
        }

        return $suffix;
    }
}

if (!function_exists('mo_init_woocommerce_sidebar')) {
    function mo_init_woocommerce_sidebar($sidebar_names) {

        $sidebar_names['primary-shop'] = esc_html__('Primary WooCommerce Shop Sidebar', 'peak');

        $sidebar_names['primary-product'] = esc_html__('Primary WooCommerce Product Sidebar', 'peak');

        return $sidebar_names;
    }
}

if (!function_exists('mo_init_woocommerce_sidebar_description')) {
    function mo_init_woocommerce_sidebar_description($sidebar_descriptions) {

        $sidebar_descriptions['primary-shop'] = esc_html__('Primary Sidebar displayed for WooCommerce templates', 'peak');

        $sidebar_descriptions['primary-product'] = esc_html__('Primary Sidebar displayed for WooCommerce Single Product', 'peak');

        return $sidebar_descriptions;
    }
}