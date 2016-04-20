<?php
/*
* Various utility functions required by theme defined here
*
* @package Livemesh Framework
*/

if (!function_exists('mo_get_layout_manager')) {
    function mo_get_layout_manager() {

        $layout_manager = MO_LayoutManager::getInstance();
        return $layout_manager;
    }
}

if (!function_exists('mo_get_sidebar_manager')) {
    function mo_get_sidebar_manager() {

        $sidebar_manager = MO_SidebarManager::getInstance();
        return $sidebar_manager;
    }
}

if (!function_exists('mo_get_slider_manager')) {
    function mo_get_slider_manager() {

        $slider_manager = MO_Slider_Manager::getInstance();
        return $slider_manager;
    }
}

if (!function_exists('mo_get_framework_extender')) {
    function mo_get_framework_extender() {

        $framework_extender = MO_Framework_Extender::getInstance();
        return $framework_extender;
    }
}

if (!function_exists('mo_remove_wpautop')) {
    function mo_remove_wpautop($content) {

        $content = do_shortcode(shortcode_unautop($content));
        $content = preg_replace('#^<\/p>|^<br\s?\/?>|<p>$|<p>\s*(&nbsp;)?\s*<\/p>#', '', $content);
        return $content;
    }
}

if (!function_exists('mo_get_content_class')) {

    function mo_get_content_class() {
        $classes = array();
        $classes = apply_filters('mo_content_class', $classes);
        $style = '';
        foreach ($classes as $class) {
            $style .= $class . ' ';
        }
        return $style;
    }
}

if (!function_exists('mo_footer_content')) {

    function mo_footer_content() {

        // Default footer text
        $site_link = '<a class="site-link" href="' . esc_url(home_url('/')) . '" title="' . esc_attr(get_bloginfo('name')) . '" rel="home"><span>' . esc_html(get_bloginfo('name')) . '</span></a>';
        $wp_link = '<a class="wp-link" href="http://wordpress.org" title="' . esc_html__('Powered by WordPress', 'peak') . '"><span>' . esc_html__('WordPress', 'peak') . '</span></a>';
        $my_theme = wp_get_theme();
        $theme_link = '<a class="theme-link" href="' . esc_url($my_theme->ThemeURI) . '" title="' . esc_attr($my_theme->Name) . '"><span>' . esc_attr($my_theme->Name) . '</span></a>';

        $footer_text = esc_html__('Copyright &#169; ', 'peak') . date(esc_html__('Y', 'peak')) . ' ' . $site_link . esc_html__('. Powered by ', 'peak') . $wp_link . esc_html__(' and ', 'peak') . $theme_link;
        $footer_text = '<div id="footer-bottom-text">' . htmlspecialchars_decode(mo_get_theme_option('mo_footer_insert', $footer_text)) . '</div>';
        echo do_shortcode($footer_text);
    }
}

if (!function_exists('mo_sidenav_bottom_section')) {

    function mo_sidenav_bottom_section() {

        $footer_text = '<div id="sidenav-bottom-section">' . htmlspecialchars_decode(wp_kses_post(mo_get_theme_option('mo_sidenav_insert'))) . '</div>';
        if (!empty($footer_text))
            echo do_shortcode($footer_text);
    }
}


if (!function_exists('mo_get_column_style')) {
    /* Return the css class name to help achieve the number of columns specified */

    function mo_get_column_style($column_count = 2, $no_margin = false) {

        $no_margin = mo_to_boolean($no_margin); // make sure it is not string

        $style_class = 'threecol';
        switch ($column_count) {
            case 1:
                $style_class = "twelvecol";
                break;
            case 2:
                $style_class = "sixcol";
                break;
            case 3:
                $style_class = "fourcol";
                break;
            case 4;
                $style_class = "threecol";
                break;
            case 5:
                $style_class = "threecol"; /* Theme does not support 5 columns due to 12 column  grid */
                break;
            case 6;
                $style_class = "twocol";
                break;
        }
        $style_class = $no_margin ? ($style_class . ' zero-margin') : $style_class;

        return $style_class;
    }
}

