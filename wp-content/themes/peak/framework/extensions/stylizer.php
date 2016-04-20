<?php

if (!function_exists('mo_get_background')) {

    /* Handy  function to set the background for any element with various background css attributes specified */
    function mo_get_background($background) {
        $output = '';
        if ($background) {
            $color = $background['background-color'];
            $image = $background['background-image'];

            if (!empty ($color)) {
                $output .= 'background-color:' . $color . ';';
                // Allow color to replace existing image unless a new one is specified
                if (empty($image))
                    $output .= 'background-image: none;';
            }
            // Do not allow the background attributes to change if no custom image or color is specified.
            // If desperate to change it, best place to change these attributes alone is in Custom CSS.
            if (!empty($color) || !empty($image)) {
                $repeat = $background['background-repeat'];
                $attachment = $background['background-attachment'];
                $position = $background['background-position'];
                $size = $background['background-size'];
                if (!empty ($repeat))
                    $output .= 'background-repeat:' . $repeat . ';';
                if (!empty ($attachment))
                    $output .= 'background-attachment:' . $attachment . ';';
                else
                    $output .= 'background-attachment: fixed;';
                if (!empty ($position))
                    $output .= 'background-position:' . $position . ';';
                if (!empty ($size))
                    $output .= 'background-size:' . $size . ';';
                else
                    $output .= 'background-size: cover;'; //assume background is big enough to be stretched across the entire width

            }
            if (!empty ($image)) {
                $output .= 'background-image:url(' . esc_url($image) . ');';
                // Remove the background color if no background color has been specified. Will help some transparent images to achieve the effect desired
                if (empty($color))
                    $output .= 'background-color: initial;';
            }
            return $output;
        }
        return $output;
    }
}

if (!function_exists('mo_custom_css_for_entry')) {
    function mo_custom_css_for_entry() {

        $output = '';

        $background_url = get_post_meta(get_queried_object_id(), 'mo_entry_title_background', true);
        $height = intval(get_post_meta(get_queried_object_id(), 'mo_entry_title_height', true));
        if (!empty($background_url))
            $background = 'background-image:url(' . esc_url($background_url) . '); background-position: center center;';
        if (!empty($background) || !empty ($height)) {
            $output .= mo_get_entry_title_background($background, $height);
        }

        $background = get_post_meta(get_queried_object_id(), 'mo_custom_heading_background', true);
        $background = mo_get_background($background);
        if (!empty($background)) {
            $output .= "\n" . '#custom-title-area  {';
            $output .= $background;
            //$output .= 'background-size:cover;'; //assume background is big enough to be stretched across the entire width
            $output .= '}';
        }

        return $output;

    }
}

if (!function_exists('mo_get_entry_title_background')) {

    function mo_get_entry_title_background($background, $height) {

        $output = '';

        if (is_singular(array('post', 'portfolio'))) {
            return $output;
        }

        if (!empty ($background)) {


            $output = "\n" . '#title-area  {';


            $output .= $background;
            //$output .= 'background-size:cover;'; //assume background is big enough to be stretched across the entire width
            $output .= 'border: none;'; // remove the existing skin based border and box-shadow
            $output .= 'box-shadow: none;';


            /* Set extra 100px height for the top padding to account for fixed 100px height header on the top */
            if (!empty($height)) {

                if ($height > 200) {
                    $outside_padding = round(($height - 84 - 20) / 2); // Subtract the existing height of single line entry title contents and bottom margin and then derive equal padding on top and bottom
                    $output .= 'padding: ' . ($outside_padding + 20) . 'px 0 ' . ($outside_padding). 'px 0;'; // Take bottom 20px margin into account
                }

                $output .= '}';

                if ($height > 450) {
                    $output .= "\n" . '@media only screen and (max-width: 1024px) {';
                    $output .= "\n" . '#title-area {';
                    $output .= 'padding: 220px 0 120px !important; } }';
                }

                if ($height > 300) {
                    $output .= "\n" . '@media only screen and (max-width: 767px) {';
                    $output .= "\n" . '#title-area {';
                    $output .= 'padding: 120px 0 80px !important; } }';
                }
            }
            else {
                $output .= '}';
            }

        }
        return $output;
    }
}

