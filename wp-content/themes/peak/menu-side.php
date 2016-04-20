<?php
/**
 * Side Menu Template
 *
 * Displays the Side Menu if it has active menu items.
 *
 * @package Peak
 * @subpackage Template
 */

echo '<nav id="side-menu" class="menu-container">';

wp_nav_menu(array(
    'theme_location' => 'side',
    'container' => false,
    'menu_class' => 'menu',
    'fallback_cb' => false,
));

echo '</nav><!-- #side-menu -->';