if (!function_exists('mo_get_column_class')) {
    /* Return the css class name to help achieve the number of columns specified */

    function mo_get_column_class($column_size = 3, $no_margin = false) {

        $no_margin = mo_to_boolean($no_margin); // make sure it is not string

        $style_class = 'threecol';
        switch ($column_size) {
            case 1:
                $style_class = "onecol";
                break;
            case 2:
                $style_class = "twocol";
                break;
            case 3:
                $style_class = "threecol";
                break;
            case 4;
                $style_class = "fourcol";
                break;
            case 5:
                $style_class = "fivecol";
                break;
            case 6;
                $style_class = "sixcol";
                break;
            case 7:
                $style_class = "sevencol";
                break;
            case 8:
                $style_class = "eightcol";
                break;
            case 9;
                $style_class = "ninecol";
                break;
            case 10:
                $style_class = "tencol";
                break;
            case 11;
                $style_class = "elevencol";
                break;
            case 11;
                $style_class = "twelevecol";
                break;
        }
        $style_class = $no_margin ? ($style_class . ' zero-margin') : $style_class;

        return $style_class;
    }
}


if (!function_exists('mo_truncate_string')) {
    /* Original PHP code by Chirp Internet: www.chirp.com.au
    http://www.the-art-of-web.com/php/truncate/ */

    function mo_truncate_string($string, $limit, $strip_tags = true, $strip_shortcodes = true, $break = " ", $pad = "...") {
        if ($strip_shortcodes)
            $string = strip_shortcodes($string);

        if ($strip_tags)
            $string = strip_tags($string, '<p>'); // retain the p tag for formatting


        // return with no change if string is shorter than $limit
        if (strlen($string) <= $limit)
            return $string;
        elseif ($limit === 0 || $limit == '0')
            return '';


        // is $break present between $limit and the end of the string?
        if (false !== ($breakpoint = strpos($string, $break, $limit))) {
            if ($breakpoint < strlen($string) - 1) {
                $string = substr($string, 0, $breakpoint) . $pad;
            }
        }

        return $string;
    }
}


if (!function_exists('mo_to_boolean')) {

    /*
    * Converting string to boolean is a big one in PHP
    */

    function mo_to_boolean($value) {
        if (!isset($value))
            return false;
        if ($value == 'true' || $value == '1')
            $value = true;
        elseif ($value == 'false' || $value == '0')
            $value = false;
        return (bool)$value; // Make sure you do not touch the value if the value is not a string
    }
}


if (!function_exists('mo_display_contact_info')) {

    function mo_display_contact_info() {
        $phone_number = mo_get_theme_option('mo_phone_number', '');
        $email = mo_get_theme_option('mo_email_address', '');

        if (!empty ($phone_number) || !empty($email)) {
            $output = '<div id="contact-header">';
            $output .= '<ul>';
            if (!empty($phone_number)) {
                $output .= '<li><span class="icon-iphone"></span>' . esc_html($phone_number) . '</li>';
            }
            if (!empty($email) && is_email($email)) {
                $output .= '<li><span class="icon-email"></span>' . esc_html($email) . '</li>';
            }
            $output .= '</ul>';
            $output .= '</div>';
            echo wp_kses_post($output);
        }

    }
}

if (!function_exists('mo_get_chosen_page_section_ids')) {

    function mo_get_chosen_page_section_ids($postId) {

        $page_section_ids = get_post_meta($postId, '_page_section_order_field', true);
        /* TODO: Migration code - revisit later */
        if ($page_section_ids)
            $page_section_ids = explode(',', $page_section_ids);
        else
            $page_section_ids = get_post_meta($postId, 'mo_page_section_select_for_one_page', true);

        return $page_section_ids;
    }

}

if (!function_exists('mo_display_plugin_error')) {
    function mo_display_plugin_error($message = '') {
        if (empty($message))
            $message = esc_html__('Custom Post Types critical for this theme function are not loaded.', 'peak');
        $error = new WP_Error('plugin_deactivated', $message . esc_html__(' Pls install and activate the Livemesh Tools plugin from Appearance->Install Plugins page in WordPress admin.', 'peak'));
        mo_display_error($error);
    }
}