if (!function_exists('mo_custom_css')) {
    function mo_custom_css() {

        $system_fonts = array(
            'Arial Black',
            'Arial',
            'Helvetica',
            'Courier New',
            'Georgia',
            'Lucida Sans Unicode',
            'Tahoma',
            'Geneva',
            'Times New Roman',
            'Trebuchet MS',
            'Verdana'
        );

        $output = '';

        /* -------------------- Font Family Option and Font Import ------------------------------------ */

        $custom_fonts = array();


        $heading_font = mo_get_theme_option('mo_custom_heading_font');
        if (empty($heading_font)) {
            $heading_font = mo_get_theme_option('mo_heading_font', 'Lato');
            $heading_font = str_replace(" *", "", $heading_font);
            $custom_fonts [] = $heading_font;
        }


        if (!empty($heading_font)) {
            $heading_font_spacing = mo_get_theme_option('mo_heading_font_spacing', '0');
            $output .= "\n" . 'h1,h2,h3,h4,h5,h6 {';
            $output .= 'font-family:"' . $heading_font . '";';
            $output .= 'letter-spacing:' . $heading_font_spacing . 'px;';
            $output .= '}';

        }

        $body_font = mo_get_theme_option('mo_custom_body_font');
        if (empty($body_font)) {
            $body_font = mo_get_theme_option('mo_body_font', 'Lato');
            $body_font = str_replace(" *", "", $body_font);
            $custom_fonts [] = $body_font;
        }

        if (!empty($body_font)) {
            $output .= "\n" . 'body{';
            $output .= 'font-family:"' . $body_font . '";';
            $output .= '}';
        }

        $meta_font = mo_get_theme_option('mo_custom_meta_font');
        if (empty($meta_font)) {
            $meta_font = mo_get_theme_option('mo_meta_font', 'Lato');
            $meta_font = str_replace(" *", "", $meta_font);
            $custom_fonts [] = $meta_font;
        }

        if (!empty($meta_font)) {
            $output .= "\n" . 'cite, em, i, .rss-block, ul.post-list .published, ul.post-list .byline, ul.post-list .entry-meta, .entry-meta span a, .comment-author cite, .comment-reply-link, .comment-edit-link, .comment-reply-link:visited, .comment-edit-link:visited
{';
            $output .= 'font-family:"' . $meta_font . '";';
            $output .= '}';
        }


        $use_text_logo = mo_get_theme_option('mo_use_text_logo') ? true : false;
        if ($use_text_logo) {
            $logo_font = mo_get_theme_option('mo_logo_font', 'Lato');

            if (!empty($logo_font)) {
                $logo_font = str_replace(" *", "", $logo_font);
                $custom_fonts [] = $logo_font;
                $output .= "\n" . '#site-logo a {';
                $output .= 'font-family:"' . $logo_font . '";';
                $output .= '}';
            }
        }

        $fonts_to_import = '';
        foreach ($custom_fonts as $font_name) {
            if ($fonts_to_import != '')
                $fonts_to_import .= '|';
            if (!in_array($font_name, $system_fonts))
                $fonts_to_import .= preg_replace('/ /', '+', $font_name); // replace spaces in font names with + for importing Google fonts
        }

        $fonts_import = '';
        if (!empty($fonts_to_import))
            $fonts_import .= '@import url(//fonts.googleapis.com/css?family=' . $fonts_to_import . ');';


        /* -------------------- Body Font Styles ------------------------------------ */

        $body_font_size = mo_get_theme_option('mo_body_font_size', 'Default');

        if (!empty($body_font_size) || !empty($body_font_color)) {
            $output .= "\n" . 'body{';
            if ($body_font_size != 'Default')
                $output .= 'font-size:' . $body_font_size . 'px;';

            $output .= '}'; // end body font
        }

        /* -------------------- Header Styling ------------------------------------ */

        $header_height = mo_get_theme_option('mo_header_height');
        if (!empty ($header_height)) {
            $output .= "\n" . '#header .inner .wrap {';
            $output .= 'height:' . $header_height . 'px !important;';
            $output .= '}';
        }


        $tagline_height = mo_get_theme_option('mo_tagline_height', 300);
        $background_url = mo_get_theme_option('mo_tagline_background');

        if (!empty($background_url))
            $background = 'background-image:url(' . esc_url($background_url) . '); background-position: center center;';
        if (!empty($background)) {
            $output .= mo_get_entry_title_background($background, $tagline_height);
        }

        /* ------------------- SITE LOGO OPTIONS ------------------------------- */

        $use_text_logo = mo_get_theme_option('mo_use_text_logo') ? true : false;
        $logo_text_color = mo_get_theme_option('mo_logo_text_color');
        if ($use_text_logo && $logo_text_color) {
            $output .= "\n" . '#site-logo a {';
            if ($logo_text_color)
                $output .= 'color:' . $logo_text_color . ';';
            $output .= '}';
        }

        /* -------------------- Slider Area Home Page Options  ------------------------------------ */

        $nivo_slider_height = mo_get_theme_option('mo_nivo_slider_height');
        if ($nivo_slider_height) {

            $output .= "\n" . '#nivo-slider-wrap { background: none; /* get rid of that existing shadow */ }';
            $output .= "\n" . '#nivo-slider {';
            $output .= 'box-shadow: 0px 0px 15px -3px black; /* Replace the existing shadow */';
            $output .= '}';

        }

        $nivo_disable_caption = mo_get_theme_option('mo_disable_nivo_slider_caption');
        if ($nivo_disable_caption) {
            $output .= "\n" . '.nivo-caption { display: none; }';
        }

        /* -------------- Animations for in page elements -------------------- */

        if (mo_browser_supports_css3_animations()) {

            $disable_animations_on_page = mo_get_theme_option('mo_disable_animations_on_page');
            if (empty($disable_animations_on_page)) {
                $output .= "\n" . '#pricing-action .pointing-arrow img { opacity: 0 }';
            }
        }

        /* ------------------- Generate skin styling ----------------------------------- */

        $skin_color = mo_get_theme_skin();

        if ($skin_color !== 'default') {
            $output .= mo_generate_skin_styles($skin_color);
        }


        /* -------------------- Custom CSS defined by user ------------------------------------ */

        $custom_css = mo_get_theme_option('mo_custom_css');

        // Output the custom css last
        if ($custom_css) {
            $output .= "\n" . $custom_css;
        }

        $output = $fonts_import . "\n" . $output;

        $output .= mo_custom_css_for_entry();

        return $output;

    }
}
