<?php


add_action('mo_header', 'mo_header_cart', 40);

add_filter( 'woocommerce_add_to_cart_fragments', 'mo_cart_link_fragment' );

/**
 * Ensure cart contents are updated when products are added to the cart via AJAX
 */
if ( ! function_exists( 'mo_cart_link_fragment' ) ) {
    function mo_cart_link_fragment( $fragments ) {

        ob_start();

        mo_cart_link();

        $fragments['a.cart-contents'] = ob_get_clean();

        return $fragments;
    }
}


/**
 * Displays a link to the cart including the number of items present and the cart total
 */
if (!function_exists('mo_cart_link')) {
    function mo_cart_link() {
        ?>
        <a class="cart-contents" href="<?php echo esc_url(WC()->cart->get_cart_url()); ?>"
           title="<?php esc_html_e('View your shopping cart', 'peak'); ?>">
            <span class="amount"><?php echo wp_kses_data(WC()->cart->get_cart_subtotal()); ?></span> <span
                class="count"><?php echo wp_kses_data(sprintf(_n('%d item', '%d items', WC()->cart->get_cart_contents_count(), 'peak'), WC()->cart->get_cart_contents_count())); ?></span>
        </a>
    <?php
    }
}

/**
 * Display Product Search widget
 */
if (!function_exists('mo_product_search')) {
    function mo_product_search() {
        if (class_exists('woocommerce')) {
            ?>
            <div class="site-search">
                <?php the_widget('WC_Widget_Product_Search', 'title='); ?>
            </div>
        <?php
        }
    }
}

/**
 * Display Header Cart
 */
if (!function_exists('mo_header_cart')) {
    function mo_header_cart() {
        if (class_exists('woocommerce')) {
            if (is_cart()) {
                $class = 'current-menu-item';
            }
            else {
                $class = '';
            }
            ?>
            <ul class="site-header-cart menu">
                <li class="<?php echo esc_attr($class); ?>">
                    <?php mo_cart_link(); ?>
                </li>
                <li>
                    <?php the_widget('WC_Widget_Cart', 'title='); ?>
                </li>
            </ul>
        <?php
        }
    }
}