if (!function_exists('mo_display_error')) {
    function mo_display_error($error) {
        if (is_wp_error($error)) {
            $output = '<div class="wp-error">';
            $output .= '<div class="inner">';
            $output .= '<p><strong>' . esc_html__('Sorry, there has been an error.', 'peak') . '</strong><br />';
            $output .= esc_html($error->get_error_message()) . '</p>';
            $output .= '</div>';
            $output .= '</div>';
            echo wp_kses_post($output);
        }
    }
}

if (!function_exists('mo_display_social_media_buttons')) {
    function mo_display_rrssb_social_media_buttons($post_id = null) {
        if (empty($post_id))
            $post_id = get_the_ID();
        $post_title = get_the_title($post_id);
        $post_url = get_permalink($post_id);
        $post_excerpt = get_the_excerpt();
        $featured_image_id = get_post_thumbnail_id($post_id);
        $feature_image_src = wp_get_attachment_image_src($featured_image_id, 'full');
        if ($feature_image_src)
            $feature_image_src = $feature_image_src[0];

        ?>

        <ul class="rrssb-buttons">
            <li class="rrssb-email">
                <!-- Replace subject with your message using URL Endocding: http://meyerweb.com/eric/tools/dencoder/ -->
                <a href="mailto:?subject=<?php echo urlencode($post_title); ?>&amp;body=<?php echo urlencode($post_url); ?>">
            <span class="rrssb-icon">
                <i class="icon-envelope-o"></i>
            </span>
                    <span class="rrssb-text">email</span>
                </a>
            </li>
            <li class="rrssb-facebook">
                <!--  Replace with your URL. For best results, make sure you page has the proper FB Open Graph tags in header:
                      https://developers.facebook.com/docs/opengraph/howtos/maximizing-distribution-media-content/ -->
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($post_url); ?>"
                   class="popup">
            <span class="rrssb-icon">
                <i class="icon-facebook5"></i>
            </span>
                    <span class="rrssb-text">facebook</span>
                </a>
            </li>
            <li class="rrssb-linkedin">
                <!-- Replace href with your meta and URL information -->
                <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode($post_url); ?>&amp;title=<?php echo urlencode($post_title); ?>&amp;summary=<?php echo urlencode($post_excerpt); ?>"
                   class="popup">
            <span class="rrssb-icon">
                <i class="icon-linkedin4"></i>
            </span>
                    <span class="rrssb-text">linkedin</span>
                </a>
            </li>
            <li class="rrssb-twitter">
                <!-- Replace href with your Meta and URL information  -->
                <a href="http://twitter.com/home?status=<?php echo urlencode($post_title); ?>%3A%20<?php echo urlencode($post_url); ?>"
                   class="popup">
            <span class="rrssb-icon">
                <i class="icon-twitter5"></i>
            </span>
                    <span class="rrssb-text">twitter</span>
                </a>
            </li>
            <li class="rrssb-googleplus">
                <!-- Replace href with your meta and URL information.  -->
                <a href="https://plus.google.com/share?url=<?php echo urlencode($post_title); ?>%20<?php echo urlencode($post_url); ?>"
                   class="popup">
            <span class="rrssb-icon">
                <i class="icon-googleplus2"></i>
            </span>
                    <span class="rrssb-text">google+</span>
                </a>
            </li>
            <li class="rrssb-pinterest">
                <!-- Replace href with your meta and URL information.  -->
                <a href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode($post_url); ?>&amp;media=<?php echo urlencode($feature_image_src); ?>&amp;description=<?php echo urlencode($post_title); ?>">
            <span class="rrssb-icon">
                <i class="icon-pinterest3"></i>
            </span>
                    <span class="rrssb-text">pinterest</span>
                </a>
            </li>
        </ul>
        <!-- Buttons end here -->
    <?php
    }
}


