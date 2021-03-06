<?php
/**
 * Mobile Menu Template
 *
 * Displays the Mobile Menu if it has active menu items.
 *
 * @package Peak
 * @subpackage Template
 */

$custom_page_menu = get_post_meta(get_queried_object_id(), 'mo_custom_primary_navigation_menu', true);

echo '<nav id="mobile-menu" class="menu-container clearfix">';
echo '<div class="menu-header">' . esc_html__('Menu', 'peak') . '</div>';

if (!empty($custom_page_menu) && $custom_page_menu !== 'default') {

    wp_nav_menu(array(
        'menu' => $custom_page_menu,
        'theme_location' => 'primary',
        'container' => false,
        'menu_class' => 'menu inner',
        'fallback_cb' => false
    ));

}
else {
    wp_nav_menu(array(
        'theme_location' => 'primary',
        'container' => false,
        'menu_class' => 'menu inner',
        'fallback_cb' => false
    ));

}

echo '</nav><!-- #mobile-menu -->';
